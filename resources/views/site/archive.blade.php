<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $description }}">
    <link rel="canonical" href="{{ url()->current() }}">
    <title>{{ $title }} - pahamIT</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800&display=swap" rel="stylesheet">
    <style>
        :root {
            --blue:#0b6fee; --red:#ed1c24; --green:#16a34a;
            --bg:#f4f7fc; --surface:#fff; --surface2:#eef3fb;
            --text:#0f172a; --muted:#64748b; --line:#dbe4f0;
            --shadow:0 4px 24px rgba(7,31,79,.08); --radius:10px;
        }
        [data-theme="dark"] {
            --bg:#070b14; --surface:#0f172a; --surface2:#111d33;
            --text:#f1f5f9; --muted:#94a3b8; --line:#1e2d45;
            --shadow:0 4px 24px rgba(0,0,0,.3);
        }
        * { box-sizing:border-box; }
        body { margin:0; font-family:"Instrument Sans",system-ui,sans-serif; background:var(--bg); color:var(--text); line-height:1.65; }
        a { color:inherit; text-decoration:none; }
        .wrap { width:min(1120px, calc(100% - 40px)); margin:0 auto; }
        .topbar { border-bottom:1px solid var(--line); background:var(--surface); position:sticky; top:0; z-index:10; }
        .nav { min-height:66px; display:flex; align-items:center; justify-content:space-between; gap:16px; }
        .brand { font-weight:900; font-size:1.1rem; }
        .brand span { color:var(--blue); }
        .nav a:not(.brand) { color:var(--muted); font-weight:800; font-size:.9rem; }
        .hero { padding:58px 0 34px; }
        .eyebrow { color:var(--red); font-size:.75rem; font-weight:900; text-transform:uppercase; letter-spacing:.1em; margin:0 0 8px; }
        h1 { margin:0; font-size:clamp(2rem, 4vw, 3.2rem); line-height:1.08; }
        .hero p { max-width:680px; color:var(--muted); margin:14px 0 0; }
        .grid { display:grid; grid-template-columns:repeat(3,1fr); gap:18px; padding:16px 0 64px; }
        .card { display:block; border:1px solid var(--line); border-radius:var(--radius); background:var(--surface); overflow:hidden; box-shadow:var(--shadow); transition:.18s; }
        .card:hover { transform:translateY(-3px); }
        .visual { min-height:150px; display:flex; align-items:flex-end; padding:14px; background:linear-gradient(160deg,rgba(7,31,79,.86),rgba(11,111,238,.55)),var(--surface2); background-size:cover; background-position:center; }
        .badge { display:inline-flex; padding:4px 10px; border-radius:999px; background:#fff; color:#071f4f; font-size:.72rem; font-weight:900; }
        .body { padding:18px; }
        .meta { color:var(--muted); font-size:.78rem; font-weight:700; margin-bottom:8px; }
        .body h2 { margin:0; font-size:1.05rem; line-height:1.35; }
        .body p { margin:8px 0 0; color:var(--muted); font-size:.88rem; }
        .pagination { display:flex; gap:8px; flex-wrap:wrap; padding:0 0 64px; }
        .pagination a,.pagination span { min-width:36px; min-height:36px; display:grid; place-items:center; border:1px solid var(--line); border-radius:8px; background:var(--surface); color:var(--muted); font-weight:800; }
        .pagination .active { background:var(--blue); color:#fff; border-color:var(--blue); }
        .empty { padding:40px; border:1px dashed var(--line); border-radius:var(--radius); color:var(--muted); text-align:center; background:var(--surface); }
        @media (max-width:900px){ .grid{grid-template-columns:repeat(2,1fr);} }
        @media (max-width:620px){ .grid{grid-template-columns:1fr;} .wrap{width:min(100% - 28px,1120px);} }
    </style>
</head>
<body>
    <header class="topbar">
        <nav class="wrap nav">
            <a class="brand" href="{{ route('home') }}">paham<span>IT</span></a>
            <a href="{{ route('home') }}">Kembali ke Beranda</a>
        </nav>
    </header>

    <main class="wrap">
        <section class="hero">
            <p class="eyebrow">{{ $archiveType === 'tag' ? 'Tag' : 'Kategori' }}</p>
            <h1>{{ $title }}</h1>
            <p>{{ $description }}</p>
        </section>

        @if ($items->count())
            <section class="grid">
                @foreach ($items as $item)
                    @php
                        $routeName = match ($item->type) {
                            'tutorial' => 'post.panduan',
                            'jualan' => 'post.toko',
                            default => 'post.berita',
                        };
                    @endphp
                    <a class="card" href="{{ route($routeName, $item->slug) }}">
                        <div class="visual" @if ($item->featured_image_url) style="background-image:linear-gradient(160deg,rgba(7,31,79,.75),rgba(11,111,238,.45)),url('{{ $item->featured_image_url }}')" @endif>
                            <span class="badge">{{ $item->category ?: ucfirst($item->type) }}</span>
                        </div>
                        <div class="body">
                            <div class="meta">{{ optional($item->published_at)->format('d M Y') }} - {{ number_format($item->views_count) }} views</div>
                            <h2>{{ $item->title }}</h2>
                            <p>{{ Str::limit($item->excerpt ?: 'Baca selengkapnya di Pahamit.', 110) }}</p>
                        </div>
                    </a>
                @endforeach
            </section>
            @if ($items->hasPages())
                <div class="pagination">
                    @for ($p = 1; $p <= $items->lastPage(); $p++)
                        @if ($p === $items->currentPage())
                            <span class="active">{{ $p }}</span>
                        @else
                            <a href="{{ $items->url($p) }}">{{ $p }}</a>
                        @endif
                    @endfor
                </div>
            @endif
        @else
            <div class="empty">Belum ada artikel untuk arsip ini.</div>
        @endif
    </main>
</body>
</html>
