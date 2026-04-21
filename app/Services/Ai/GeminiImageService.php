<?php

namespace App\Services\Ai;

use App\Models\AiConversation;
use App\Support\PublicStorageMirror;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;

class GeminiImageService
{
    public function generateForDraft(AiConversation $conversation, array $draft): array
    {
        $prompt = $this->prompt($conversation, $draft);

        if ($this->configured()) {
            try {
                $response = $this->generate($prompt);
                $image = $this->extractImage($response);

                if (! $image) {
                    throw new RuntimeException('Gemini tidak mengembalikan data gambar.');
                }

                $path = $this->storeImage($image['data'], $image['mime_type'], $draft['title'] ?? 'ai-image');

                return [
                    'image_path' => $path,
                    'image_prompt' => $prompt,
                    'image_generation_model' => (string) data_get($response, '_model', config('services.gemini.image_model')),
                    'image_mime_type' => $image['mime_type'],
                ];
            } catch (\Throwable $exception) {
                return $this->fallbackImage($conversation, $draft, $prompt, $exception->getMessage());
            }
        }

        return $this->fallbackImage($conversation, $draft, $prompt, 'GEMINI_IMAGE_MODEL atau GEMINI_API_KEY belum tersedia.');
    }

    public function prompt(AiConversation $conversation, array $draft): string
    {
        $title = trim((string) ($draft['title'] ?? $conversation->title));
        $excerpt = trim((string) ($draft['excerpt'] ?? ''));
        $category = trim((string) ($draft['category'] ?? $conversation->type));
        $keyword = trim((string) data_get($draft, 'metadata.focus_keyword', ''));
        $draftPrompt = trim((string) data_get($draft, 'metadata.image_prompt', ''));

        return "Create a 16:9 featured image for an Indonesian technology education website.\n\n"
            . "Fixed Pahamit editorial style:\n"
            . "- clean modern technology editorial illustration\n"
            . "- professional Indonesian IT learning and digital publishing mood\n"
            . "- realistic but polished digital workspace\n"
            . "- consistent soft lighting, crisp details, balanced contrast\n"
            . "- blue and cyan brand accents with neutral background\n"
            . "- no text, no letters, no logo, no watermark, no UI text\n"
            . "- suitable as a news/tutorial website cover image\n\n"
            . "Article type: {$conversation->type}\n"
            . "Category: " . ($category ?: '-') . "\n"
            . "Title: " . ($title ?: '-') . "\n"
            . "Focus keyword: " . ($keyword ?: '-') . "\n"
            . "Draft image prompt: " . ($draftPrompt ?: '-') . "\n"
            . "Article summary: " . ($excerpt ?: Str::limit(strip_tags((string) ($draft['content'] ?? '')), 420)) . "\n\n"
            . "Visual direction: show a clear editorial scene that represents the article topic, using symbolic technology objects, code/editor screens without readable text, devices, network/database/cloud/AI elements where relevant. Keep the composition reusable and visually consistent with the fixed style.";
    }

    private function configured(): bool
    {
        return filled(config('services.gemini.key')) && filled(config('services.gemini.image_model'));
    }

    private function generate(string $prompt): array
    {
        $lastException = null;

        foreach ($this->models() as $model) {
            try {
                $response = $this->generateWithModel($model, $prompt);
                $response['_model'] = $model;

                return $response;
            } catch (RequestException $exception) {
                $lastException = $exception;

                if (! in_array($exception->response?->status(), [429, 500, 502, 503, 504], true)) {
                    throw $exception;
                }
            }
        }

        throw $lastException ?? new RuntimeException('Semua model gambar Gemini gagal merespons.');
    }

    private function generateWithModel(string $model, string $prompt): array
    {
        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent";

        return Http::withHeaders([
                'x-goog-api-key' => (string) config('services.gemini.key'),
            ])
            ->withOptions($this->noProxyOptions())
            ->retry(2, 1500, fn ($exception) => $exception instanceof RequestException
                && in_array($exception->response?->status(), [429, 500, 502, 503, 504], true))
            ->timeout(180)
            ->post($url, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt],
                        ],
                    ],
                ],
                'generationConfig' => [
                    'responseModalities' => ['TEXT', 'IMAGE'],
                ],
            ])
            ->throw()
            ->json();
    }

    private function models(): array
    {
        return collect([
                config('services.gemini.image_model'),
                ...((array) config('services.gemini.image_fallback_models', [])),
            ])
            ->filter()
            ->map(fn ($model) => trim((string) $model))
            ->unique()
            ->values()
            ->all();
    }

    private function extractImage(array $response): ?array
    {
        foreach (data_get($response, 'candidates.0.content.parts', []) as $part) {
            $inlineData = $part['inlineData'] ?? $part['inline_data'] ?? null;

            if (! is_array($inlineData) || empty($inlineData['data'])) {
                continue;
            }

            return [
                'data' => (string) $inlineData['data'],
                'mime_type' => (string) ($inlineData['mimeType'] ?? $inlineData['mime_type'] ?? 'image/png'),
            ];
        }

        return null;
    }

    private function storeImage(string $base64, string $mimeType, string $title): string
    {
        $extension = match ($mimeType) {
            'image/jpeg', 'image/jpg' => 'jpg',
            'image/webp' => 'webp',
            default => 'png',
        };

        $filename = trim(Str::slug($title), '-') ?: 'ai-image';
        $path = 'ai-images/' . now()->format('Y/m') . '/' . $filename . '-' . Str::random(8) . '.' . $extension;

        $bytes = base64_decode($base64, true);

        if ($bytes === false) {
            throw new RuntimeException('Data gambar dari Gemini tidak valid.');
        }

        Storage::disk('public')->put($path, $bytes);
        PublicStorageMirror::put($path, $bytes);

        return $path;
    }

    private function fallbackImage(AiConversation $conversation, array $draft, string $prompt, string $reason): array
    {
        $title = trim((string) ($draft['title'] ?? $conversation->title));
        $path = $this->storeFallbackSvg($conversation, $draft, $title);

        return [
            'image_path' => $path,
            'image_prompt' => $prompt,
            'image_generation_model' => 'local-pahamit-svg-fallback',
            'image_mime_type' => 'image/svg+xml',
            'image_error' => Str::limit($reason, 500),
        ];
    }

    private function storeFallbackSvg(AiConversation $conversation, array $draft, string $title): string
    {
        $filename = trim(Str::slug($title), '-') ?: 'ai-image';
        $path = 'ai-images/' . now()->format('Y/m') . '/' . $filename . '-' . Str::random(8) . '.svg';

        $svg = $this->fallbackSvg($conversation, $draft);

        Storage::disk('public')->put($path, $svg);
        PublicStorageMirror::put($path, $svg);

        return $path;
    }

    private function fallbackSvg(AiConversation $conversation, array $draft): string
    {
        $text = Str::lower(implode(' ', [
            $conversation->type,
            $draft['title'] ?? '',
            $draft['category'] ?? '',
            $draft['excerpt'] ?? '',
            data_get($draft, 'metadata.focus_keyword', ''),
        ]));

        $isLaravel = Str::contains($text, ['laravel', 'php', 'crud', 'blade']);
        $isAi = Str::contains($text, ['ai', 'agent', 'gemini', 'automation']);
        $isSecurity = Str::contains($text, ['security', 'cyber', 'malware', 'hacker', 'aman']);
        $isNetwork = Str::contains($text, ['network', 'jaringan', 'router', 'server', 'cloud']);
        $isData = Str::contains($text, ['database', 'data', 'sql', 'mysql']);

        $accent = match (true) {
            $isSecurity => '#14b8a6',
            $isAi => '#8b5cf6',
            $isLaravel => '#ef4444',
            $isData => '#06b6d4',
            $isNetwork => '#2563eb',
            default => '#0ea5e9',
        };

        $accent2 = match (true) {
            $isSecurity => '#22c55e',
            $isAi => '#06b6d4',
            $isLaravel => '#0ea5e9',
            $isData => '#6366f1',
            $isNetwork => '#14b8a6',
            default => '#22d3ee',
        };

        $hash = abs(crc32($text ?: 'pahamit'));
        $x1 = 1040 + ($hash % 70);
        $y1 = 160 + ($hash % 45);
        $x2 = 1060 + ($hash % 95);
        $y2 = 530 + ($hash % 60);

        $topicLayer = $this->topicLayer($isLaravel, $isAi, $isSecurity, $isNetwork, $isData, $accent, $accent2);

        return <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="1600" height="900" viewBox="0 0 1600 900" role="img" aria-label="Pahamit editorial technology cover">
  <defs>
    <linearGradient id="bg" x1="0" y1="0" x2="1" y2="1">
      <stop offset="0" stop-color="#f8fafc"/>
      <stop offset="0.52" stop-color="#e0f2fe"/>
      <stop offset="1" stop-color="#eef2ff"/>
    </linearGradient>
    <linearGradient id="panel" x1="0" y1="0" x2="1" y2="1">
      <stop offset="0" stop-color="#ffffff"/>
      <stop offset="1" stop-color="#f1f5f9"/>
    </linearGradient>
    <linearGradient id="accent" x1="0" y1="0" x2="1" y2="1">
      <stop offset="0" stop-color="{$accent}"/>
      <stop offset="1" stop-color="{$accent2}"/>
    </linearGradient>
    <filter id="shadow" x="-20%" y="-20%" width="140%" height="140%">
      <feDropShadow dx="0" dy="28" stdDeviation="28" flood-color="#0f172a" flood-opacity=".16"/>
    </filter>
  </defs>
  <rect width="1600" height="900" fill="url(#bg)"/>
  <circle cx="1260" cy="170" r="230" fill="{$accent2}" opacity=".12"/>
  <circle cx="230" cy="760" r="260" fill="{$accent}" opacity=".10"/>
  <path d="M0 720 C270 620 450 790 720 695 C1030 585 1230 640 1600 520 L1600 900 L0 900 Z" fill="#ffffff" opacity=".48"/>

  <g opacity=".45" stroke="#94a3b8" stroke-width="2" fill="none">
    <path d="M1040 235 H1270 M1270 235 V375 H1428"/>
    <path d="M1010 630 H1220 M1220 630 V478 H1420"/>
    <path d="M255 226 H420 M420 226 V346 H560"/>
    <circle cx="1040" cy="235" r="9" fill="#ffffff"/>
    <circle cx="1428" cy="375" r="9" fill="#ffffff"/>
    <circle cx="255" cy="226" r="9" fill="#ffffff"/>
    <circle cx="560" cy="346" r="9" fill="#ffffff"/>
  </g>

  <g filter="url(#shadow)">
    <rect x="220" y="170" width="720" height="480" rx="32" fill="url(#panel)" stroke="#dbeafe" stroke-width="2"/>
    <rect x="220" y="170" width="720" height="68" rx="32" fill="#0f172a"/>
    <circle cx="270" cy="204" r="10" fill="#ef4444"/>
    <circle cx="304" cy="204" r="10" fill="#f59e0b"/>
    <circle cx="338" cy="204" r="10" fill="#22c55e"/>
    <rect x="280" y="292" width="260" height="18" rx="9" fill="{$accent}" opacity=".85"/>
    <rect x="280" y="344" width="520" height="14" rx="7" fill="#94a3b8" opacity=".44"/>
    <rect x="280" y="388" width="450" height="14" rx="7" fill="#94a3b8" opacity=".32"/>
    <rect x="280" y="432" width="565" height="14" rx="7" fill="#94a3b8" opacity=".38"/>
    <rect x="280" y="492" width="180" height="70" rx="18" fill="#eff6ff" stroke="#bfdbfe"/>
    <rect x="500" y="492" width="180" height="70" rx="18" fill="#ecfeff" stroke="#a5f3fc"/>
    <rect x="720" y="492" width="125" height="70" rx="18" fill="#f8fafc" stroke="#cbd5e1"/>
  </g>

  <g filter="url(#shadow)">
    <rect x="920" y="260" width="410" height="300" rx="30" fill="#ffffff" stroke="#dbeafe" stroke-width="2"/>
    <rect x="980" y="330" width="290" height="160" rx="24" fill="#f8fafc" stroke="#cbd5e1"/>
    <rect x="1018" y="365" width="214" height="16" rx="8" fill="url(#accent)" opacity=".9"/>
    <rect x="1018" y="410" width="164" height="12" rx="6" fill="#94a3b8" opacity=".42"/>
    <rect x="1018" y="446" width="190" height="12" rx="6" fill="#94a3b8" opacity=".30"/>
  </g>

  {$topicLayer}

  <g opacity=".86">
    <circle cx="{$x1}" cy="{$y1}" r="22" fill="url(#accent)"/>
    <circle cx="{$x2}" cy="{$y2}" r="15" fill="{$accent2}"/>
    <circle cx="1325" cy="670" r="11" fill="{$accent}" opacity=".75"/>
    <circle cx="190" cy="310" r="13" fill="{$accent2}" opacity=".72"/>
  </g>
</svg>
SVG;
    }

    private function topicLayer(bool $isLaravel, bool $isAi, bool $isSecurity, bool $isNetwork, bool $isData, string $accent, string $accent2): string
    {
        if ($isLaravel) {
            return <<<SVG
  <g transform="translate(1035 610)" filter="url(#shadow)">
    <path d="M0 70 L92 18 L184 70 L92 122 Z" fill="#ffffff" stroke="{$accent}" stroke-width="8"/>
    <path d="M92 18 V122 M0 70 L92 70 L184 70" stroke="{$accent2}" stroke-width="7" stroke-linecap="round"/>
  </g>
SVG;
        }

        if ($isAi) {
            return <<<SVG
  <g transform="translate(1045 615)" filter="url(#shadow)" stroke="{$accent}" stroke-width="9" fill="#ffffff">
    <rect x="20" y="20" width="160" height="120" rx="32"/>
    <circle cx="72" cy="80" r="12" fill="{$accent2}" stroke="none"/>
    <circle cx="128" cy="80" r="12" fill="{$accent2}" stroke="none"/>
    <path d="M40 80 H0 M200 80 H160 M100 20 V0 M100 160 V140" stroke-linecap="round"/>
  </g>
SVG;
        }

        if ($isSecurity) {
            return <<<SVG
  <g transform="translate(1060 600)" filter="url(#shadow)">
    <path d="M90 0 L180 34 V100 C180 160 132 205 90 224 C48 205 0 160 0 100 V34 Z" fill="#ffffff" stroke="{$accent}" stroke-width="8"/>
    <path d="M48 110 L78 140 L136 74" fill="none" stroke="{$accent2}" stroke-width="12" stroke-linecap="round" stroke-linejoin="round"/>
  </g>
SVG;
        }

        if ($isData) {
            return <<<SVG
  <g transform="translate(1030 610)" filter="url(#shadow)">
    <ellipse cx="110" cy="38" rx="96" ry="36" fill="#ffffff" stroke="{$accent}" stroke-width="8"/>
    <path d="M14 38 V154 C14 174 57 194 110 194 C163 194 206 174 206 154 V38" fill="#ffffff" stroke="{$accent}" stroke-width="8"/>
    <path d="M14 96 C14 116 57 136 110 136 C163 136 206 116 206 96" fill="none" stroke="{$accent2}" stroke-width="7"/>
  </g>
SVG;
        }

        if ($isNetwork) {
            return <<<SVG
  <g transform="translate(1038 612)" filter="url(#shadow)" stroke="{$accent}" stroke-width="8" fill="#ffffff">
    <path d="M60 58 L140 26 L218 72 L155 152 L62 150 Z" fill="none"/>
    <circle cx="60" cy="58" r="24"/>
    <circle cx="140" cy="26" r="24"/>
    <circle cx="218" cy="72" r="24"/>
    <circle cx="155" cy="152" r="24"/>
    <circle cx="62" cy="150" r="24"/>
  </g>
SVG;
        }

        return <<<SVG
  <g transform="translate(1040 610)" filter="url(#shadow)" fill="#ffffff" stroke="{$accent}" stroke-width="8">
    <rect x="0" y="20" width="220" height="150" rx="30"/>
    <path d="M56 95 L88 68 M56 95 L88 122 M164 68 L132 95 M164 122 L132 95" stroke="{$accent2}" stroke-width="10" stroke-linecap="round"/>
  </g>
SVG;
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
}
