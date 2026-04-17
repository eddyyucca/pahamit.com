<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Fluxa Media menghadirkan berita IT, tutorial teknis, layanan jaringan, produk digital, dan template IT siap pakai.">
    <title>Fluxa Media | Berita IT, Tutorial, Produk & Jasa Network</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <style>
        :root {
            --ink: #111827;
            --muted: #64748b;
            --line: #dbe4ef;
            --paper: #ffffff;
            --soft: #f6f8fb;
            --deep: #0f172a;
            --blue: #2563eb;
            --cyan: #0891b2;
            --green: #16a34a;
            --amber: #f59e0b;
            --rose: #e11d48;
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            font-family: "Instrument Sans", ui-sans-serif, system-ui, sans-serif;
            color: var(--ink);
            background: var(--soft);
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        img {
            display: block;
            max-width: 100%;
        }

        .page {
            min-height: 100vh;
            overflow-x: hidden;
        }

        .container {
            width: min(1180px, calc(100% - 40px));
            margin: 0 auto;
        }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 20;
            background: rgba(255, 255, 255, 0.92);
            border-bottom: 1px solid rgba(219, 228, 239, 0.9);
            backdrop-filter: blur(18px);
        }

        .nav {
            min-height: 76px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            min-width: 178px;
        }

        .brand img {
            width: 132px;
            height: auto;
        }

        .brand-fallback {
            font-size: 1.15rem;
            font-weight: 800;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 22px;
            color: #475569;
            font-size: 0.94rem;
            font-weight: 600;
        }

        .nav-links a:hover {
            color: var(--blue);
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .icon-button {
            width: 42px;
            height: 42px;
            display: inline-grid;
            place-items: center;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: var(--paper);
            color: #334155;
        }

        .button {
            min-height: 44px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            padding: 0 18px;
            border-radius: 8px;
            border: 1px solid transparent;
            font-weight: 800;
            white-space: nowrap;
        }

        .button-primary {
            background: var(--blue);
            color: #ffffff;
            box-shadow: 0 14px 28px rgba(37, 99, 235, 0.2);
        }

        .button-ghost {
            border-color: var(--line);
            background: #ffffff;
            color: var(--ink);
        }

        .hero {
            position: relative;
            isolation: isolate;
            color: #ffffff;
            background:
                linear-gradient(110deg, rgba(15, 23, 42, 0.94) 0%, rgba(15, 23, 42, 0.84) 48%, rgba(15, 23, 42, 0.48) 100%),
                url("https://images.unsplash.com/photo-1558494949-ef010cbdcc31?auto=format&fit=crop&w=1800&q=80") center / cover;
        }

        .hero::after {
            content: "";
            position: absolute;
            inset: auto 0 0;
            height: 1px;
            background: rgba(255, 255, 255, 0.16);
        }

        .hero-grid {
            min-height: 660px;
            display: grid;
            grid-template-columns: minmax(0, 1.03fr) minmax(320px, 0.72fr);
            gap: 42px;
            align-items: center;
            padding: 62px 0 70px;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin: 0 0 20px;
            color: #bae6fd;
            font-size: 0.82rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .eyebrow::before {
            content: "";
            width: 34px;
            height: 2px;
            background: var(--cyan);
        }

        h1 {
            margin: 0;
            max-width: 790px;
            font-size: clamp(2.55rem, 6vw, 5.25rem);
            line-height: 0.98;
            letter-spacing: 0;
        }

        .hero-copy {
            max-width: 660px;
            margin: 24px 0 0;
            color: #d8e5f3;
            font-size: 1.08rem;
            line-height: 1.8;
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 32px;
        }

        .hero-actions .button-ghost {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 255, 255, 0.2);
            color: #ffffff;
        }

        .hero-panel {
            align-self: end;
            padding: 22px;
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 8px;
            background: rgba(15, 23, 42, 0.72);
            box-shadow: 0 24px 80px rgba(2, 6, 23, 0.34);
        }

        .ticker {
            display: grid;
            gap: 14px;
        }

        .ticker-item {
            display: grid;
            grid-template-columns: 72px 1fr;
            gap: 14px;
            padding-bottom: 14px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.12);
        }

        .ticker-item:last-child {
            padding-bottom: 0;
            border-bottom: 0;
        }

        .ticker-time {
            color: #67e8f9;
            font-size: 0.78rem;
            font-weight: 800;
        }

        .ticker-title {
            margin: 0;
            color: #f8fafc;
            font-weight: 800;
            line-height: 1.35;
        }

        .ticker-meta {
            display: block;
            margin-top: 7px;
            color: #b6c6d8;
            font-size: 0.84rem;
        }

        .section {
            padding: 78px 0;
        }

        .section-light {
            background: #ffffff;
        }

        .section-deep {
            background: var(--deep);
            color: #ffffff;
        }

        .section-head {
            display: flex;
            align-items: end;
            justify-content: space-between;
            gap: 24px;
            margin-bottom: 28px;
        }

        .section-title {
            margin: 0;
            font-size: clamp(1.75rem, 3vw, 2.65rem);
            line-height: 1.08;
            letter-spacing: 0;
        }

        .section-copy {
            max-width: 590px;
            margin: 12px 0 0;
            color: var(--muted);
            line-height: 1.7;
        }

        .section-deep .section-copy {
            color: #b6c6d8;
        }

        .link-more {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--blue);
            font-weight: 800;
        }

        .grid {
            display: grid;
            gap: 20px;
        }

        .news-grid {
            grid-template-columns: 1.28fr repeat(2, minmax(0, 0.86fr));
        }

        .card {
            border: 1px solid var(--line);
            border-radius: 8px;
            background: var(--paper);
            overflow: hidden;
            box-shadow: 0 18px 48px rgba(15, 23, 42, 0.06);
        }

        .article-card {
            min-height: 100%;
            display: flex;
            flex-direction: column;
        }

        .article-media {
            min-height: 190px;
            display: grid;
            place-items: end start;
            padding: 20px;
            color: #ffffff;
            background-size: cover;
            background-position: center;
        }

        .article-media.large {
            min-height: 330px;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            min-height: 28px;
            padding: 0 10px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.92);
            color: #0f172a;
            font-size: 0.78rem;
            font-weight: 800;
        }

        .article-body {
            display: flex;
            flex: 1;
            flex-direction: column;
            padding: 20px;
        }

        .meta {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 12px;
            color: var(--muted);
            font-size: 0.83rem;
            font-weight: 600;
        }

        .article-body h3 {
            margin: 0;
            font-size: 1.25rem;
            line-height: 1.22;
            letter-spacing: 0;
        }

        .article-card.featured h3 {
            font-size: clamp(1.65rem, 3vw, 2.25rem);
        }

        .article-body p {
            margin: 12px 0 0;
            color: var(--muted);
            line-height: 1.62;
        }

        .article-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-top: auto;
            padding-top: 18px;
            color: var(--blue);
            font-weight: 800;
        }

        .category-strip {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            margin-top: 22px;
        }

        .category {
            display: flex;
            align-items: center;
            gap: 12px;
            min-height: 86px;
            padding: 18px;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: #ffffff;
        }

        .category svg {
            flex: 0 0 auto;
            color: var(--blue);
        }

        .category strong {
            display: block;
            margin-bottom: 3px;
        }

        .category span {
            color: var(--muted);
            font-size: 0.88rem;
        }

        .product-grid {
            grid-template-columns: repeat(3, 1fr);
        }

        .product-card {
            padding: 22px;
        }

        .product-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 14px;
            margin-bottom: 22px;
        }

        .product-icon {
            width: 50px;
            height: 50px;
            display: grid;
            place-items: center;
            border-radius: 8px;
            color: #ffffff;
            background: var(--blue);
        }

        .product-card:nth-child(2) .product-icon {
            background: var(--green);
        }

        .product-card:nth-child(3) .product-icon {
            background: var(--amber);
        }

        .price {
            color: var(--ink);
            font-weight: 900;
        }

        .product-card h3 {
            margin: 0 0 10px;
            font-size: 1.3rem;
        }

        .product-card p {
            margin: 0;
            color: var(--muted);
            line-height: 1.62;
        }

        .chips {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 20px;
        }

        .chip {
            display: inline-flex;
            align-items: center;
            min-height: 30px;
            padding: 0 10px;
            border: 1px solid var(--line);
            border-radius: 999px;
            color: #475569;
            font-size: 0.82rem;
            font-weight: 700;
        }

        .service-grid {
            grid-template-columns: 0.92fr 1.08fr;
            align-items: stretch;
        }

        .service-aside {
            padding: 28px;
            border-radius: 8px;
            background:
                linear-gradient(145deg, rgba(8, 145, 178, 0.92), rgba(37, 99, 235, 0.9)),
                url("https://images.unsplash.com/photo-1600267165477-6d4cc741b379?auto=format&fit=crop&w=1000&q=80") center / cover;
            color: #ffffff;
        }

        .service-aside h3 {
            margin: 0;
            font-size: 2rem;
            line-height: 1.05;
        }

        .service-aside p {
            margin: 16px 0 0;
            color: #e0f2fe;
            line-height: 1.7;
        }

        .service-list {
            display: grid;
            gap: 14px;
        }

        .service-item {
            display: grid;
            grid-template-columns: 48px 1fr;
            gap: 16px;
            padding: 20px;
            border: 1px solid rgba(255, 255, 255, 0.13);
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.06);
        }

        .service-item svg {
            color: #67e8f9;
        }

        .service-item h3 {
            margin: 0 0 7px;
            font-size: 1.12rem;
        }

        .service-item p {
            margin: 0;
            color: #b6c6d8;
            line-height: 1.62;
        }

        .template-grid {
            grid-template-columns: repeat(4, 1fr);
        }

        .template-card {
            padding: 18px;
        }

        .template-preview {
            min-height: 144px;
            border-radius: 8px;
            background:
                linear-gradient(135deg, rgba(37, 99, 235, 0.86), rgba(8, 145, 178, 0.86)),
                repeating-linear-gradient(90deg, rgba(255, 255, 255, 0.24) 0 1px, transparent 1px 28px),
                repeating-linear-gradient(0deg, rgba(255, 255, 255, 0.2) 0 1px, transparent 1px 28px);
        }

        .template-card:nth-child(2) .template-preview {
            background:
                linear-gradient(135deg, rgba(22, 163, 74, 0.9), rgba(8, 145, 178, 0.84)),
                repeating-linear-gradient(45deg, rgba(255, 255, 255, 0.22) 0 2px, transparent 2px 18px);
        }

        .template-card:nth-child(3) .template-preview {
            background:
                linear-gradient(135deg, rgba(225, 29, 72, 0.88), rgba(245, 158, 11, 0.86)),
                radial-gradient(circle at 30% 30%, rgba(255, 255, 255, 0.22), transparent 34%);
        }

        .template-card:nth-child(4) .template-preview {
            background:
                linear-gradient(135deg, rgba(15, 23, 42, 0.92), rgba(37, 99, 235, 0.86)),
                repeating-linear-gradient(0deg, rgba(255, 255, 255, 0.18) 0 2px, transparent 2px 20px);
        }

        .template-card h3 {
            margin: 16px 0 8px;
            font-size: 1.05rem;
        }

        .template-card p {
            margin: 0;
            color: var(--muted);
            line-height: 1.55;
            font-size: 0.92rem;
        }

        .cta {
            padding: 34px;
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 26px;
            align-items: center;
            border-radius: 8px;
            background:
                linear-gradient(135deg, rgba(15, 23, 42, 0.96), rgba(37, 99, 235, 0.88)),
                url("https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=1400&q=80") center / cover;
            color: #ffffff;
        }

        .cta h2 {
            margin: 0;
            font-size: clamp(1.65rem, 3vw, 2.45rem);
            line-height: 1.1;
        }

        .cta p {
            max-width: 690px;
            margin: 12px 0 0;
            color: #d8e5f3;
            line-height: 1.7;
        }

        .footer {
            padding: 36px 0;
            background: #ffffff;
            border-top: 1px solid var(--line);
        }

        .footer-inner {
            display: flex;
            justify-content: space-between;
            gap: 24px;
            color: var(--muted);
            font-size: 0.93rem;
        }

        .footer strong {
            color: var(--ink);
        }

        @media (max-width: 1024px) {
            .nav-links {
                display: none;
            }

            .hero-grid,
            .service-grid,
            .cta {
                grid-template-columns: 1fr;
            }

            .news-grid,
            .product-grid,
            .template-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .category-strip {
                grid-template-columns: repeat(2, 1fr);
            }

            .hero-panel {
                align-self: auto;
            }
        }

        @media (max-width: 700px) {
            .container {
                width: min(100% - 28px, 1180px);
            }

            .nav {
                min-height: 68px;
            }

            .brand img {
                width: 112px;
            }

            .nav-actions .button {
                display: none;
            }

            .hero-grid {
                min-height: auto;
                padding: 48px 0 54px;
            }

            .hero-copy {
                font-size: 1rem;
            }

            .section {
                padding: 54px 0;
            }

            .section-head,
            .footer-inner {
                display: block;
            }

            .section-head .link-more {
                margin-top: 16px;
            }

            .news-grid,
            .product-grid,
            .service-grid,
            .template-grid,
            .category-strip {
                grid-template-columns: 1fr;
            }

            .ticker-item {
                grid-template-columns: 58px 1fr;
            }

            .article-media.large {
                min-height: 240px;
            }

            .cta {
                padding: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="page">
        <header class="topbar">
            <div class="container nav">
                <a class="brand" href="#home" aria-label="Fluxa Media">
                    <img src="{{ asset('images/clean/logo_full_clean.png') }}" alt="Fluxa Media" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                    <span class="brand-fallback" style="display: none;">Fluxa Media</span>
                </a>

                <nav class="nav-links" aria-label="Navigasi utama">
                    <a href="#berita">Berita IT</a>
                    <a href="#tutorial">Tutorial</a>
                    <a href="#produk">Produk</a>
                    <a href="#jasa">Jasa</a>
                    <a href="#template">Template</a>
                </nav>

                <div class="nav-actions">
                    <a class="icon-button" href="#berita" title="Cari artikel" aria-label="Cari artikel">
                        <svg width="19" height="19" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="m21 21-4.35-4.35m2.35-5.15a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </a>
                    <a class="button button-primary" href="#kontak">
                        Konsultasi
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M5 12h14m-6-6 6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                </div>
            </div>
        </header>

        <main id="home">
            <section class="hero">
                <div class="container hero-grid">
                    <div>
                        <p class="eyebrow">Portal IT + Marketplace Digital</p>
                        <h1>Berita IT, tutorial teknis, produk, jasa, dan template network dalam satu tempat.</h1>
                        <p class="hero-copy">
                            Fluxa Media dirancang sebagai rumah konten teknologi yang juga bisa menjadi etalase penjualan perangkat, layanan instalasi, konfigurasi jaringan, serta template siap pakai untuk kebutuhan IT profesional.
                        </p>
                        <div class="hero-actions">
                            <a class="button button-primary" href="#berita">Baca Artikel</a>
                            <a class="button button-ghost" href="#produk">Lihat Produk</a>
                        </div>
                    </div>

                    <aside class="hero-panel" aria-label="Update cepat">
                        <div class="ticker">
                            <article class="ticker-item">
                                <span class="ticker-time">08:30</span>
                                <div>
                                    <p class="ticker-title">Checklist keamanan router kantor kecil setelah migrasi ISP.</p>
                                    <span class="ticker-meta">Network Security</span>
                                </div>
                            </article>
                            <article class="ticker-item">
                                <span class="ticker-time">10:15</span>
                                <div>
                                    <p class="ticker-title">Template monitoring bandwidth untuk tim operasional NOC.</p>
                                    <span class="ticker-meta">Template Network</span>
                                </div>
                            </article>
                            <article class="ticker-item">
                                <span class="ticker-time">13:00</span>
                                <div>
                                    <p class="ticker-title">Paket jasa audit WiFi dan segmentasi VLAN untuk UMKM.</p>
                                    <span class="ticker-meta">Jasa IT</span>
                                </div>
                            </article>
                        </div>
                    </aside>
                </div>
            </section>

            <section class="section section-light" id="berita">
                <div class="container">
                    <div class="section-head">
                        <div>
                            <h2 class="section-title">Berita dan insight IT terbaru</h2>
                            <p class="section-copy">Tampilan awal untuk menampilkan headline, artikel unggulan, update keamanan, tren cloud, jaringan, dan tools yang relevan untuk pembaca teknis.</p>
                        </div>
                        <a class="link-more" href="#tutorial">
                            Lihat tutorial
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M5 12h14m-6-6 6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    </div>

                    <div class="grid news-grid">
                        <article class="card article-card featured">
                            <div class="article-media large" style="background-image: linear-gradient(rgba(15, 23, 42, 0.2), rgba(15, 23, 42, 0.55)), url('https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=1100&q=80');">
                                <span class="badge">Headline</span>
                            </div>
                            <div class="article-body">
                                <div class="meta"><span>Cybersecurity</span><span>6 menit baca</span></div>
                                <h3>Strategi hardening perangkat jaringan sebelum bisnis membuka akses remote.</h3>
                                <p>Artikel utama dapat berisi analisa teknis yang mengarahkan pembaca ke layanan audit, konfigurasi firewall, dan paket maintenance.</p>
                                <div class="article-footer"><span>Baca selengkapnya</span><span>01</span></div>
                            </div>
                        </article>

                        <article class="card article-card">
                            <div class="article-media" style="background-image: linear-gradient(rgba(15, 23, 42, 0.1), rgba(15, 23, 42, 0.45)), url('https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=900&q=80');">
                                <span class="badge">Cloud</span>
                            </div>
                            <div class="article-body">
                                <div class="meta"><span>Cloud Ops</span><span>4 menit</span></div>
                                <h3>Monitoring server hemat biaya untuk website dan aplikasi internal.</h3>
                                <p>Pola konten singkat untuk membangun trust sebelum menawarkan setup monitoring.</p>
                                <div class="article-footer"><span>Baca</span><span>02</span></div>
                            </div>
                        </article>

                        <article class="card article-card">
                            <div class="article-media" style="background-image: linear-gradient(rgba(15, 23, 42, 0.1), rgba(15, 23, 42, 0.45)), url('https://images.unsplash.com/photo-1550751827-4bd374c3f58b?auto=format&fit=crop&w=900&q=80');">
                                <span class="badge">Network</span>
                            </div>
                            <div class="article-body">
                                <div class="meta"><span>Jaringan</span><span>5 menit</span></div>
                                <h3>Perbandingan topologi sederhana untuk kantor, sekolah, dan gudang.</h3>
                                <p>Cocok untuk konten edukasi sekaligus jembatan ke template desain jaringan.</p>
                                <div class="article-footer"><span>Baca</span><span>03</span></div>
                            </div>
                        </article>
                    </div>

                    <div class="category-strip" id="tutorial">
                        <a class="category" href="#tutorial">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M4 5h16M4 12h16M4 19h10" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                            <span><strong>Tutorial</strong>Step-by-step konfigurasi</span>
                        </a>
                        <a class="category" href="#jasa">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 3v18M4 8h16M7 16h10" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                            <span><strong>Network</strong>Router, VLAN, WiFi, VPN</span>
                        </a>
                        <a class="category" href="#produk">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M6 7h12l1 13H5L6 7Zm3 0a3 3 0 0 1 6 0" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg>
                            <span><strong>Produk</strong>Barang dan software IT</span>
                        </a>
                        <a class="category" href="#template">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M5 4h14v16H5V4Zm4 4h6M9 12h6M9 16h3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                            <span><strong>Template</strong>Dokumen siap pakai</span>
                        </a>
                    </div>
                </div>
            </section>

            <section class="section" id="produk">
                <div class="container">
                    <div class="section-head">
                        <div>
                            <h2 class="section-title">Etalase produk digital dan perangkat IT</h2>
                            <p class="section-copy">Area ini disiapkan untuk menjual barang, lisensi, file digital, paket konfigurasi, atau produk siap unduh.</p>
                        </div>
                        <a class="link-more" href="#kontak">Minta penawaran</a>
                    </div>

                    <div class="grid product-grid">
                        <article class="card product-card">
                            <div class="product-top">
                                <div class="product-icon">
                                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M4 7h16v10H4V7Zm3 13h10M9 17v3m6-3v3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                                </div>
                                <span class="price">Mulai 250K</span>
                            </div>
                            <h3>Perangkat & Aksesori IT</h3>
                            <p>Router, access point, kabel, switch, mini server, dan perangkat pendukung instalasi jaringan.</p>
                            <div class="chips"><span class="chip">Router</span><span class="chip">Switch</span><span class="chip">WiFi</span></div>
                        </article>

                        <article class="card product-card">
                            <div class="product-top">
                                <div class="product-icon">
                                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M5 5h14v14H5V5Zm4 4h6M9 13h6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                                </div>
                                <span class="price">Mulai 99K</span>
                            </div>
                            <h3>Template Network</h3>
                            <p>Dokumen desain jaringan, IP planning, SOP troubleshooting, checklist audit, dan laporan teknis.</p>
                            <div class="chips"><span class="chip">Excel</span><span class="chip">PDF</span><span class="chip">Diagram</span></div>
                        </article>

                        <article class="card product-card">
                            <div class="product-top">
                                <div class="product-icon">
                                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 3 4 7v6c0 4 3 7 8 8 5-1 8-4 8-8V7l-8-4Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg>
                                </div>
                                <span class="price">Custom</span>
                            </div>
                            <h3>Paket Konfigurasi</h3>
                            <p>File konfigurasi awal, rule firewall, VLAN, VPN, monitoring, dan dokumentasi deployment.</p>
                            <div class="chips"><span class="chip">MikroTik</span><span class="chip">VPN</span><span class="chip">Firewall</span></div>
                        </article>
                    </div>
                </div>
            </section>

            <section class="section section-deep" id="jasa">
                <div class="container">
                    <div class="section-head">
                        <div>
                            <h2 class="section-title">Jasa IT untuk bisnis yang butuh jaringan stabil</h2>
                            <p class="section-copy">Blok ini bisa menjadi halaman layanan, lengkap dengan paket konsultasi, instalasi, audit, dan maintenance.</p>
                        </div>
                    </div>

                    <div class="grid service-grid">
                        <aside class="service-aside">
                            <h3>Konsultasi, instalasi, dan optimasi infrastruktur.</h3>
                            <p>Dari survey lokasi sampai dokumentasi akhir, tampilan ini disiapkan agar calon klien cepat paham apa yang bisa dibantu.</p>
                        </aside>
                        <div class="service-list">
                            <article class="service-item">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M4 7h16M7 12h10M9 17h6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                                <div><h3>Instalasi jaringan kantor</h3><p>Penarikan kabel, rack, switch, access point, subnetting, VLAN, dan dokumentasi topologi.</p></div>
                            </article>
                            <article class="service-item">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 3 5 6v5c0 4.5 2.8 7.7 7 9 4.2-1.3 7-4.5 7-9V6l-7-3Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg>
                                <div><h3>Audit keamanan network</h3><p>Review firewall, akses remote, segmentasi jaringan, password policy, dan rekomendasi hardening.</p></div>
                            </article>
                            <article class="service-item">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M5 18h14M7 14l3-3 3 2 4-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                <div><h3>Monitoring dan maintenance</h3><p>Setup dashboard monitoring, alert downtime, laporan berkala, dan perawatan perangkat jaringan.</p></div>
                            </article>
                        </div>
                    </div>
                </div>
            </section>

            <section class="section section-light" id="template">
                <div class="container">
                    <div class="section-head">
                        <div>
                            <h2 class="section-title">Template siap pakai untuk kerja network dan IT</h2>
                            <p class="section-copy">Katalog awal untuk file yang bisa dijual sebagai produk digital, dari spreadsheet sampai dokumen SOP.</p>
                        </div>
                    </div>

                    <div class="grid template-grid">
                        <article class="card template-card">
                            <div class="template-preview" aria-hidden="true"></div>
                            <h3>IP Address Planner</h3>
                            <p>Template subnetting, alokasi IP, gateway, VLAN ID, dan catatan perangkat.</p>
                        </article>
                        <article class="card template-card">
                            <div class="template-preview" aria-hidden="true"></div>
                            <h3>Network Audit Report</h3>
                            <p>Format laporan audit untuk kondisi perangkat, risiko, dan rekomendasi.</p>
                        </article>
                        <article class="card template-card">
                            <div class="template-preview" aria-hidden="true"></div>
                            <h3>SOP Troubleshooting</h3>
                            <p>Alur pengecekan internet, WiFi, LAN, printer, dan layanan internal.</p>
                        </article>
                        <article class="card template-card">
                            <div class="template-preview" aria-hidden="true"></div>
                            <h3>Maintenance Checklist</h3>
                            <p>Checklist bulanan untuk router, switch, access point, server, dan backup.</p>
                        </article>
                    </div>
                </div>
            </section>

            <section class="section" id="kontak">
                <div class="container">
                    <div class="cta">
                        <div>
                            <h2>Siap dijadikan portal artikel sekaligus toko jasa IT.</h2>
                            <p>Berikutnya tinggal disambungkan ke dashboard admin, database artikel, katalog produk, form order, dan WhatsApp untuk konversi cepat.</p>
                        </div>
                        <a class="button button-primary" href="https://wa.me/" target="_blank" rel="noreferrer">Hubungi via WhatsApp</a>
                    </div>
                </div>
            </section>
        </main>

        <footer class="footer">
            <div class="container footer-inner">
                <div><strong>Fluxa Media</strong> - berita IT, tutorial, produk, jasa, dan template network.</div>
                <div>© {{ date('Y') }} Fluxa. Semua hak dilindungi.</div>
            </div>
        </footer>
    </div>
</body>
</html>
