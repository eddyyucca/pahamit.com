<?php

namespace App\Services\Ai;

use App\Models\AiConversation;
use App\Models\AiProviderRun;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use RuntimeException;

class ClaudeAgentService
{
    public function review(AiConversation $conversation, string $draftContent): string
    {
        $prompt = $this->reviewPrompt($conversation, $draftContent);

        if (! $this->configured()) {
            return $this->demoReview();
        }

        $run = AiProviderRun::create([
            'ai_conversation_id' => $conversation->id,
            'provider' => 'anthropic',
            'model' => config('services.anthropic.model'),
            'action' => 'review',
            'input' => $prompt,
            'status' => 'running',
        ]);

        try {
            $response = Http::withHeaders([
                    'x-api-key' => (string) config('services.anthropic.key'),
                    'anthropic-version' => (string) config('services.anthropic.version'),
                    'content-type' => 'application/json',
                ])
                ->timeout(120)
                ->withOptions($this->noProxyOptions())
                ->post('https://api.anthropic.com/v1/messages', [
                    'model' => config('services.anthropic.model'),
                    'max_tokens' => 1800,
                    'system' => 'Kamu adalah Claude, editor reviewer untuk Pahamit.com. Fokus pada kejelasan, alur, akurasi teknis, dan gaya bahasa Indonesia natural. Jangan publish, hanya review.',
                    'messages' => [
                        ['role' => 'user', 'content' => $prompt],
                    ],
                ])
                ->throw()
                ->json();

            $text = collect($response['content'] ?? [])
                ->where('type', 'text')
                ->pluck('text')
                ->implode("\n");

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

            throw new RuntimeException('Claude gagal mereview draft: ' . $exception->getMessage(), previous: $exception);
        }
    }

    private function configured(): bool
    {
        return filled(config('services.anthropic.key'));
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

    private function reviewPrompt(AiConversation $conversation, string $draftContent): string
    {
        return "Review draft berikut untuk Pahamit.com.\n\n"
            . "Jenis konten: {$conversation->type}\n"
            . "Tujuan: " . ($conversation->goal ?: '-') . "\n"
            . "Target pembaca: " . ($conversation->audience ?: '-') . "\n"
            . "Gaya bahasa: " . ($conversation->tone ?: '-') . "\n\n"
            . "Berikan output dengan format:\n"
            . "1. Ringkasan kualitas\n"
            . "2. Risiko fakta/teknis yang perlu dicek\n"
            . "3. Saran perbaikan struktur\n"
            . "4. Versi paragraf/section yang direvisi bila perlu\n\n"
            . "Draft:\n{$draftContent}";
    }

    private function demoReview(): string
    {
        return "Mode demo Claude aktif karena `ANTHROPIC_API_KEY` belum diisi.\n\n"
            . "Review contoh:\n"
            . "1. Pastikan pembuka langsung menjawab masalah pembaca.\n"
            . "2. Tambahkan contoh teknis agar panduan terasa praktis.\n"
            . "3. Untuk berita, simpan sumber dan tanggal akses.\n"
            . "4. CTA sebaiknya halus: arahkan ke jasa/template Pahamit setelah pembaca mendapat nilai edukasi.";
    }
}
