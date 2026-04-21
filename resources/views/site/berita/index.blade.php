<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Semua berita dan artikel IT terbaru dari pahamIT - portal berita teknologi terpercaya Indonesia.">
    <title>Berita IT - pahamIT</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800&display=swap" rel="stylesheet">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <style>
        :root {
            --navy:      #071f4f;
            --blue:      #0b6fee;
            --blue-dark: #0a60d4;
            --red:       #ed1c24;
            --green:     #16a34a;
            --bg:        #f3f6fb;
            --surface:   #ffffff;
            --surface2:  #eef2f9;
            --text:      #0d1526;
            --muted:     #5a6a80;
            --line:      #dde3ef;
            --soft-blue: rgba(11,111,238,.1);
            --soft-red:  rgba(237,28,36,.1);
            --radius:    12px;
            --shadow:    0 2px 12px rgba(7,31,79,.07), 0 1px 3px rgba(7,31,79,.05);
            --shadow-md: 0 8px 32px rgba(7,31,79,.11), 0 2px 8px rgba(7,31,79,.06);
        }
        [data-theme="dark"] {
            --bg:      #060a13; --surface: #0d1526; --surface2: #111d33;
            --text:    #eef2f8; --muted:   #8fa3bc; --line:     #1a2740;
            --shadow:  0 2px 12px rgba(0,0,0,.35), 0 1px 3px rgba(0,0,0,.2);
            --shadow-md: 0 8px 32px rgba(0,0,0,.45), 0 2px 8px rgba(0,0,0,.25);
            --soft-blue: rgba(11,111,238,.18); --soft-red: rgba(237,28,36,.16);
        }
        *, *::before, *::after { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body { margin: 0; font-family: "Instrument Sans", ui-sans-serif, system-ui, sans-serif;
            color: var(--text); background: var(--bg); line-height: 1.65; overflow-x: hidden; transition: background .22s, color .22s; }
        a { color: inherit; text-decoration: none; }
        img { display: block; max-width: 100%; }
        button { font: inherit; cursor: pointer; }

        /* NAV */
        .topbar { position: sticky; top: 0; z-index: 50; background: rgba(255,255,255,.92); border-bottom: 1px solid var(--line); backdrop-filter: blur(24px); transition: background .22s; }
        [data-theme="dark"] .topbar { background: rgba(6,10,19,.93); }
        .nav-inner { width: min(1180px, calc(100% - 40px)); margin: 0 auto; display: flex; align-items: center; justify-content: space-between; gap: 16px; min-height: 64px; }
        .brand img { height: 34px; width: auto; transition: filter .22s; }
        [data-theme="dark"] .brand img { filter: brightness(0) invert(1); }
        .nav-links { display: flex; align-items: center; gap: 2px; }
        .nav-links a { padding: 7px 13px; border-radius: 8px; color: var(--muted); font-size: .86rem; font-weight: 700; transition: .15s; }
        .nav-links a:hover, .nav-links a.active { color: var(--blue); background: var(--soft-blue); }
        .nav-right { display: flex; align-items: center; gap: 8px; }
        .icon-btn { width: 36px; height: 36px; border-radius: 8px; border: 1px solid var(--line); background: var(--surface); color: var(--muted); display: grid; place-items: center; transition: .15s; }
        .icon-btn:hover { background: var(--soft-blue); color: var(--blue); }
        [data-theme="dark"] .sun { display: none; }
        [data-theme="light"] .moon { display: none; }
        .home-btn { height: 34px; padding: 0 13px; border-radius: 8px; border: 1px solid var(--line); background: var(--surface); color: var(--muted); font-size: .82rem; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; transition: .15s; }
        .home-btn:hover { background: var(--soft-blue); color: var(--blue); }

        /* PAGE HERO */
        .page-hero { background: linear-gradient(145deg, #030d20 0%, #071f4f 45%, #0c1540 75%, #0e0830 100%); padding: 48px 0 52px; position: relative; overflow: hidden; color: #fff; }
        .page-hero::before { content: ""; position: absolute; inset: 0; pointer-events: none; background: radial-gradient(ellipse 70% 80% at 10% 60%, rgba(11,111,238,.32), transparent 55%), radial-gradient(ellipse 50% 60% at 90% 20%, rgba(237,28,36,.2), transparent 55%); }
        .page-hero-inner { width: min(1180px, calc(100% - 40px)); margin: 0 auto; position: relative; z-index: 1; }
        .page-hero-label { display: inline-flex; align-items: center; gap: 8px; font-size: .72rem; font-weight: 800; letter-spacing: .08em; text-transform: uppercase; color: #ed6b6e; background: rgba(237,28,36,.18); border: 1px solid rgba(237,28,36,.3); padding: 4px 12px; border-radius: 999px; margin-bottom: 16px; }
        .page-hero h1 { font-size: clamp(1.8rem, 4vw, 2.8rem); font-weight: 800; line-height: 1.1; letter-spacing: -.03em; margin: 0 0 12px; }
        .page-hero p { color: #8fa3c0; font-size: 1rem; margin: 0; max-width: 520px; }

        /* SEARCH + FILTER */
        .search-bar { background: var(--surface); border-bottom: 1px solid var(--line); padding: 18px 0; position: sticky; top: 64px; z-index: 40; }
        .search-inner { width: min(1180px, calc(100% - 40px)); margin: 0 auto; display: flex; gap: 10px; align-items: center; flex-wrap: wrap; }
        .search-form { display: flex; flex: 1; min-width: 240px; background: var(--surface2); border: 1px solid var(--line); border-radius: var(--radius); overflow: hidden; }
        .search-form input { flex: 1; border: none; background: none; padding: 10px 14px; font: inherit; font-size: .9rem; color: var(--text); outline: none; }
        .search-form button { border: none; background: var(--blue); color: #fff; padding: 0 18px; font-size: .85rem; font-weight: 700; display: flex; align-items: center; gap: 6px; cursor: pointer; transition: background .15s; }
        .search-form button:hover { background: var(--blue-dark); }
        .filter-row { display: flex; gap: 8px; flex-wrap: wrap; align-items: center; }
        .filter-tag { height: 32px; padding: 0 13px; border-radius: 999px; border: 1px solid var(--line); background: var(--surface); color: var(--muted); font-size: .78rem; font-weight: 700; text-decoration: none; transition: .15s; display: inline-flex; align-items: center; }
        .filter-tag:hover, .filter-tag.active { background: var(--blue); color: #fff; border-color: var(--blue); }
        .clear-btn { height: 32px; padding: 0 13px; border-radius: 999px; border: 1px solid rgba(237,28,36,.3); background: var(--soft-red); color: var(--red); font-size: .78rem; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 5px; transition: .15s; }
        .clear-btn:hover { background: var(--red); color: #fff; border-color: var(--red); }

        /* GRID */
        .main-wrap { width: min(1180px, calc(100% - 40px)); margin: 40px auto 80px; }
        .result-count { font-size: .82rem; color: var(--muted); margin-bottom: 20px; font-weight: 600; }
        .result-count strong { color: var(--text); }
        .posts-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }

        /* CARD */
        .news-card { background: var(--surface); border: 1px solid var(--line); border-radius: var(--radius); overflow: hidden; box-shadow: var(--shadow); transition: box-shadow .2s, transform .2s; display: flex; flex-direction: column; }
        .news-card:hover { box-shadow: var(--shadow-md); transform: translateY(-3px); }
        .card-img { aspect-ratio: 16/9; overflow: hidden; position: relative; background: linear-gradient(145deg, #071f4f, #0c1540); }
        .card-img img { width: 100%; height: 100%; object-fit: cover; transition: transform .3s; }
        .news-card:hover .card-img img { transform: scale(1.04); }
        .card-badge { position: absolute; top: 10px; left: 10px; background: rgba(11,111,238,.85); color: #fff; font-size: .65rem; font-weight: 800; letter-spacing: .06em; padding: 3px 9px; border-radius: 999px; text-transform: uppercase; backdrop-filter: blur(4px); }
        .card-body { padding: 16px; flex: 1; display: flex; flex-direction: column; gap: 8px; }
        .card-meta { display: flex; align-items: center; gap: 10px; font-size: .72rem; color: var(--muted); font-weight: 600; }
        .card-title { font-size: .95rem; font-weight: 800; line-height: 1.35; color: var(--text); transition: color .15s; }
        .news-card:hover .card-title { color: var(--blue); }
        .card-excerpt { font-size: .82rem; color: var(--muted); line-height: 1.6; flex: 1; }
        .card-link { display: inline-flex; align-items: center; gap: 5px; font-size: .78rem; font-weight: 800; color: var(--blue); margin-top: auto; }

        /* EMPTY STATE */
        .empty { text-align: center; padding: 80px 20px; }
        .empty-icon { width: 56px; height: 56px; margin: 0 auto 16px; background: var(--surface2); border-radius: 50%; display: grid; place-items: center; color: var(--muted); }
        .empty h3 { font-size: 1.1rem; font-weight: 800; margin-bottom: 8px; }
        .empty p { color: var(--muted); font-size: .9rem; }

        /* PAGINATION */
        .pagination { display: flex; justify-content: center; gap: 8px; margin-top: 40px; flex-wrap: wrap; }
        .page-btn { height: 36px; min-width: 36px; padding: 0 12px; border-radius: 8px; border: 1px solid var(--line); background: var(--surface); color: var(--muted); font-size: .82rem; font-weight: 700; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; transition: .15s; }
        .page-btn:hover { background: var(--soft-blue); color: var(--blue); border-color: rgba(11,111,238,.3); }
        .page-btn.active { background: var(--blue); color: #fff; border-color: var(--blue); }
        .page-btn.disabled { opacity: .4; pointer-events: none; }

        /* FOOTER */
        .footer { background: var(--navy); padding: 24px 0; border-top: 1px solid rgba(255,255,255,.06); }
        .footer-inner { width: min(1180px, calc(100% - 40px)); margin: 0 auto; display: flex; align-items: center; justify-content: space-between; gap: 16px; font-size: .78rem; color: #4d6a83; }
        .footer-inner a { color: #4d6a83; transition: color .15s; }
        .footer-inner a:hover { color: #9ed0ff; }

        @media (max-width: 900px) { .posts-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 580px) { .posts-grid { grid-template-columns: 1fr; } .nav-links { display: none; } .search-inner { flex-direction: column; align-items: stretch; } }
    </style>
</head>
<body>

<header class="topbar">
    <div class="nav-inner">
        <a class="brand" href="{{ route('home') }}">
            <img src="{{ asset('images/clean/logo_full_clean.png') }}" alt="pahamIT">
        </a>
        <nav class="nav-links">
            <a href="{{ route('home') }}">Beranda</a>
            <a href="{{ route('listing.berita') }}" class="active">Berita</a>
            <a href="{{ route('listing.panduan') }}">Panduan</a>
            <a href="{{ route('about') }}">Tentang</a>
        </nav>
        <div class="nav-right">
            <button class="icon-btn" id="themeToggle" aria-label="Ganti tema">
                <svg class="sun" width="15" height="15" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="4" stroke="currentColor" stroke-width="2"/><path d="M12 2v2m0 16v2M4.22 4.22l1.42 1.42m12.72 12.72 1.42 1.42M2 12h2m16 0h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                <svg class="moon" width="15" height="15" viewBox="0 0 24 24" fill="none"><path d="M21 12.79A9 9 0 1 1 11.21 3a7 7 0 0 0 9.79 9.79Z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            </button>
            <a class="home-btn" href="{{ route('home') }}">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                Beranda
            </a>
        </div>
    </div>
</header>

<div class="page-hero">
    <div class="page-hero-inner">
        <div class="page-hero-label">
            <svg width="11" height="11" viewBox="0 0 24 24" fill="none"><path d="M4 22V12M4 12V7a3 3 0 0 1 3-3h10a3 3 0 0 1 3 3v5M4 12h16M4 22h16M4 22V12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            Berita IT
        </div>
        <h1>Semua Berita & Artikel</h1>
        <p>Kumpulan berita teknologi, jaringan, keamanan siber, dan dunia IT terkini dari tim pahamIT.</p>
    </div>
</div>

<div class="search-bar">
    <div class="search-inner">
        <form class="search-form" method="GET" action="{{ route('listing.berita') }}">
            <input type="search" name="q" value="{{ $query }}" placeholder="Cari berita..." autocomplete="off">
            @if($cat)<input type="hidden" name="kategori" value="{{ $cat }}">@endif
            <button type="submit">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none"><circle cx="11" cy="11" r="8" stroke="currentColor" stroke-width="2"/><path d="m21 21-4.35-4.35" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                Cari
            </button>
        </form>
        @if($categories->count())
        <div class="filter-row">
            <a class="filter-tag {{ !$cat ? 'active' : '' }}" href="{{ route('listing.berita', $query ? ['q'=>$query] : []) }}">Semua</a>
            @foreach($categories as $c)
                <a class="filter-tag {{ $cat === $c ? 'active' : '' }}"
                   href="{{ route('listing.berita', array_filter(['q'=>$query,'kategori'=>$c])) }}">{{ $c }}</a>
            @endforeach
        </div>
        @endif
        @if($query || $cat)
            <a class="clear-btn" href="{{ route('listing.berita') }}">
                <svg width="11" height="11" viewBox="0 0 24 24" fill="none"><path d="M18 6 6 18M6 6l12 12" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/></svg>
                Reset
            </a>
        @endif
    </div>
</div>

<div class="main-wrap">
    <p class="result-count">
        Menampilkan <strong>{{ $posts->total() }}</strong> artikel
        @if($query) untuk "<strong>{{ $query }}</strong>"@endif
        @if($cat) kategori "<strong>{{ $cat }}</strong>"@endif
    </p>

    @if($posts->count())
    <div class="posts-grid">
        @foreach($posts as $post)
        <a href="{{ route('post.berita', $post->slug) }}" class="news-card">
            <div class="card-img">
                @if($post->featured_image_url)
                    <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" loading="lazy">
                @endif
                @if($post->category)
                    <span class="card-badge">{{ $post->category }}</span>
                @endif
            </div>
            <div class="card-body">
                <div class="card-meta">
                    <span>{{ optional($post->published_at)->diffForHumans() ?? '-' }}</span>
                    <span>-</span>
                    <span>{{ number_format($post->views_count) }} views</span>
                </div>
                <div class="card-title">{{ $post->title }}</div>
                @if($post->excerpt)
                <div class="card-excerpt">{{ Str::limit($post->excerpt, 90) }}</div>
                @endif
                <span class="card-link">Baca selengkapnya <svg width="11" height="11" viewBox="0 0 24 24" fill="none"><path d="M5 12h14m-6-6 6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
            </div>
        </a>
        @endforeach
    </div>

    {{-- Pagination --}}
    @if($posts->hasPages())
    <div class="pagination">
        @if($posts->onFirstPage())
            <span class="page-btn disabled"><- Prev</span>
        @else
            <a class="page-btn" href="{{ $posts->previousPageUrl() }}"><- Prev</a>
        @endif
        @foreach($posts->getUrlRange(max(1,$posts->currentPage()-2), min($posts->lastPage(),$posts->currentPage()+2)) as $page => $url)
            <a class="page-btn {{ $page == $posts->currentPage() ? 'active' : '' }}" href="{{ $url }}">{{ $page }}</a>
        @endforeach
        @if($posts->hasMorePages())
            <a class="page-btn" href="{{ $posts->nextPageUrl() }}">Next -></a>
        @else
            <span class="page-btn disabled">Next -></span>
        @endif
    </div>
    @endif

    @else
    <div class="empty">
        <div class="empty-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none"><circle cx="11" cy="11" r="8" stroke="currentColor" stroke-width="2"/><path d="m21 21-4.35-4.35" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg></div>
        <h3>Tidak ada artikel ditemukan</h3>
        <p>Coba kata kunci atau filter yang berbeda.</p>
    </div>
    @endif
</div>

<footer class="footer">
    <div class="footer-inner">
        <span>&copy; {{ date('Y') }} <strong style="color:#4d6a83;">pahamIT</strong> - Bukan Sekadar Belajar.</span>
        <div style="display:flex;gap:16px;">
            <a href="{{ route('home') }}">Beranda</a>
            <a href="{{ route('listing.panduan') }}">Panduan</a>
            <a href="{{ route('about') }}">Tentang</a>
        </div>
    </div>
</footer>

<script>
    const html  = document.documentElement;
    const saved = localStorage.getItem('pahamit-theme');
    if (saved) html.setAttribute('data-theme', saved);
    else if (window.matchMedia('(prefers-color-scheme: dark)').matches) html.setAttribute('data-theme','dark');
    document.getElementById('themeToggle').addEventListener('click', () => {
        const n = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
        html.setAttribute('data-theme', n);
        localStorage.setItem('pahamit-theme', n);
    });
</script>
@include('site.partials.adroll')
</body>
</html>
