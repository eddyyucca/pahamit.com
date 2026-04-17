<?php

namespace App\Http\Controllers;

use App\Models\MediaPost;
use App\Models\PostView;
use App\Models\SiteVisit;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $todayVisits = Schema::hasTable('site_visits')
            ? SiteVisit::whereDate('visit_date', today())->count()
            : 0;

        $todayPostViews = Schema::hasTable('post_views')
            ? PostView::whereDate('viewed_on', today())->count()
            : 0;

        $stats = [
            ['label' => 'Pengunjung Hari Ini', 'value' => $todayVisits, 'tone' => 'blue', 'icon' => 'visits'],
            ['label' => 'View Konten Hari Ini', 'value' => $todayPostViews, 'tone' => 'green', 'icon' => 'guide'],
            ['label' => 'Total Berita', 'value' => MediaPost::type(MediaPost::TYPE_BERITA)->count(), 'tone' => 'red', 'icon' => 'news'],
            ['label' => 'Total Tutorial', 'value' => MediaPost::type(MediaPost::TYPE_TUTORIAL)->count(), 'tone' => 'green', 'icon' => 'guide'],
        ];

        $latestPosts = MediaPost::with('user')->latest()->take(6)->get();
        $topPosts = MediaPost::withCount(['postViews as views_7d' => function ($query) {
                $query->whereDate('viewed_on', '>=', now()->subDays(6)->toDateString());
            }])
            ->type(MediaPost::TYPE_BERITA)
            ->latest('views_count')
            ->take(5)
            ->get();
        $postMix = [
            'berita' => MediaPost::type(MediaPost::TYPE_BERITA)->count(),
            'tutorial' => MediaPost::type(MediaPost::TYPE_TUTORIAL)->count(),
            'jualan' => MediaPost::type(MediaPost::TYPE_JUALAN)->count(),
        ];

        $visitMap = Schema::hasTable('site_visits')
            ? SiteVisit::query()
                ->selectRaw('visit_date, count(*) as total')
                ->whereDate('visit_date', '>=', now()->subDays(6)->toDateString())
                ->groupBy('visit_date')
                ->pluck('total', 'visit_date')
            : collect();

        $visitChart = collect(CarbonPeriod::create(now()->subDays(6), now()))
            ->map(function ($date) use ($visitMap) {
                $key = $date->toDateString();

                return [
                    'label' => $date->translatedFormat('D'),
                    'date' => $date->translatedFormat('d M'),
                    'total' => (int) ($visitMap[$key] ?? 0),
                ];
            });

        $postViewMap = Schema::hasTable('post_views')
            ? PostView::query()
                ->selectRaw('viewed_on, count(*) as total')
                ->whereDate('viewed_on', '>=', now()->subDays(6)->toDateString())
                ->groupBy('viewed_on')
                ->pluck('total', 'viewed_on')
            : collect();

        $postViewChart = collect(CarbonPeriod::create(now()->subDays(6), now()))
            ->map(function ($date) use ($postViewMap) {
                $key = $date->toDateString();

                return [
                    'label' => $date->translatedFormat('D'),
                    'date' => $date->translatedFormat('d M'),
                    'total' => (int) ($postViewMap[$key] ?? 0),
                ];
            });

        $sourceBreakdown = Schema::hasTable('post_views')
            ? $this->sourceBreakdown()
            : [
                ['label' => 'Direct', 'total' => 0],
                ['label' => 'Internal', 'total' => 0],
                ['label' => 'Referral', 'total' => 0],
            ];

        $maxVisits = max(1, $visitChart->max('total'));

        return view('dashboard.index', compact('stats', 'latestPosts', 'topPosts', 'postMix', 'visitChart', 'postViewChart', 'sourceBreakdown', 'maxVisits'));
    }

    private function sourceBreakdown(): array
    {
        $views = PostView::whereDate('viewed_on', '>=', now()->subDays(6)->toDateString())->get(['referer']);

        $groups = [
            'Direct' => 0,
            'Internal' => 0,
            'Referral' => 0,
            'Social' => 0,
            'Search' => 0,
        ];

        foreach ($views as $view) {
            $referer = strtolower((string) $view->referer);

            if ($referer === '') {
                $groups['Direct']++;
            } elseif (str_contains($referer, 'pahamit') || str_contains($referer, 'localhost')) {
                $groups['Internal']++;
            } elseif (str_contains($referer, 'google') || str_contains($referer, 'bing') || str_contains($referer, 'yahoo')) {
                $groups['Search']++;
            } elseif (str_contains($referer, 'facebook') || str_contains($referer, 'instagram') || str_contains($referer, 'tiktok') || str_contains($referer, 'x.com')) {
                $groups['Social']++;
            } else {
                $groups['Referral']++;
            }
        }

        return collect($groups)
            ->map(fn ($total, $label) => ['label' => $label, 'total' => $total])
            ->sortByDesc('total')
            ->values()
            ->all();
    }
}
