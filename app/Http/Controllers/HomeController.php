<?php

namespace App\Http\Controllers;

use App\Models\MediaPost;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        if (! Schema::hasTable('media_posts')) {
            return view('site.home', [
                'beritaPosts' => collect(),
                'tutorialPosts' => collect(),
                'jualanPosts' => collect(),
                'homeStats' => [
                    'berita' => 0,
                    'tutorial' => 0,
                    'jualan' => 0,
                ],
            ]);
        }

        $beritaPosts = MediaPost::type(MediaPost::TYPE_BERITA)->published()->latest('published_at')->take(3)->get();
        $tutorialPosts = MediaPost::type(MediaPost::TYPE_TUTORIAL)->published()->latest('published_at')->take(4)->get();
        $jualanPosts = MediaPost::type(MediaPost::TYPE_JUALAN)->published()->latest('published_at')->take(3)->get();
        $homeStats = [
            'berita' => MediaPost::type(MediaPost::TYPE_BERITA)->published()->count(),
            'tutorial' => MediaPost::type(MediaPost::TYPE_TUTORIAL)->published()->count(),
            'jualan' => MediaPost::type(MediaPost::TYPE_JUALAN)->published()->count(),
        ];

        return view('site.home', compact('beritaPosts', 'tutorialPosts', 'jualanPosts', 'homeStats'));
    }
}
