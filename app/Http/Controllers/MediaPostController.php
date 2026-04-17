<?php

namespace App\Http\Controllers;

use App\Models\MediaPost;
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

        return view('dashboard.manage', [
            ...self::TYPES[$type],
            'type' => $type,
            'items' => $items,
            'post' => new MediaPost(['type' => $type, 'status' => 'draft']),
            'formAction' => route('dashboard.posts.store', $type),
            'method' => 'POST',
        ]);
    }

    public function store(Request $request, string $type): RedirectResponse
    {
        abort_unless(isset(self::TYPES[$type]), 404);

        $data = $this->validated($request, $type);
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

        $items = MediaPost::type($type)->latest()->paginate(10);

        return view('dashboard.manage', [
            ...self::TYPES[$type],
            'type' => $type,
            'items' => $items,
            'post' => $post,
            'formAction' => route('dashboard.posts.update', [$type, $post]),
            'method' => 'PUT',
        ]);
    }

    public function update(Request $request, string $type, MediaPost $post): RedirectResponse
    {
        abort_unless(isset(self::TYPES[$type]) && $post->type === $type, 404);

        $data = $this->validated($request, $type);
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
            'content' => ['nullable', 'string'],
            'price' => [$type === MediaPost::TYPE_JUALAN ? 'nullable' : 'exclude', 'nullable', 'numeric', 'min:0'],
            'status' => ['required', Rule::in(['draft', 'review', 'published'])],
            'image_url' => ['nullable', 'url', 'max:255'],
            'featured_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);
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
