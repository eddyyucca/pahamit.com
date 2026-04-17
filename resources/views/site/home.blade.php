<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="pahamIT — Portal berita IT, panduan belajar, dan toko alat & jasa IT terpercaya. Bukan Sekadar Belajar.">
    <title>pahamIT | Bukan Sekadar Belajar.</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800&display=swap" rel="stylesheet">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <style>
        :root {
            --navy:    #071f4f;
            --blue:    #0b6fee;
            --red:     #ed1c24;
            --green:   #16a34a;
            --amber:   #f59e0b;
            --bg:      #f4f7fc;
            --surface: #ffffff;
            --surface2:#eef3fb;
            --text:    #0f172a;
            --muted:   #64748b;
            --line:    #dbe4f0;
            --shadow:  0 4px 24px rgba(7,31,79,.08);
            --shadow-md:0 12px 40px rgba(7,31,79,.12);
            --soft-blue:rgba(11,111,238,.1);
            --soft-red: rgba(237,28,36,.1);
            --radius:  10px;
        }
        [data-theme="dark"] {
            --bg:      #070b14;
            --surface: #0f172a;
            --surface2:#111d33;
            --text:    #f1f5f9;
            --muted:   #94a3b8;
            --line:    #1e2d45;
            --shadow:  0 4px 24px rgba(0,0,0,.3);
            --shadow-md:0 12px 40px rgba(0,0,0,.4);
            --soft-blue:rgba(11,111,238,.18);
            --soft-red: rgba(237,28,36,.16);
        }
        *, *::before, *::after { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            margin: 0;
            font-family: "Instrument Sans", ui-sans-serif, system-ui, sans-serif;
            color: var(--text); background: var(--bg);
            line-height: 1.65; overflow-x: hidden;
            transition: background .22s, color .22s;
        }
        a { color: inherit; text-decoration: none; }
        img, svg { display: block; }
        button { font: inherit; cursor: pointer; }

        /* ── Layout ── */
        .wrap { width: min(1180px, calc(100% - 40px)); margin: 0 auto; }

        /* ── Nav ── */
        .topbar {
            position: sticky; top: 0; z-index: 50;
            background: rgba(255,255,255,.9);
            border-bottom: 1px solid var(--line);
            backdrop-filter: blur(20px);
            transition: background .22s, border-color .22s;
        }
        [data-theme="dark"] .topbar { background: rgba(7,11,20,.92); }
        .nav-inner {
            width: min(1180px, calc(100% - 40px)); margin: 0 auto;
            display: flex; align-items: center;
            justify-content: space-between; gap: 16px;
            min-height: 66px;
        }
        .brand { display: flex; align-items: center; flex-shrink: 0; }
        .brand-logo-img { height: 36px; width: auto; transition: filter .22s; }
        [data-theme="dark"] .brand-logo-img { filter: brightness(0) invert(1); }

        .nav-links { display: flex; align-items: center; gap: 2px; }
        .nav-links a {
            padding: 8px 13px; border-radius: 8px;
            color: var(--muted); font-size: .9rem; font-weight: 700;
            transition: color .15s, background .15s;
            position: relative;
        }
        .nav-links a:hover { color: var(--blue); background: var(--soft-blue); }
        .nav-links a.active { color: var(--blue); }
        .nav-links a.active::after {
            content: "";
            position: absolute; bottom: 2px; left: 13px; right: 13px;
            height: 2px; border-radius: 2px; background: var(--blue);
        }

        .nav-right { display: flex; align-items: center; gap: 8px; }
        .theme-btn {
            width: 38px; height: 38px; border-radius: 8px;
            border: 1px solid var(--line); background: var(--surface);
            color: var(--muted); display: grid; place-items: center;
            transition: .15s;
        }
        .theme-btn:hover { background: var(--soft-blue); color: var(--blue); border-color: var(--blue); }
        [data-theme="dark"] .sun { display: none; }
        [data-theme="light"] .moon { display: none; }

        .menu-btn {
            display: none;
            width: 38px; height: 38px; border-radius: 8px;
            border: 1px solid var(--line); background: var(--surface);
            color: var(--text); place-items: center; transition: .15s;
        }
        .menu-btn:hover { background: var(--soft-blue); }

        .mobile-menu { display: none; padding: 0 0 14px; }
        .mobile-menu.open { display: grid; gap: 6px; }
        .mobile-menu a {
            padding: 12px 14px; border: 1px solid var(--line);
            border-radius: 8px; background: var(--surface);
            color: var(--muted); font-weight: 700;
            transition: color .15s, background .15s;
        }
        .mobile-menu a:hover { color: var(--blue); background: var(--soft-blue); }

        /* ── Hero ── */
        .hero {
            position: relative; overflow: hidden; color: #fff;
            background: linear-gradient(135deg, #071f4f 0%, #0a1a3a 50%, #0f0a2e 100%);
        }
        .hero::before {
            content: "";
            position: absolute; inset: 0; pointer-events: none;
            background:
                radial-gradient(ellipse 80% 70% at 15% 60%, rgba(11,111,238,.28), transparent 60%),
                radial-gradient(ellipse 60% 50% at 85% 15%, rgba(237,28,36,.18), transparent 60%),
                radial-gradient(ellipse 40% 40% at 60% 90%, rgba(8,145,178,.12), transparent 55%);
        }
        .hero::after {
            content: "";
            position: absolute; inset: 0; pointer-events: none;
            background-image:
                linear-gradient(rgba(255,255,255,.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.04) 1px, transparent 1px);
            background-size: 40px 40px;
            mask-image: linear-gradient(to bottom, rgba(0,0,0,.5), transparent 70%);
        }
        .hero-inner {
            position: relative; z-index: 1;
            width: min(800px, calc(100% - 40px)); margin: 0 auto;
            text-align: center; padding: 88px 0 32px;
        }
        .eyebrow {
            display: inline-flex; align-items: center; gap: 9px;
            margin: 0 0 24px; padding: 6px 14px;
            border: 1px solid rgba(255,255,255,.18); border-radius: 999px;
            background: rgba(255,255,255,.08);
            color: #dbeafe; font-size: .75rem; font-weight: 800;
            text-transform: uppercase; letter-spacing: .09em;
        }
        .eyebrow-dot {
            width: 7px; height: 7px; border-radius: 50%;
            background: #22c55e; box-shadow: 0 0 0 4px rgba(34,197,94,.25);
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%,100% { box-shadow: 0 0 0 4px rgba(34,197,94,.25); }
            50%      { box-shadow: 0 0 0 7px rgba(34,197,94,.1); }
        }
        h1 {
            margin: 0; font-size: clamp(2.1rem, 5.5vw, 3.9rem);
            line-height: 1.04; letter-spacing: -.025em;
        }
        .hero strong { color: #93c5fd; }
        .hero-copy {
            max-width: 580px; margin: 22px auto 0;
            color: #b8cfe8; font-size: 1.05rem; line-height: 1.8;
        }
        .hero-actions {
            display: flex; flex-wrap: wrap; justify-content: center;
            gap: 12px; margin-top: 34px;
        }
        .btn {
            min-height: 46px; display: inline-flex; align-items: center;
            justify-content: center; gap: 8px; padding: 0 22px;
            border: 1px solid transparent; border-radius: var(--radius);
            font-size: .95rem; font-weight: 800; white-space: nowrap;
            transition: transform .15s, box-shadow .15s, background .15s;
        }
        .btn:hover { transform: translateY(-1px); }
        .btn-primary {
            color: #fff; background: var(--blue);
            box-shadow: 0 8px 20px rgba(11,111,238,.3);
        }
        .btn-primary:hover { background: #0a62d4; box-shadow: 0 12px 28px rgba(11,111,238,.4); }
        .btn-soft {
            color: #fff; border-color: rgba(255,255,255,.25);
            background: rgba(255,255,255,.1);
        }
        .btn-soft:hover { background: rgba(255,255,255,.18); }
        .btn-soft-dark {
            color: var(--text); border-color: var(--line); background: var(--surface);
        }
        .btn-soft-dark:hover { background: var(--surface2); }

        /* hero stats */
        .hero-stats {
            position: relative; z-index: 1;
            width: min(1180px, calc(100% - 40px)); margin: 0 auto;
            display: flex; justify-content: center; gap: 0;
            padding: 28px 0 0; border-top: 1px solid rgba(255,255,255,.1);
            margin-top: 48px;
        }
        .hero-stat {
            flex: 1; max-width: 220px; text-align: center;
            padding: 20px 16px 24px;
        }
        .hero-stat + .hero-stat { border-left: 1px solid rgba(255,255,255,.1); }
        .hero-stat-num {
            font-size: 1.9rem; font-weight: 900; color: #fff;
            letter-spacing: -.02em; line-height: 1;
        }
        .hero-stat-label {
            font-size: .78rem; font-weight: 700; color: #7494bc;
            margin-top: 6px; text-transform: uppercase; letter-spacing: .06em;
        }

        /* ── Focus cards ── */
        .focus-wrap {
            padding: 0 0 0;
        }
        .focus-grid {
            display: grid; grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-top: -32px; position: relative; z-index: 5;
        }
        .focus-card {
            padding: 24px 22px;
            border: 1px solid var(--line); border-radius: var(--radius);
            background: var(--surface); box-shadow: var(--shadow);
            transition: transform .2s, box-shadow .2s;
        }
        .focus-card:hover { transform: translateY(-3px); box-shadow: var(--shadow-md); }
        .focus-icon {
            width: 48px; height: 48px; border-radius: 10px;
            display: grid; place-items: center; margin-bottom: 16px;
            background: var(--soft-blue); color: var(--blue);
        }
        .focus-card:nth-child(2) .focus-icon { background: var(--soft-red); color: var(--red); }
        .focus-card:nth-child(3) .focus-icon { background: rgba(22,163,74,.1); color: var(--green); }
        .focus-card h2 { margin: 0 0 8px; font-size: 1.1rem; }
        .focus-card p { margin: 0; color: var(--muted); font-size: .9rem; line-height: 1.6; }
        .focus-link {
            display: inline-flex; align-items: center; gap: 5px;
            margin-top: 14px; font-size: .82rem; font-weight: 800;
            color: var(--blue);
        }
        .focus-card:nth-child(2) .focus-link { color: var(--red); }
        .focus-card:nth-child(3) .focus-link { color: var(--green); }

        /* ── Sections ── */
        .section { padding: 72px 0; }
        .section-alt { background: var(--surface); }

        .section-head {
            display: flex; align-items: flex-end;
            justify-content: space-between; gap: 24px; margin-bottom: 32px;
        }
        .label {
            margin: 0 0 8px; color: var(--red); font-size: .75rem;
            font-weight: 900; text-transform: uppercase; letter-spacing: .1em;
        }
        .section-title {
            max-width: 680px; margin: 0;
            font-size: clamp(1.6rem, 3vw, 2.4rem);
            line-height: 1.1; letter-spacing: -.02em;
        }
        .section-copy {
            max-width: 560px; margin: 10px 0 0;
            color: var(--muted); line-height: 1.7; font-size: .95rem;
        }
        .link-more {
            display: inline-flex; align-items: center; gap: 7px;
            color: var(--blue); font-weight: 900; font-size: .9rem;
            white-space: nowrap; flex-shrink: 0;
            transition: gap .15s;
        }
        .link-more:hover { gap: 10px; }

        /* ── News grid ── */
        .news-grid { display: grid; grid-template-columns: 1.2fr .9fr .9fr; gap: 18px; }
        .news-card {
            border: 1px solid var(--line); border-radius: var(--radius);
            background: var(--surface); overflow: hidden;
            box-shadow: var(--shadow);
            transition: transform .2s, box-shadow .2s;
            display: block;
        }
        .news-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-md); }
        .news-visual {
            min-height: 200px; padding: 16px;
            display: flex; flex-direction: column; justify-content: flex-end;
            background:
                linear-gradient(160deg, rgba(7,31,79,.88), rgba(11,111,238,.55)),
                var(--surface2);
            background-size: cover; background-position: center;
            position: relative;
        }
        .news-card.featured .news-visual { min-height: 240px; }
        .news-card:nth-child(2) .news-visual {
            background: linear-gradient(160deg, rgba(237,28,36,.88), rgba(7,31,79,.7)), var(--surface2);
            background-size: cover; background-position: center;
        }
        .news-card:nth-child(3) .news-visual {
            background: linear-gradient(160deg, rgba(8,145,178,.88), rgba(7,31,79,.8)), var(--surface2);
            background-size: cover; background-position: center;
        }
        .badge {
            display: inline-flex; align-items: center;
            height: 26px; padding: 0 10px; border-radius: 999px;
            background: rgba(255,255,255,.92); color: #071f4f;
            font-size: .72rem; font-weight: 900; width: fit-content;
        }
        .card-body { padding: 18px 20px 20px; }
        .card-meta {
            display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 9px;
            color: var(--muted); font-size: .78rem; font-weight: 700;
        }
        .card-meta span { display: flex; align-items: center; gap: 4px; }
        .card-body h3 { margin: 0; font-size: 1.15rem; line-height: 1.3; }
        .news-card.featured .card-body h3 { font-size: clamp(1.3rem, 2.5vw, 1.75rem); }
        .card-body p { margin: 9px 0 0; color: var(--muted); font-size: .88rem; line-height: 1.55;
            display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .card-views {
            display: inline-flex; align-items: center; gap: 4px;
            margin-top: 12px; font-size: .76rem; font-weight: 700; color: var(--muted);
        }

        /* ── Guide grid ── */
        .guide-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; }
        .guide-card {
            padding: 22px; border: 1px solid var(--line); border-radius: var(--radius);
            background: var(--surface); box-shadow: var(--shadow);
            display: block; transition: transform .2s, box-shadow .2s, border-color .2s;
        }
        .guide-card:hover { transform: translateY(-3px); box-shadow: var(--shadow-md); border-color: var(--blue); }
        .guide-step {
            width: 36px; height: 36px; border-radius: 8px;
            display: grid; place-items: center; margin-bottom: 16px;
            color: #fff; background: var(--navy); font-weight: 900; font-size: .9rem;
        }
        [data-theme="dark"] .guide-step { background: var(--blue); }
        .guide-card h3 { margin: 0 0 8px; font-size: 1rem; line-height: 1.35; }
        .guide-card p { margin: 0; color: var(--muted); font-size: .87rem; line-height: 1.55; }

        /* ── Shop grid ── */
        .shop-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 18px; }
        .shop-card {
            border: 1px solid var(--line); border-radius: var(--radius);
            background: var(--surface); overflow: hidden; box-shadow: var(--shadow);
            transition: transform .2s, box-shadow .2s;
        }
        .shop-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-md); }
        .shop-top {
            min-height: 140px; display: grid; place-items: center;
            background: linear-gradient(135deg, rgba(11,111,238,.1), rgba(237,28,36,.08)), var(--surface2);
            background-size: cover; background-position: center;
        }
        .shop-icon {
            width: 68px; height: 68px; border-radius: 10px;
            display: grid; place-items: center; color: #fff;
            background: linear-gradient(135deg, var(--blue), var(--navy));
        }
        .shop-card:nth-child(2) .shop-icon { background: linear-gradient(135deg, var(--red), #9f1239); }
        .shop-card:nth-child(3) .shop-icon { background: linear-gradient(135deg, var(--green), #0891b2); }
        .shop-body { padding: 18px 20px 20px; }
        .shop-body h3 { margin: 8px 0 6px; font-size: 1.05rem; }
        .shop-body p { margin: 0; color: var(--muted); font-size: .87rem;
            display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .price-row {
            display: flex; align-items: center; justify-content: space-between;
            gap: 12px; margin-top: 16px;
        }
        .price { font-weight: 900; color: var(--red); font-size: 1rem; }
        .small-btn {
            height: 34px; padding: 0 14px; border-radius: 8px;
            color: #fff; background: var(--blue);
            font-size: .82rem; font-weight: 900;
            display: inline-flex; align-items: center;
            transition: background .15s;
        }
        .small-btn:hover { background: #0a62d4; }

        /* ── Service band ── */
        .service-band {
            display: grid; grid-template-columns: .95fr 1.05fr;
            gap: 24px; align-items: stretch; padding: 32px;
            border-radius: var(--radius); color: #fff;
            background: linear-gradient(135deg, rgba(7,31,79,.98), rgba(237,28,36,.78)), var(--navy);
            box-shadow: var(--shadow-md);
        }
        .service-band h2 { margin: 0; font-size: clamp(1.6rem, 3vw, 2.4rem); line-height: 1.1; }
        .service-band > div > p { margin: 14px 0 0; color: #c5d5e8; font-size: .95rem; line-height: 1.7; }
        .service-actions { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 28px; }
        .service-list { display: grid; gap: 12px; }
        .service-card {
            display: grid; grid-template-columns: 42px 1fr;
            gap: 14px; padding: 16px 18px;
            border: 1px solid rgba(255,255,255,.12); border-radius: 8px;
            background: rgba(255,255,255,.07); transition: background .15s;
        }
        .service-card:hover { background: rgba(255,255,255,.12); }
        .service-card svg { color: #93c5fd; margin-top: 1px; }
        .service-card h3 { margin: 0 0 4px; font-size: .95rem; }
        .service-card p { margin: 0; color: #b8cfe8; font-size: .85rem; line-height: 1.5; }

        /* ── CTA ── */
        .cta {
            padding: 36px; display: grid;
            grid-template-columns: 1fr auto; gap: 24px; align-items: center;
            border: 1px solid var(--line); border-radius: var(--radius);
            background: var(--surface); box-shadow: var(--shadow);
        }
        .cta h2 { margin: 0; font-size: clamp(1.45rem, 2.8vw, 2.1rem); line-height: 1.15; }
        .cta p { margin: 10px 0 0; color: var(--muted); font-size: .95rem; }

        /* ── Footer ── */
        .footer {
            padding: 36px 0; border-top: 1px solid var(--line);
            background: var(--surface); color: var(--muted);
        }
        .footer-inner {
            display: flex; align-items: center;
            justify-content: space-between; gap: 24px; font-size: .88rem;
        }
        .footer strong { color: var(--text); }
        .footer-nav { display: flex; gap: 20px; }
        .footer-nav a { color: var(--muted); font-weight: 600; font-size: .84rem; transition: color .15s; }
        .footer-nav a:hover { color: var(--blue); }

        /* ── Scroll reveal ── */
        .reveal { opacity: 0; transform: translateY(18px); transition: opacity .55s, transform .55s; }
        .reveal.visible { opacity: 1; transform: none; }

        /* ── Responsive ── */
        @media (max-width: 980px) {
            .nav-links { display: none; }
            .menu-btn { display: inline-grid; }
            .service-band, .cta { grid-template-columns: 1fr; }
            .focus-grid, .shop-grid { grid-template-columns: repeat(2, 1fr); }
            .news-grid { grid-template-columns: 1fr 1fr; }
            .guide-grid { grid-template-columns: repeat(2, 1fr); }
            .hero-stats { flex-wrap: wrap; }
            .hero-stat { min-width: 50%; }
        }
        @media (max-width: 640px) {
            .hero-inner { padding: 60px 0 28px; }
            .hero-copy { font-size: .97rem; }
            .hero-stats { flex-wrap: wrap; }
            .hero-stat { min-width: 50%; }
            .section { padding: 52px 0; }
            .section-head { display: block; }
            .section-head .link-more { margin-top: 12px; }
            .focus-grid, .news-grid, .guide-grid, .shop-grid { grid-template-columns: 1fr; }
            .focus-grid { margin-top: 16px; }
            .cta { padding: 22px; }
            .footer-inner { display: block; }
            .footer-nav { margin-top: 16px; flex-wrap: wrap; gap: 12px; }
        }
    </style>
</head>
<body>

    {{-- ── NAVBAR ── --}}
    <header class="topbar">
        <nav class="nav-inner" aria-label="Navigasi utama">
            <a class="brand" href="#home" aria-label="pahamIT">
                <img class="brand-logo-img"
                     src="{{ asset('images/clean/logo_full_clean.png') }}"
                     alt="pahamIT">
            </a>

            <div class="nav-links" id="navLinks">
                <a href="#berita" data-section="berita">Berita IT</a>
                <a href="#panduan" data-section="panduan">Panduan</a>
                <a href="#toko" data-section="toko">Toko IT</a>
                <a href="#jasa" data-section="jasa">Jasa</a>
                <a href="#kontak" data-section="kontak">Kontak</a>
            </div>

            <div class="nav-right">
                <button class="theme-btn" id="themeToggle" type="button" aria-label="Ganti mode warna">
                    <svg class="sun" width="17" height="17" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 4V2m0 20v-2M4 12H2m20 0h-2m-2.1-5.9 1.4-1.4M4.7 19.3l1.4-1.4m0-11.8L4.7 4.7m14.6 14.6-1.4-1.4M12 16a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    <svg class="moon" width="17" height="17" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M21 14.4A8.6 8.6 0 0 1 9.6 3 8.6 8.6 0 1 0 21 14.4Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
                <button class="menu-btn" id="menuBtn" type="button" aria-label="Buka menu" aria-expanded="false">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M4 7h16M4 12h16M4 17h16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                </button>
            </div>
        </nav>

        <div class="mobile-menu" id="mobileMenu" style="width:min(1180px,calc(100% - 40px));margin:0 auto;">
            <a href="#berita">Berita IT</a>
            <a href="#panduan">Panduan Belajar</a>
            <a href="#toko">Toko IT</a>
            <a href="#jasa">Jasa IT</a>
            <a href="#kontak">Kontak</a>
        </div>
    </header>

    <main id="home">

        {{-- ── HERO ── --}}
        <section class="hero">
            <div class="hero-inner">
                <p class="eyebrow"><span class="eyebrow-dot"></span>Bukan Sekadar Belajar.</p>
                <h1>Satu portal untuk <strong>berita</strong>, panduan, dan solusi IT.</h1>
                <p class="hero-copy">Ikuti perkembangan teknologi terbaru, pelajari jaringan, server, dan keamanan dari panduan praktis, serta temukan alat dan jasa IT yang langsung bisa dipakai.</p>
                <div class="hero-actions">
                    <a class="btn btn-primary" href="#berita">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M4 5h16M4 10h16M4 15h10" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                        Mulai Baca
                    </a>
                    <a class="btn btn-soft" href="#panduan">Lihat Panduan</a>
                    <a class="btn btn-soft" href="#toko">Toko IT</a>
                </div>
            </div>
            <div class="hero-stats">
                <div class="hero-stat">
                    <div class="hero-stat-num">{{ ($homeStats['berita'] ?? 0) ?: '0' }}</div>
                    <div class="hero-stat-label">Artikel Berita</div>
                </div>
                <div class="hero-stat">
                    <div class="hero-stat-num">{{ ($homeStats['tutorial'] ?? 0) ?: '0' }}</div>
                    <div class="hero-stat-label">Panduan Belajar</div>
                </div>
                <div class="hero-stat">
                    <div class="hero-stat-num">{{ ($homeStats['jualan'] ?? 0) ?: '0' }}</div>
                    <div class="hero-stat-label">Produk & Jasa</div>
                </div>
                <div class="hero-stat">
                    <div class="hero-stat-num">100%</div>
                    <div class="hero-stat-label">Gratis Dibaca</div>
                </div>
            </div>
        </section>

        {{-- ── FOCUS CARDS ── --}}
        <section class="wrap focus-wrap">
            <div class="focus-grid reveal">
                <article class="focus-card">
                    <div class="focus-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M4 5h16M4 10h16M4 15h10" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    </div>
                    <h2>Berita IT Terkini</h2>
                    <p>Update teknologi, keamanan siber, AI, cloud, jaringan, dan insight industri yang dikemas ringkas dan mudah dipahami.</p>
                    <a class="focus-link" href="#berita">Baca berita <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M5 12h14m-6-6 6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
                </article>
                <article class="focus-card">
                    <div class="focus-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M8 4h12v16H8a4 4 0 0 1-4-4V8a4 4 0 0 1 4-4Zm0 0v16M12 8h4M12 12h4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    </div>
                    <h2>Panduan & Tutorial</h2>
                    <p>Tutorial bertahap untuk network, server, Linux, security, dan troubleshooting — dari dasar hingga siap praktik langsung.</p>
                    <a class="focus-link" href="#panduan">Mulai belajar <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M5 12h14m-6-6 6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
                </article>
                <article class="focus-card">
                    <div class="focus-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M6 7h12l1 13H5L6 7Zm3 0a3 3 0 0 1 6 0" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg>
                    </div>
                    <h2>Toko Alat & Jasa IT</h2>
                    <p>Template, script, konsultasi, instalasi jaringan, dan paket layanan IT untuk kantor, sekolah, dan bisnis.</p>
                    <a class="focus-link" href="#toko">Lihat produk <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M5 12h14m-6-6 6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
                </article>
            </div>
        </section>

        {{-- ── BERITA ── --}}
        <section class="section" id="berita">
            <div class="wrap">
                <div class="section-head reveal">
                    <div>
                        <p class="label">Berita IT</p>
                        <h2 class="section-title">Update teknologi, langsung ke intinya.</h2>
                        <p class="section-copy">Berita IT terbaru — jaringan, keamanan, AI, cloud, dan software — disajikan ringkas dan mudah dicerna.</p>
                    </div>
                    <a class="link-more" href="#panduan">Lihat panduan
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M5 12h14m-6-6 6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
                </div>

                <div class="news-grid reveal">
                    @forelse ($beritaPosts as $post)
                        <a href="{{ route('post.berita', $post->slug) }}"
                           class="news-card {{ $loop->first ? 'featured' : '' }}">
                            <div class="news-visual"
                                @if ($post->featured_image_url)
                                    style="background-image: linear-gradient(160deg,rgba(7,31,79,.82),rgba(11,111,238,.5)), url('{{ $post->featured_image_url }}'); background-size:cover; background-position:center;"
                                @endif>
                                <span class="badge">{{ $post->category ?? 'Berita' }}</span>
                            </div>
                            <div class="card-body">
                                <div class="card-meta">
                                    <span>
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none"><rect x="3" y="4" width="18" height="18" rx="2" stroke="currentColor" stroke-width="2"/><path d="M16 2v4M8 2v4M3 10h18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                                        {{ optional($post->published_at)->diffForHumans() ?? 'Draft' }}
                                    </span>
                                    <span>
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8Z" stroke="currentColor" stroke-width="2"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2"/></svg>
                                        {{ number_format($post->views_count) }} views
                                    </span>
                                </div>
                                <h3>{{ $post->title }}</h3>
                                <p>{{ $post->excerpt ?: 'Baca selengkapnya di pahamIT.' }}</p>
                            </div>
                        </a>
                    @empty
                        <article class="news-card featured">
                            <div class="news-visual"><span class="badge">Headline</span></div>
                            <div class="card-body">
                                <div class="card-meta"><span>Belum ada artikel</span></div>
                                <h3>Tambahkan berita pertama dari dashboard.</h3>
                                <p>Konten dengan status published akan tampil otomatis di sini.</p>
                            </div>
                        </article>
                    @endforelse
                </div>
            </div>
        </section>

        {{-- ── PANDUAN ── --}}
        <section class="section section-alt" id="panduan">
            <div class="wrap">
                <div class="section-head reveal">
                    <div>
                        <p class="label">Panduan & Belajar IT</p>
                        <h2 class="section-title">Dari dasar sampai siap praktik.</h2>
                        <p class="section-copy">Tutorial runtut untuk networking, server, Linux, cyber security, dan troubleshooting — cocok untuk pemula maupun yang ingin naik level.</p>
                    </div>
                </div>

                <div class="guide-grid reveal">
                    @forelse ($tutorialPosts as $post)
                        <a href="{{ route('post.panduan', $post->slug) }}" class="guide-card">
                            <div class="guide-step">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</div>
                            <h3>{{ $post->title }}</h3>
                            <p>{{ Str::limit($post->excerpt ?: 'Panduan belajar dari pahamIT.', 80) }}</p>
                        </a>
                    @empty
                        <article class="guide-card">
                            <div class="guide-step">01</div>
                            <h3>Tutorial pertama menunggu</h3>
                            <p>Tambahkan panduan dari dashboard — akan tampil otomatis di sini.</p>
                        </article>
                    @endforelse
                </div>
            </div>
        </section>

        {{-- ── TOKO ── --}}
        <section class="section" id="toko">
            <div class="wrap">
                <div class="section-head reveal">
                    <div>
                        <p class="label">Toko IT</p>
                        <h2 class="section-title">Produk dan jasa IT, satu tempat.</h2>
                        <p class="section-copy">Template network, script konfigurasi, paket jasa instalasi, dan konsultasi IT tersedia di sini.</p>
                    </div>
                    <a class="link-more" href="#kontak">Minta penawaran
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M5 12h14m-6-6 6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
                </div>

                <div class="shop-grid reveal">
                    @forelse ($jualanPosts as $post)
                        <article class="shop-card">
                            <a href="{{ route('post.toko', $post->slug) }}">
                                <div class="shop-top"
                                    @if ($post->featured_image_url)
                                        style="background-image: linear-gradient(135deg,rgba(7,31,79,.45),rgba(237,28,36,.2)), url('{{ $post->featured_image_url }}'); background-size:cover; background-position:center;"
                                    @endif>
                                    @if (!$post->featured_image_url)
                                    <div class="shop-icon">
                                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none"><path d="M6 7h12l1 13H5L6 7Zm3 0a3 3 0 0 1 6 0" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg>
                                    </div>
                                    @endif
                                </div>
                            </a>
                            <div class="shop-body">
                                <div class="card-meta"><span>{{ $post->category ?? 'Produk IT' }}</span><span>{{ $post->status === 'published' ? 'Tersedia' : 'Draft' }}</span></div>
                                <a href="{{ route('post.toko', $post->slug) }}"><h3>{{ $post->title }}</h3></a>
                                <p>{{ $post->excerpt ?: 'Produk atau jasa IT dari pahamIT.' }}</p>
                                <div class="price-row">
                                    <span class="price">{{ $post->price ? 'Rp '.number_format($post->price,0,',','.') : 'Custom' }}</span>
                                    <a class="small-btn" href="{{ route('post.toko', $post->slug) }}">Detail</a>
                                </div>
                            </div>
                        </article>
                    @empty
                        <article class="shop-card">
                            <div class="shop-top"><div class="shop-icon"><svg width="28" height="28" viewBox="0 0 24 24" fill="none"><path d="M6 7h12l1 13H5L6 7Zm3 0a3 3 0 0 1 6 0" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg></div></div>
                            <div class="shop-body">
                                <div class="card-meta"><span>Produk</span></div>
                                <h3>Tambahkan produk pertama.</h3>
                                <p>Produk dan jasa yang dipublish akan tampil otomatis di sini.</p>
                                <div class="price-row"><span class="price">Custom</span><a class="small-btn" href="#kontak">Tanya</a></div>
                            </div>
                        </article>
                    @endforelse
                </div>
            </div>
        </section>

        {{-- ── JASA ── --}}
        <section class="section section-alt" id="jasa">
            <div class="wrap">
                <div class="service-band reveal">
                    <div>
                        <p class="label" style="color:#93c5fd;">Jasa IT pahamIT</p>
                        <h2>Infrastruktur stabil, belajar jalan, bisnis aman.</h2>
                        <p>pahamIT hadir sebagai partner teknis untuk setup, audit, dan maintenance infrastruktur IT — tidak hanya media baca, tapi solusi nyata.</p>
                        <div class="service-actions">
                            <a class="btn btn-primary" href="#kontak">Diskusi Kebutuhan</a>
                            <a class="btn btn-soft" href="#toko">Lihat Produk</a>
                        </div>
                    </div>
                    <div class="service-list">
                        <article class="service-card">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none"><path d="M4 7h16M7 12h10M9 17h6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                            <div><h3>Instalasi Jaringan</h3><p>Kabel, rack, switch, WiFi, VLAN, subnetting, dan dokumentasi topologi lengkap.</p></div>
                        </article>
                        <article class="service-card">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none"><path d="M12 3 5 6v5c0 4.5 2.8 7.7 7 9 4.2-1.3 7-4.5 7-9V6l-7-3Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg>
                            <div><h3>Audit Keamanan</h3><p>Review firewall, akses remote, password policy, backup, dan rekomendasi hardening.</p></div>
                        </article>
                        <article class="service-card">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none"><path d="M5 18h14M7 14l3-3 3 2 4-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            <div><h3>Monitoring & Maintenance</h3><p>Dashboard monitoring, alert downtime, laporan berkala, dan perawatan perangkat.</p></div>
                        </article>
                    </div>
                </div>
            </div>
        </section>

        {{-- ── CTA / KONTAK ── --}}
        <section class="section" id="kontak">
            <div class="wrap">
                <div class="cta reveal">
                    <div>
                        <h2>Ada kebutuhan IT? Mari diskusi.</h2>
                        <p>Dari pertanyaan teknis hingga kebutuhan infrastruktur — tim pahamIT siap membantu lewat konsultasi langsung via WhatsApp.</p>
                    </div>
                    <a class="btn btn-primary" href="https://wa.me/6281234567890" target="_blank" rel="noreferrer">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        Hubungi WhatsApp
                    </a>
                </div>
            </div>
        </section>

    </main>

    {{-- ── FOOTER ── --}}
    <footer class="footer">
        <div class="wrap footer-inner">
            <div>
                <strong>pahamIT</strong> — Bukan Sekadar Belajar.<br>
                <span style="font-size:.83rem;">Jakarta Selatan &nbsp;·&nbsp; <a href="mailto:info@pahamit.com" style="color:var(--blue);">info@pahamit.com</a></span>
            </div>
            <nav class="footer-nav">
                <a href="#berita">Berita</a>
                <a href="#panduan">Panduan</a>
                <a href="#toko">Toko</a>
                <a href="#jasa">Jasa</a>
                <a href="#kontak">Kontak</a>
            </nav>
            <div style="font-size:.83rem;">&copy; {{ date('Y') }} pahamIT</div>
        </div>
    </footer>

    <script>
        const html   = document.documentElement;
        const saved  = localStorage.getItem('pahamit-theme');
        if (saved) html.setAttribute('data-theme', saved);
        else if (window.matchMedia('(prefers-color-scheme: dark)').matches) html.setAttribute('data-theme','dark');

        document.getElementById('themeToggle').addEventListener('click', () => {
            const next = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-theme', next);
            localStorage.setItem('pahamit-theme', next);
        });

        const menuBtn    = document.getElementById('menuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        menuBtn.addEventListener('click', () => {
            const open = mobileMenu.classList.toggle('open');
            menuBtn.setAttribute('aria-expanded', String(open));
        });
        mobileMenu.querySelectorAll('a').forEach(a => a.addEventListener('click', () => {
            mobileMenu.classList.remove('open');
            menuBtn.setAttribute('aria-expanded', 'false');
        }));

        // Active nav link on scroll
        const sections = document.querySelectorAll('section[id]');
        const navAs    = document.querySelectorAll('.nav-links a[data-section]');
        const sObs = new IntersectionObserver(entries => {
            entries.forEach(e => {
                if (e.isIntersecting) {
                    navAs.forEach(a => a.classList.toggle('active', a.dataset.section === e.target.id));
                }
            });
        }, { rootMargin: '-40% 0px -55% 0px' });
        sections.forEach(s => sObs.observe(s));

        // Scroll reveal
        const revEls = document.querySelectorAll('.reveal');
        const rObs = new IntersectionObserver(entries => {
            entries.forEach((e, i) => {
                if (e.isIntersecting) {
                    setTimeout(() => e.target.classList.add('visible'), i * 60);
                    rObs.unobserve(e.target);
                }
            });
        }, { threshold: 0.08 });
        revEls.forEach(el => rObs.observe(el));
    </script>
</body>
</html>
