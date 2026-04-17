<?php

namespace App\Http\Controllers;

use App\Models\MediaPost;
use Illuminate\Http\Response;

class SeoController extends Controller
{
    public function sitemap(): Response
    {
        $posts = MediaPost::published()
            ->latest('updated_at')
            ->get(['type', 'slug', 'updated_at']);

        return response()
            ->view('site.seo.sitemap', compact('posts'))
            ->header('Content-Type', 'application/xml');
    }

    public function robots(): Response
    {
        $content = "User-agent: *\n"
            . "Allow: /\n"
            . "Disallow: /dashboard\n"
            . "Disallow: /login\n\n"
            . "Sitemap: " . url('/sitemap.xml') . "\n";

        return response($content, 200)->header('Content-Type', 'text/plain');
    }
}
