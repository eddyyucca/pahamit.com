<?php

namespace App\Services\Ai;

use App\Models\AiConversation;
use App\Models\AiDraft;

class AiOrchestratorService
{
    public function __construct(
        private readonly GeminiAgentService $gemini,
        private readonly GeminiImageService $images,
    ) {
    }

    public function chat(AiConversation $conversation, string $message, string $action = 'chat'): array
    {
        $conversation->messages()->create([
            'role' => 'user',
            'content' => $message,
            'metadata' => ['action' => $action],
        ]);

        $messages = $this->messages($conversation);

        if ($action === 'draft') {
            $draftData = $this->gemini->draft($conversation, $messages, $this->draftType($conversation->type));
            $draft = $conversation->drafts()->create([
                'type' => $this->draftType($conversation->type),
                'title' => $draftData['title'],
                'category' => $draftData['category'] ?? null,
                'excerpt' => $draftData['excerpt'] ?? null,
                'content' => $draftData['content'] ?? null,
                'sources' => $draftData['sources'] ?? [],
                'metadata' => $draftData['metadata'] ?? [],
                'status' => 'generated',
            ]);

            $imageNote = '';
            $metadata = $draft->metadata ?? [];

            try {
                $image = $this->images->generateForDraft($conversation, $draftData);

                if ($image) {
                    $metadata = array_merge($metadata, $image);
                    $draft->update(['metadata' => $metadata]);
                    $imageNote = "\n\nFeatured image otomatis juga sudah dibuat dengan gaya visual Pahamit.";
                }
            } catch (\Throwable $exception) {
                $metadata['image_error'] = $exception->getMessage();
                $draft->update(['metadata' => $metadata]);
                $imageNote = "\n\nCatatan: draft berhasil dibuat, tetapi gambar otomatis belum berhasil dibuat: {$exception->getMessage()}";
            }

            $reply = "Draft sudah dibuat oleh Gemini Agent dan tersimpan di panel kanan.\n\n"
                . "**{$draft->title}**\n\n"
                . "Langkah berikutnya: klik `Review Gemini` untuk penyuntingan, atau `Simpan ke Draft Konten` kalau sudah cocok."
                . $imageNote;

            $conversation->messages()->create([
                'role' => 'assistant',
                'provider' => 'gemini',
                'content' => $reply,
                'metadata' => ['action' => 'draft', 'draft_id' => $draft->id],
            ]);

            return ['reply' => $reply, 'draft' => $draft];
        }

        if ($action === 'review') {
            $draft = $conversation->drafts()->latest()->first();
            $content = $draft?->content ?: $message;
            $reply = $this->gemini->review($conversation, $content);

            $conversation->messages()->create([
                'role' => 'assistant',
                'provider' => 'gemini',
                'content' => $reply,
                'metadata' => ['action' => 'review', 'draft_id' => $draft?->id],
            ]);

            return ['reply' => $reply, 'draft' => $draft];
        }

        $reply = $this->gemini->respond($conversation, $messages, $action);

        $conversation->messages()->create([
            'role' => 'assistant',
            'provider' => 'gemini',
            'content' => $reply,
            'metadata' => ['action' => $action],
        ]);

        return ['reply' => $reply, 'draft' => $conversation->drafts()->latest()->first()];
    }

    public function draftType(string $conversationType): string
    {
        return match ($conversationType) {
            'tutorial', 'panduan' => 'tutorial',
            'jualan' => 'jualan',
            default => 'berita',
        };
    }

    private function messages(AiConversation $conversation): array
    {
        return $conversation->messages()
            ->oldest()
            ->take(40)
            ->get(['role', 'content'])
            ->map(fn ($message) => [
                'role' => $message->role,
                'content' => $message->content,
            ])
            ->all();
    }
}
