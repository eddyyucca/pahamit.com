<?php

namespace App\Http\Controllers;

use App\Models\MediaPost;
use App\Models\Series;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MediaPostController extends Controller
{
    private const TYPES = [
        MediaPost::TYPE_BERITA => [
            'title' => 'Management Berita',
            'description' => 'Kelola artikel berita IT, update industri, opini, dan insight teknologi.',
            'label' => 'Berita',
        ],
        MediaPost::TYPE_TUTORIAL => [
            'title' => 'Management Tutorial',
            'description' => 'Kelola media panduan belajar, learning path, modul, dan tutorial teknis.',
            'label' => 'Tutorial',
        ],
        MediaPost::TYPE_JUALAN => [
            'title' => 'Management Jualan',
            'description' => 'Kelola alat IT, template, script, paket jasa, harga, dan status produk.',
            'label' => 'Jualan',
        ],
    ];

    public function index(Request $request, string $type): View
    {
        abort_unless(isset(self::TYPES[$type]), 404);

        $items = MediaPost::type($type)
            ->when($request->filled('q'), function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->string('q') . '%');
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('dashboard.list', [
            ...self::TYPES[$type],
            'type' => $type,
            'items' => $items,
        ]);
    }

    public function create(string $type): View
    {
        abort_unless(isset(self::TYPES[$type]), 404);

        return view('dashboard.manage', [
            ...self::TYPES[$type],
            'type' => $type,
            'post' => new MediaPost(['type' => $type, 'status' => 'draft']),
            'formAction' => route('dashboard.posts.store', $type),
            'method' => 'POST',
            'allSeries' => $type === MediaPost::TYPE_TUTORIAL ? Series::orderBy('title')->get() : collect(),
        ]);
    }

    public function store(Request $request, string $type): RedirectResponse
    {
        abort_unless(isset(self::TYPES[$type]), 404);

        $data = $this->validated($request, $type);
        $data = $this->normalizeStructuredFields($data);
        $data = $this->withUploadedImage($request, $data);
        $data['user_id'] = Auth::id();
        $data['type'] = $type;
        $data['slug'] = MediaPost::uniqueSlug($data['title']);
        $data['published_at'] = $data['status'] === 'published' ? now() : null;

        MediaPost::create($data);

        return redirect()->route('dashboard.posts.index', $type)->with('status', 'Data berhasil ditambahkan.');
    }

    public function edit(string $type, MediaPost $post): View
    {
        abort_unless(isset(self::TYPES[$type]) && $post->type === $type, 404);

        return view('dashboard.manage', [
            ...self::TYPES[$type],
            'type' => $type,
            'post' => $post,
            'formAction' => route('dashboard.posts.update', [$type, $post]),
            'method' => 'PUT',
            'allSeries' => $type === MediaPost::TYPE_TUTORIAL ? Series::orderBy('title')->get() : collect(),
        ]);
    }

    public function update(Request $request, string $type, MediaPost $post): RedirectResponse
    {
        abort_unless(isset(self::TYPES[$type]) && $post->type === $type, 404);

        $data = $this->validated($request, $type);
        $data = $this->normalizeStructuredFields($data);
        $data = $this->withUploadedImage($request, $data, $post);
        $data['slug'] = MediaPost::uniqueSlug($data['title'], $post->id);
        $data['published_at'] = $data['status'] === 'published'
            ? ($post->published_at ?? now())
            : null;

        $post->update($data);

        return redirect()->route('dashboard.posts.index', $type)->with('status', 'Data berhasil diperbarui.');
    }

    public function destroy(string $type, MediaPost $post): RedirectResponse
    {
        abort_unless(isset(self::TYPES[$type]) && $post->type === $type, 404);

        if ($post->image_path) {
            Storage::disk('public')->delete($post->image_path);
        }

        $post->delete();

        return redirect()->route('dashboard.posts.index', $type)->with('status', 'Data berhasil dihapus.');
    }

    private function validated(Request $request, string $type): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:120'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string', 'max:500'],
            'focus_keyword' => ['nullable', 'string', 'max:120'],
            'tags' => ['nullable', 'string', 'max:500'],
            'canonical_url' => ['nullable', 'url', 'max:255'],
            'content' => ['nullable', 'string'],
            'price' => [$type === MediaPost::TYPE_JUALAN ? 'nullable' : 'exclude', 'nullable', 'numeric', 'min:0'],
            'series_id' => [$type === MediaPost::TYPE_TUTORIAL ? 'nullable' : 'exclude', 'nullable', 'exists:series,id'],
            'series_order' => [$type === MediaPost::TYPE_TUTORIAL ? 'nullable' : 'exclude', 'nullable', 'integer', 'min:1'],
            'status' => ['required', Rule::in(['draft', 'review', 'published'])],
            'image_url' => ['nullable', 'url', 'max:255'],
            'featured_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);
    }

    private function normalizeStructuredFields(array $data): array
    {
        $data['tags'] = collect(explode(',', (string) ($data['tags'] ?? '')))
            ->map(fn ($tag) => trim($tag))
            ->filter()
            ->unique(fn ($tag) => mb_strtolower($tag))
            ->values()
            ->all();

        return $data;
    }

    private function withUploadedImage(Request $request, array $data, ?MediaPost $post = null): array
    {
        unset($data['featured_image']);

        if (! $request->hasFile('featured_image')) {
            return $data;
        }

        if ($post?->image_path) {
            Storage::disk('public')->delete($post->image_path);
        }

        $data['image_path'] = $request->file('featured_image')->store('media-posts', 'public');
        $data['image_url'] = null;

        return $data;
    }
}
