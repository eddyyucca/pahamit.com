<?php

namespace Database\Seeders;

use App\Models\MediaPost;
use App\Models\PostView;
use App\Models\SiteVisit;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::query()->updateOrCreate([
            'email' => 'admin@pahamit.com',
        ], [
            'name' => 'Admin Pahamit',
            'password' => Hash::make('password'),
        ]);

        $posts = [
            [
                'type' => MediaPost::TYPE_BERITA,
                'title' => 'Checklist keamanan jaringan sebelum bisnis membuka akses remote',
                'category' => 'Security',
                'excerpt' => 'Panduan cepat untuk memahami firewall, VPN, segmentasi VLAN, backup, dan monitoring.',
                'content' => 'Konten berita dan insight keamanan jaringan untuk pembaca Pahamit.',
                'status' => 'published',
                'views_count' => 142,
                'published_at' => now(),
            ],
            [
                'type' => MediaPost::TYPE_TUTORIAL,
                'title' => 'Belajar subnetting dari nol untuk pemula network',
                'category' => 'Network Basic',
                'excerpt' => 'Materi bertahap untuk memahami IP address, CIDR, gateway, dan pembagian jaringan.',
                'content' => 'Tutorial subnetting dari dasar sampai siap praktik.',
                'status' => 'published',
                'views_count' => 96,
                'published_at' => now(),
            ],
            [
                'type' => MediaPost::TYPE_JUALAN,
                'title' => 'IP Address Planner v2',
                'category' => 'Template',
                'excerpt' => 'Template Excel untuk planning subnet, VLAN, gateway, dan dokumentasi perangkat.',
                'content' => 'Produk digital untuk mempercepat pekerjaan dokumentasi network.',
                'price' => 99000,
                'status' => 'published',
                'views_count' => 61,
                'published_at' => now(),
            ],
        ];

        foreach ($posts as $post) {
            MediaPost::query()->updateOrCreate([
                'slug' => Str::slug($post['title']),
            ], $post + ['user_id' => $admin->id]);
        }

        foreach (range(6, 0) as $daysAgo) {
            $date = now()->subDays($daysAgo)->toDateString();

            if (SiteVisit::whereDate('visit_date', $date)->exists()) {
                continue;
            }

            foreach (range(1, 8 + ((6 - $daysAgo) * 3)) as $index) {
                SiteVisit::create([
                    'visit_date' => $date,
                    'path' => '/',
                    'ip_hash' => hash('sha256', $date . '-' . $index),
                    'user_agent' => 'Seeder sample visit',
                ]);
            }
        }

        $publishedPosts = MediaPost::published()->get();

        foreach ($publishedPosts as $post) {
            foreach (range(6, 0) as $daysAgo) {
                $date = now()->subDays($daysAgo)->toDateString();
                $target = match ($post->type) {
                    MediaPost::TYPE_BERITA => 5 + ((6 - $daysAgo) * 2),
                    MediaPost::TYPE_TUTORIAL => 3 + (6 - $daysAgo),
                    default => 2 + (int) floor((6 - $daysAgo) / 2),
                };

                foreach (range(1, $target) as $index) {
                    PostView::firstOrCreate([
                        'media_post_id' => $post->id,
                        'viewed_on' => $date,
                        'ip_hash' => hash('sha256', "post-{$post->id}-{$date}-{$index}"),
                    ], [
                        'user_agent' => 'Seeder sample post view',
                        'referer' => $index % 3 === 0 ? 'https://google.com/search?q=pahamit' : null,
                        'path' => '/' . match ($post->type) {
                            MediaPost::TYPE_BERITA => 'berita',
                            MediaPost::TYPE_TUTORIAL => 'panduan',
                            default => 'toko',
                        } . '/' . $post->slug,
                    ]);
                }
            }

            $post->forceFill(['views_count' => $post->postViews()->count()])->save();
        }
    }
}
