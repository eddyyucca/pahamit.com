<?php

namespace App\Http\Controllers;

use App\Models\MediaPost;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ArchiveController extends Controller
{
    public function category(string $category): View
    {
        $items = MediaPost::published()
            ->where('category', $category)
            ->latest('published_at')
            ->paginate(12);

        return view('site.archive', [
            'title' => 'Kategori: ' . Str::headline($category),
            'description' => 'Kumpulan artikel Pahamit dalam kategori ' . Str::headline($category) . '.',
            'items' => $items,
            'archiveType' => 'category',
            'archiveValue' => $category,
        ]);
    }

    public function tag(string $tag): View
    {
        $items = MediaPost::published()
            ->whereJsonContains('tags', $tag)
            ->latest('published_at')
            ->paginate(12);

        return view('site.archive', [
            'title' => 'Tag: ' . Str::headline($tag),
            'description' => 'Artikel dan panduan Pahamit dengan tag ' . Str::headline($tag) . '.',
            'items' => $items,
            'archiveType' => 'tag',
            'archiveValue' => $tag,
        ]);
    }
}
