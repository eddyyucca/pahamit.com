<?php

namespace App\Http\Controllers;

use App\Models\AiConversation;
use App\Models\AiDraft;
use App\Models\MediaPost;
use App\Services\Ai\AiOrchestratorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AiAgentController extends Controller
{
    public function index(?AiConversation $conversation = null): View
    {
        $conversations = AiConversation::where('user_id', Auth::id())
            ->latest()
            ->take(20)
            ->get();

        $conversation ??= $conversations->first();

        if (! $conversation) {
            $conversation = AiConversation::create([
                'user_id' => Auth::id(),
                'title' => 'Percakapan Baru',
                'type' => 'berita',
                'tone' => 'Santai teknis',
            ]);

            $conversations = collect([$conversation]);
        }

        abort_unless($conversation->user_id === Auth::id(), 403);

        $conversation->load([
            'messages' => fn ($query) => $query->oldest(),
            'drafts' => fn ($query) => $query->latest(),
        ]);

        return view('dashboard.ai.agent', [
            'conversations' => $conversations,
            'conversation' => $conversation,
            'draft' => $conversation->drafts->first(),
        ]);
    }

    public function storeConversation(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'type' => ['required', 'in:berita,tutorial,jualan,general'],
            'title' => ['nullable', 'string', 'max:160'],
            'goal' => ['nullable', 'string', 'max:255'],
            'audience' => ['nullable', 'string', 'max:255'],
            'tone' => ['nullable', 'string', 'max:120'],
        ]);

        $conversation = AiConversation::create([
            'user_id' => Auth::id(),
            'title' => $data['title'] ?: 'Percakapan ' . ucfirst($data['type']),
            'type' => $data['type'],
            'goal' => $data['goal'] ?? null,
            'audience' => $data['audience'] ?? null,
            'tone' => $data['tone'] ?? null,
        ]);

        $conversation->messages()->create([
            'role' => 'assistant',
            'provider' => 'system',
            'content' => "Halo. Saya AI Agent Pahamit. Ceritakan tema, tujuan, target pembaca, dan arah CTA yang ingin dibuat. Setelah itu saya bisa bantu buat outline, draft, lalu minta Claude mereview.",
            'metadata' => ['action' => 'welcome'],
        ]);

        return redirect()->route('dashboard.ai.show', $conversation);
    }

    public function updateConversation(Request $request, AiConversation $conversation): RedirectResponse
    {
        abort_unless($conversation->user_id === Auth::id(), 403);

        $data = $request->validate([
            'type' => ['required', 'in:berita,tutorial,jualan,general'],
            'title' => ['required', 'string', 'max:160'],
            'goal' => ['nullable', 'string', 'max:255'],
            'audience' => ['nullable', 'string', 'max:255'],
            'tone' => ['nullable', 'string', 'max:120'],
        ]);

        $conversation->update($data);

        return back()->with('status', 'Konteks AI Agent diperbarui.');
    }

    public function message(Request $request, AiConversation $conversation, AiOrchestratorService $agent): RedirectResponse
    {
        abort_unless($conversation->user_id === Auth::id(), 403);

        $data = $request->validate([
            'message' => ['required', 'string', 'max:8000'],
            'action' => ['required', 'in:chat,outline,draft,review'],
        ]);

        try {
            $agent->chat($conversation, $data['message'], $data['action']);
        } catch (\Throwable $exception) {
            return back()->withErrors(['message' => $exception->getMessage()]);
        }

        return redirect()->route('dashboard.ai.show', $conversation);
    }

    public function saveDraft(AiConversation $conversation, AiDraft $draft): RedirectResponse
    {
        abort_unless($conversation->user_id === Auth::id() && $draft->ai_conversation_id === $conversation->id, 403);

        if ($draft->media_post_id) {
            return redirect()
                ->route('dashboard.posts.edit', [$draft->type, $draft->mediaPost])
                ->with('status', 'Draft ini sudah pernah disimpan ke konten.');
        }

        $post = MediaPost::create([
            'user_id' => Auth::id(),
            'type' => $draft->type,
            'title' => $draft->title,
            'slug' => MediaPost::uniqueSlug($draft->title),
            'category' => $draft->category,
            'excerpt' => $draft->excerpt,
            'seo_title' => data_get($draft->metadata, 'seo_title'),
            'seo_description' => data_get($draft->metadata, 'seo_description'),
            'focus_keyword' => data_get($draft->metadata, 'focus_keyword'),
            'content' => $this->contentWithSources($draft),
            'status' => 'draft',
            'views_count' => 0,
            'published_at' => null,
        ]);

        $draft->update([
            'media_post_id' => $post->id,
            'status' => 'saved',
        ]);

        return redirect()
            ->route('dashboard.posts.edit', [$post->type, $post])
            ->with('status', 'Draft AI berhasil disimpan ke konten. Silakan review sebelum publish.');
    }

    private function contentWithSources(AiDraft $draft): string
    {
        $content = trim((string) $draft->content);
        $sources = collect($draft->sources ?? [])->filter(fn ($source) => filled($source['url'] ?? null));

        if ($sources->isEmpty()) {
            return $content;
        }

        $sourceText = $sources
            ->map(fn ($source, $index) => ($index + 1) . '. [' . ($source['title'] ?: $source['url']) . '](' . $source['url'] . ')')
            ->implode("\n");

        return $content . "\n\n## Sumber Referensi\n\n" . $sourceText;
    }
}
