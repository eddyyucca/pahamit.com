<?php

namespace App\Http\Controllers;

use App\Models\MediaPost;
use App\Models\PostView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class PostController extends Controller
{
    private const SLUG_TYPE_MAP = [
        'berita' => MediaPost::TYPE_BERITA,
        'panduan' => MediaPost::TYPE_TUTORIAL,
        'toko' => MediaPost::TYPE_JUALAN,
    ];

    public function show(Request $request, string $slug): View
    {
        if (! Schema::hasTable('media_posts')) {
            abort(404);
        }

        $routeName = $request->route()->getName();
        $prefix = explode('.', $routeName)[1] ?? null;
        $type = self::SLUG_TYPE_MAP[$prefix] ?? null;

        $post = MediaPost::published()
            ->when($type, fn ($query) => $query->type($type))
            ->where('slug', $slug)
            ->firstOrFail();

        $this->recordView($request, $post);

        $related = MediaPost::published()
            ->type($post->type)
            ->whereKeyNot($post->id)
            ->latest('published_at')
            ->take(4)
            ->get();

        return view('site.show', compact('post', 'related'));
    }

    public function preview(string $type, MediaPost $post): View
    {
        abort_unless($post->type === $type, 404);

        $related = collect();

        return view('site.show', compact('post', 'related'));
    }

    private function recordView(Request $request, MediaPost $post): void
    {
        if (! Schema::hasTable('post_views')) {
            $post->increment('views_count');

            return;
        }

        $view = PostView::firstOrCreate([
            'media_post_id' => $post->id,
            'viewed_on' => now()->toDateString(),
            'ip_hash' => hash('sha256', (string) $request->ip()),
        ], [
            'user_agent' => substr((string) $request->userAgent(), 0, 500),
            'referer' => substr((string) $request->headers->get('referer'), 0, 500),
            'path' => '/' . trim($request->path(), '/'),
        ]);

        if ($view->wasRecentlyCreated) {
            $post->increment('views_count');
        }
    }
}
