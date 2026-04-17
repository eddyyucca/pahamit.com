<?php

namespace App\Services\Ai;

use App\Models\AiConversation;
use App\Models\AiProviderRun;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use RuntimeException;

class OpenAiAgentService
{
    public function respond(AiConversation $conversation, array $messages, string $action = 'chat'): string
    {
        $prompt = $this->plainPrompt($conversation, $messages, $action);

        if (! $this->configured()) {
            return $this->demoResponse($conversation, $action);
        }

        $run = $this->startRun($conversation, $action, $prompt);

        try {
            $response = Http::withToken((string) config('services.openai.key'))
                ->withOptions($this->noProxyOptions())
                ->timeout(90)
                ->post('https://api.openai.com/v1/responses', [
                    'model' => config('services.openai.model'),
                    'input' => $prompt,
                    'text' => [
                        'format' => ['type' => 'text'],
                        'verbosity' => 'medium',
                    ],
                ])
                ->throw()
                ->json();

            $text = $response['output_text'] ?? $this->extractText($response);

            $run->update([
                'output' => $text,
                'status' => 'completed',
                'tokens_input' => data_get($response, 'usage.input_tokens'),
                'tokens_output' => data_get($response, 'usage.output_tokens'),
            ]);

            return trim($text);
        } catch (\Throwable $exception) {
            $run->update([
                'status' => 'failed',
                'error' => Str::limit($exception->getMessage(), 1000),
            ]);

            throw new RuntimeException('OpenAI gagal merespons: ' . $exception->getMessage(), previous: $exception);
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
            $response = Http::withToken((string) config('services.openai.key'))
                ->withOptions($this->noProxyOptions())
                ->timeout(120)
                ->post('https://api.openai.com/v1/responses', [
                    'model' => config('services.openai.model'),
                    'input' => $prompt,
                    'text' => [
                        'format' => [
                            'type' => 'json_schema',
                            'name' => 'pahamit_content_draft',
                            'strict' => true,
                            'schema' => [
                                'type' => 'object',
                                'additionalProperties' => false,
                                'required' => ['title', 'category', 'excerpt', 'content', 'sources', 'metadata'],
                                'properties' => [
                                    'title' => ['type' => 'string'],
                                    'category' => ['type' => 'string'],
                                    'excerpt' => ['type' => 'string'],
                                    'content' => ['type' => 'string'],
                                    'sources' => [
                                        'type' => 'array',
                                        'items' => [
                                            'type' => 'object',
                                            'additionalProperties' => false,
                                            'required' => ['title', 'url'],
                                            'properties' => [
                                                'title' => ['type' => 'string'],
                                                'url' => ['type' => 'string'],
                                            ],
                                        ],
                                    ],
                                    'metadata' => [
                                        'type' => 'object',
                                        'additionalProperties' => false,
                                        'required' => ['seo_title', 'seo_description', 'cta', 'reading_time'],
                                        'properties' => [
                                            'seo_title' => ['type' => 'string'],
                                            'seo_description' => ['type' => 'string'],
                                            'cta' => ['type' => 'string'],
                                            'reading_time' => ['type' => 'string'],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ])
                ->throw()
                ->json();

            $text = $response['output_text'] ?? $this->extractText($response);
            $draft = json_decode($text, true, flags: JSON_THROW_ON_ERROR);

            $run->update([
                'output' => $text,
                'status' => 'completed',
                'tokens_input' => data_get($response, 'usage.input_tokens'),
                'tokens_output' => data_get($response, 'usage.output_tokens'),
            ]);

            return $draft;
        } catch (\Throwable $exception) {
            $run->update([
                'status' => 'failed',
                'error' => Str::limit($exception->getMessage(), 1000),
            ]);

            throw new RuntimeException('OpenAI gagal membuat draft: ' . $exception->getMessage(), previous: $exception);
        }
    }

    private function configured(): bool
    {
        return filled(config('services.openai.key'));
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
            'provider' => 'openai',
            'model' => config('services.openai.model'),
            'action' => $action,
            'input' => $input,
            'status' => 'running',
        ]);
    }

    private function plainPrompt(AiConversation $conversation, array $messages, string $action): string
    {
        return $this->baseInstruction($conversation) . "\n\n"
            . "Mode kerja: {$action}.\n"
            . "Tanggapi sebagai agen redaksi. Jika tujuan, target pembaca, atau gaya belum jelas, tanyakan dulu sebelum menulis penuh.\n\n"
            . $this->history($messages);
    }

    private function draftPrompt(AiConversation $conversation, array $messages, string $type): string
    {
        return $this->baseInstruction($conversation) . "\n\n"
            . "Buat draft {$type} untuk Pahamit. Output wajib JSON sesuai schema.\n"
            . "Gunakan markdown untuk field content. Jangan mengarang sumber. Jika belum ada sumber, isi sources sebagai array kosong dan beri catatan di content bahwa perlu verifikasi manual.\n\n"
            . $this->history($messages);
    }

    private function baseInstruction(AiConversation $conversation): string
    {
        return "Kamu adalah ChatGPT, agen utama redaksi Pahamit.com.\n"
            . "Brand: Pahamit.com. Slogan: Bukan Sekadar Belajar.\n"
            . "Fokus: berita IT, panduan belajar IT, dan jualan alat/jasa/template IT.\n"
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
        return collect($response['output'] ?? [])
            ->flatMap(fn ($item) => $item['content'] ?? [])
            ->pluck('text')
            ->filter()
            ->implode("\n");
    }

    private function demoResponse(AiConversation $conversation, string $action): string
    {
        return "Mode demo aktif karena `OPENAI_API_KEY` belum diisi.\n\n"
            . "Untuk tahap {$action}, saya sarankan kita kunci dulu:\n"
            . "1. Tujuan konten: edukasi, trafik, lead jasa, atau jualan template.\n"
            . "2. Target pembaca: pemula, teknisi, admin kantor, siswa SMK, atau owner bisnis.\n"
            . "3. Gaya: santai teknis, profesional, atau tutorial praktis.\n\n"
            . "Konteks saat ini: {$conversation->type}. Setelah API key diisi, agen akan menjawab penuh dari ChatGPT.";
    }

    private function demoDraft(AiConversation $conversation, string $type): array
    {
        $label = match ($type) {
            'tutorial' => 'Panduan',
            'jualan' => 'Solusi IT',
            default => 'Berita IT',
        };

        return [
            'title' => "{$label}: Draft Demo dari AI Agent Pahamit",
            'category' => $type === 'tutorial' ? 'Panduan IT' : 'IT',
            'excerpt' => 'Draft demo ini dibuat agar alur AI Agent bisa diuji sebelum API key diisi.',
            'content' => "## Catatan Demo\n\nIsi `OPENAI_API_KEY` dan `ANTHROPIC_API_KEY` di `.env` agar ChatGPT dan Claude aktif.\n\n## Struktur Draft\n\n- Tujuan konten\n- Target pembaca\n- Outline\n- Isi utama\n- CTA Pahamit\n\nDraft ini belum untuk publish.",
            'sources' => [],
            'metadata' => [
                'seo_title' => "{$label} Pahamit",
                'seo_description' => 'Draft demo AI Agent Pahamit.',
                'cta' => 'Diskusikan kebutuhan IT Anda bersama Pahamit.',
                'reading_time' => '2 menit',
            ],
        ];
    }
}
