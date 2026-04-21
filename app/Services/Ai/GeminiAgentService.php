<?php

namespace App\Services\Ai;

use App\Models\AiConversation;
use App\Models\AiProviderRun;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use RuntimeException;

class GeminiAgentService
{
    public function respond(AiConversation $conversation, array $messages, string $action = 'chat'): string
    {
        $prompt = $this->plainPrompt($conversation, $messages, $action);

        if (! $this->configured()) {
            return $this->demoResponse($conversation, $action);
        }

        $run = $this->startRun($conversation, $action, $prompt);

        try {
            $response = $this->generate($prompt, 0.7, 4096);
            $text = $this->extractText($response);

            $this->completeRun($run, $response, $text);

            return trim($text);
        } catch (\Throwable $exception) {
            $this->failRun($run, $exception);

            throw new RuntimeException('Gemini gagal merespons: ' . $exception->getMessage(), previous: $exception);
        }
    }

    public function draft(AiConversation $conversation, array $messages, string $type): array
    {
        $prompt = $this->draftPrompt($conversation, $messages, $type);

        if (! $this->configured()) {
            return $this->demoDraft($conversation, $type);
        }

        $run = $this->startRun($conversation, 'draft', $prompt);

        try {
            $response = $this->generate($prompt, 0.45, 8192, [
                'responseMimeType' => 'application/json',
                'responseSchema' => $this->draftSchema(),
            ]);
            $text = $this->extractText($response);
            $draft = $this->decodeDraft($text);

            $this->completeRun($run, $response, $text);

            return $draft;
        } catch (\Throwable $exception) {
            $this->failRun($run, $exception);

            throw new RuntimeException('Gemini gagal membuat draft: ' . $exception->getMessage(), previous: $exception);
        }
    }

    public function review(AiConversation $conversation, string $draftContent): string
    {
        $prompt = $this->reviewPrompt($conversation, $draftContent);

        if (! $this->configured()) {
            return $this->demoReview();
        }

        $run = $this->startRun($conversation, 'review', $prompt);

        try {
            $response = $this->generate($prompt, 0.35, 4096);
            $text = $this->extractText($response);

            $this->completeRun($run, $response, $text);

            return trim($text);
        } catch (\Throwable $exception) {
            $this->failRun($run, $exception);

            throw new RuntimeException('Gemini gagal mereview draft: ' . $exception->getMessage(), previous: $exception);
        }
    }

    private function configured(): bool
    {
        return filled(config('services.gemini.key'));
    }

    private function generate(string $prompt, float $temperature, int $maxTokens, array $extraConfig = []): array
    {
        $lastException = null;

        foreach ($this->models() as $model) {
            try {
                return $this->generateWithModel($model, $prompt, $temperature, $maxTokens, $extraConfig);
            } catch (RequestException $exception) {
                $lastException = $exception;

                if (! $this->retryableStatus($exception->response?->status())) {
                    throw $exception;
                }
            }
        }

        throw $lastException ?? new RuntimeException('Semua model Gemini gagal merespons.');
    }

    private function generateWithModel(string $model, string $prompt, float $temperature, int $maxTokens, array $extraConfig = []): array
    {
        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent";

        $response = Http::withHeaders([
                'x-goog-api-key' => (string) config('services.gemini.key'),
            ])
            ->withOptions($this->noProxyOptions())
            ->retry(2, 1200, fn ($exception) => $exception instanceof RequestException
                && $this->retryableStatus($exception->response?->status()))
            ->timeout(120)
            ->post($url, [
                'contents' => [
                    [
                        'role' => 'user',
                        'parts' => [
                            ['text' => $prompt],
                        ],
                    ],
                ],
                'generationConfig' => array_merge([
                    'temperature' => $temperature,
                    'maxOutputTokens' => $maxTokens,
                ], $extraConfig),
            ])
            ->throw()
            ->json();

        $response['_model'] = $model;

        return $response;
    }

    private function models(): array
    {
        return collect([
                config('services.gemini.model'),
                ...((array) config('services.gemini.fallback_models', [])),
            ])
            ->filter()
            ->map(fn ($model) => trim((string) $model))
            ->unique()
            ->values()
            ->all();
    }

    private function retryableStatus(?int $status): bool
    {
        return in_array($status, [429, 500, 502, 503, 504], true);
    }

    private function noProxyOptions(): array
    {
        return [
            'curl' => [
                CURLOPT_PROXY => '',
                CURLOPT_NOPROXY => '*',
            ],
        ];
    }

    private function startRun(AiConversation $conversation, string $action, string $input): AiProviderRun
    {
        return AiProviderRun::create([
            'ai_conversation_id' => $conversation->id,
            'provider' => 'gemini',
            'model' => config('services.gemini.model'),
            'action' => $action,
            'input' => $input,
            'status' => 'running',
        ]);
    }

    private function completeRun(AiProviderRun $run, array $response, string $text): void
    {
        $run->update([
            'output' => $text,
            'status' => 'completed',
            'model' => data_get($response, '_model', $run->model),
            'tokens_input' => data_get($response, 'usageMetadata.promptTokenCount'),
            'tokens_output' => data_get($response, 'usageMetadata.candidatesTokenCount'),
        ]);
    }

    private function failRun(AiProviderRun $run, \Throwable $exception): void
    {
        $run->update([
            'status' => 'failed',
            'error' => Str::limit($exception->getMessage(), 1000),
        ]);
    }

    private function plainPrompt(AiConversation $conversation, array $messages, string $action): string
    {
        return $this->baseInstruction($conversation) . "\n\n"
            . "Mode kerja: {$action}.\n"
            . "Tanggapi sebagai tim redaksi AI. Jika tujuan, target pembaca, atau gaya belum jelas, tanyakan dulu sebelum menulis penuh.\n\n"
            . $this->history($messages);
    }

    private function draftPrompt(AiConversation $conversation, array $messages, string $type): string
    {
        return $this->baseInstruction($conversation) . "\n\n"
            . "Buat draft {$type} untuk Pahamit. Output wajib JSON valid sesuai schema.\n"
            . "Gunakan markdown untuk field content. Jangan mengarang sumber. Jika belum ada sumber, isi sources sebagai array kosong dan beri catatan di content bahwa perlu verifikasi manual.\n"
            . "Optimalkan judul, excerpt, focus keyword, SEO title, SEO description, image_prompt, CTA, dan estimasi waktu baca.\n"
            . "Field metadata.image_prompt wajib berisi prompt gambar 16:9 sesuai isi artikel, tanpa teks/logo/watermark, dengan gaya clean modern technology editorial Pahamit.\n\n"
            . $this->history($messages);
    }

    private function reviewPrompt(AiConversation $conversation, string $draftContent): string
    {
        return $this->baseInstruction($conversation) . "\n\n"
            . "Mode kerja: review editorial.\n"
            . "Review draft berikut untuk Pahamit.com. Fokus pada kejelasan, alur, SEO, akurasi teknis, dan gaya bahasa Indonesia natural.\n\n"
            . "Berikan output dengan format:\n"
            . "1. Ringkasan kualitas\n"
            . "2. Risiko fakta/teknis yang perlu dicek\n"
            . "3. Saran perbaikan struktur dan SEO\n"
            . "4. Versi paragraf/section yang direvisi bila perlu\n\n"
            . "Draft:\n{$draftContent}";
    }

    private function baseInstruction(AiConversation $conversation): string
    {
        return "Kamu adalah Gemini, tim redaksi AI utama Pahamit.com.\n"
            . "Brand: Pahamit.com. Slogan: Bukan Sekadar Belajar.\n"
            . "Fokus: berita IT, panduan belajar IT, dan jualan alat/jasa/template IT.\n"
            . "Peranmu seperti tim redaksi internal: perencana konten, penulis, editor, reviewer SEO, dan penyusun CTA.\n"
            . "Tugasmu berdiskusi dengan admin tentang tujuan, tema, target pembaca, gaya bahasa, angle, dan CTA sebelum membuat draft.\n"
            . "Jangan langsung publish. Semua output harus siap direview admin.\n"
            . "Jenis konten percakapan: {$conversation->type}.\n"
            . "Tujuan: " . ($conversation->goal ?: '-') . "\n"
            . "Target pembaca: " . ($conversation->audience ?: '-') . "\n"
            . "Gaya bahasa: " . ($conversation->tone ?: '-');
    }

    private function history(array $messages): string
    {
        return collect($messages)
            ->map(fn ($message) => strtoupper($message['role']) . ': ' . $message['content'])
            ->implode("\n\n");
    }

    private function extractText(array $response): string
    {
        return collect(data_get($response, 'candidates.0.content.parts', []))
            ->pluck('text')
            ->filter()
            ->implode("\n");
    }

    private function decodeDraft(string $text): array
    {
        $clean = trim($text);
        $clean = preg_replace('/^```(?:json)?\s*/i', '', $clean) ?? $clean;
        $clean = preg_replace('/\s*```$/', '', $clean) ?? $clean;

        return json_decode($clean, true, flags: JSON_THROW_ON_ERROR);
    }

    private function draftSchema(): array
    {
        return [
            'type' => 'OBJECT',
            'required' => ['title', 'category', 'excerpt', 'content', 'sources', 'metadata'],
            'properties' => [
                'title' => ['type' => 'STRING'],
                'category' => ['type' => 'STRING'],
                'excerpt' => ['type' => 'STRING'],
                'content' => ['type' => 'STRING'],
                'sources' => [
                    'type' => 'ARRAY',
                    'items' => [
                        'type' => 'OBJECT',
                        'required' => ['title', 'url'],
                        'properties' => [
                            'title' => ['type' => 'STRING'],
                            'url' => ['type' => 'STRING'],
                        ],
                    ],
                ],
                'metadata' => [
                    'type' => 'OBJECT',
                'required' => ['seo_title', 'seo_description', 'focus_keyword', 'image_prompt', 'cta', 'reading_time'],
                'properties' => [
                    'seo_title' => ['type' => 'STRING'],
                    'seo_description' => ['type' => 'STRING'],
                    'focus_keyword' => ['type' => 'STRING'],
                    'image_prompt' => ['type' => 'STRING'],
                    'cta' => ['type' => 'STRING'],
                    'reading_time' => ['type' => 'STRING'],
                ],
                ],
            ],
        ];
    }

    private function demoResponse(AiConversation $conversation, string $action): string
    {
        return "Mode demo aktif karena `GEMINI_API_KEY` belum diisi.\n\n"
            . "Untuk tahap {$action}, saya sarankan kita kunci dulu:\n"
            . "1. Tujuan konten: edukasi, trafik, lead jasa, atau jualan template.\n"
            . "2. Target pembaca: pemula, teknisi, admin kantor, siswa SMK, atau owner bisnis.\n"
            . "3. Gaya: santai teknis, profesional, atau tutorial praktis.\n\n"
            . "Konteks saat ini: {$conversation->type}. Setelah API key diisi, Gemini akan menjalankan seluruh alur agent.";
    }

    private function demoDraft(AiConversation $conversation, string $type): array
    {
        $label = match ($type) {
            'tutorial' => 'Panduan',
            'jualan' => 'Solusi IT',
            default => 'Berita IT',
        };

        return [
            'title' => "{$label}: Draft Demo dari Gemini Agent Pahamit",
            'category' => $type === 'tutorial' ? 'Panduan IT' : 'IT',
            'excerpt' => 'Draft demo ini dibuat agar alur Gemini Agent bisa diuji sebelum API key diisi.',
            'content' => "## Catatan Demo\n\nIsi `GEMINI_API_KEY` di `.env` agar seluruh AI Agent aktif memakai Gemini.\n\n## Struktur Draft\n\n- Tujuan konten\n- Target pembaca\n- Outline\n- Isi utama\n- Optimasi SEO\n- CTA Pahamit\n\nDraft ini belum untuk publish.",
            'sources' => [],
            'metadata' => [
                'seo_title' => "{$label} Pahamit",
                'seo_description' => 'Draft demo Gemini Agent Pahamit.',
                'focus_keyword' => strtolower($label) . ' pahamit',
                'image_prompt' => 'Clean modern technology editorial illustration for Pahamit, blue cyan accents, no text, 16:9, matching the article topic.',
                'cta' => 'Diskusikan kebutuhan IT Anda bersama Pahamit.',
                'reading_time' => '2 menit',
            ],
        ];
    }

    private function demoReview(): string
    {
        return "Mode demo review aktif karena `GEMINI_API_KEY` belum diisi.\n\n"
            . "Review contoh:\n"
            . "1. Pastikan pembuka langsung menjawab masalah pembaca.\n"
            . "2. Tambahkan contoh teknis agar panduan terasa praktis.\n"
            . "3. Untuk berita, simpan sumber dan tanggal akses.\n"
            . "4. Perkuat focus keyword, meta description, dan CTA tanpa membuat artikel terasa terlalu jualan.";
    }
}
