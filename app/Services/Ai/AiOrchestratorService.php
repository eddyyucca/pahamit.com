<?php

namespace App\Services\Ai;

use App\Models\AiConversation;
use App\Models\AiDraft;

class AiOrchestratorService
{
    public function __construct(
        private readonly OpenAiAgentService $openAi,
        private readonly ClaudeAgentService $claude,
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
            $draftData = $this->openAi->draft($conversation, $messages, $this->draftType($conversation->type));
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

            $reply = "Draft sudah dibuat oleh ChatGPT dan tersimpan di panel kanan.\n\n"
                . "**{$draft->title}**\n\n"
                . "Langkah berikutnya: klik `Review Claude` untuk penyuntingan, atau `Simpan ke Draft Konten` kalau sudah cocok.";

            $conversation->messages()->create([
                'role' => 'assistant',
                'provider' => 'openai',
                'content' => $reply,
                'metadata' => ['action' => 'draft', 'draft_id' => $draft->id],
            ]);

            return ['reply' => $reply, 'draft' => $draft];
        }

        if ($action === 'review') {
            $draft = $conversation->drafts()->latest()->first();
            $content = $draft?->content ?: $message;
            $reply = $this->claude->review($conversation, $content);

            $conversation->messages()->create([
                'role' => 'assistant',
                'provider' => 'anthropic',
                'content' => $reply,
                'metadata' => ['action' => 'review', 'draft_id' => $draft?->id],
            ]);

            return ['reply' => $reply, 'draft' => $draft];
        }

        $reply = $this->openAi->respond($conversation, $messages, $action);

        $conversation->messages()->create([
            'role' => 'assistant',
            'provider' => 'openai',
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
