<?php

namespace App\Http\Controllers;

use App\Models\MediaPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ListingController extends Controller
{
    public function berita(Request $request)
    {
        $query   = $request->get('q');
        $cat     = $request->get('kategori');

        $posts = MediaPost::type(MediaPost::TYPE_BERITA)->published()
            ->when($query, fn ($q) => $q->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('excerpt', 'like', "%{$query}%")
                  ->orWhere('content', 'like', "%{$query}%");
            }))
            ->when($cat, fn ($q) => $q->where('category', $cat))
            ->latest('published_at')
            ->paginate(12)
            ->withQueryString();

        $categories = MediaPost::type(MediaPost::TYPE_BERITA)->published()
            ->whereNotNull('category')
            ->distinct()->pluck('category');

        return view('site.berita.index', compact('posts', 'query', 'cat', 'categories'));
    }

    public function panduan(Request $request)
    {
        $query = $request->get('q');
        $cat   = $request->get('kategori');

        $posts = MediaPost::type(MediaPost::TYPE_TUTORIAL)->published()
            ->when($query, fn ($q) => $q->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('excerpt', 'like', "%{$query}%")
                  ->orWhere('content', 'like', "%{$query}%");
            }))
            ->when($cat, fn ($q) => $q->where('category', $cat))
            ->latest('published_at')
            ->paginate(12)
            ->withQueryString();

        $categories = MediaPost::type(MediaPost::TYPE_TUTORIAL)->published()
            ->whereNotNull('category')
            ->distinct()->pluck('category');

        return view('site.panduan.index', compact('posts', 'query', 'cat', 'categories'));
    }

    public function about()
    {
        return view('site.about');
    }
}
