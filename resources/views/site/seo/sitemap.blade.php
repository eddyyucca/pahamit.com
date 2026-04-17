<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{ url('/') }}</loc>
        <lastmod>{{ now()->toAtomString() }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>
    @foreach ($posts as $post)
        @php
            $routeName = match ($post->type) {
                'tutorial' => 'post.panduan',
                'jualan' => 'post.toko',
                default => 'post.berita',
            };
        @endphp
        <url>
            <loc>{{ route($routeName, $post->slug) }}</loc>
            <lastmod>{{ $post->updated_at->toAtomString() }}</lastmod>
            <changefreq>{{ $post->type === 'berita' ? 'weekly' : 'monthly' }}</changefreq>
            <priority>{{ $post->type === 'tutorial' ? '0.8' : '0.7' }}</priority>
        </url>
    @endforeach
</urlset>
