<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Tentang pahamIT - portal berita IT, panduan belajar, dan toko alat & jasa IT terpercaya. Bukan Sekadar Belajar.">
    <title>Tentang pahamIT - Bukan Sekadar Belajar</title>
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
            --bg:        #f3f6fb;
            --surface:   #ffffff;
            --surface2:  #eef2f9;
            --text:      #0d1526;
            --muted:     #5a6a80;
            --line:      #dde3ef;
            --soft-blue: rgba(11,111,238,.1);
            --soft-red:  rgba(237,28,36,.08);
            --radius:    12px;
            --shadow:    0 2px 12px rgba(7,31,79,.07), 0 1px 3px rgba(7,31,79,.05);
            --shadow-md: 0 8px 32px rgba(7,31,79,.11), 0 2px 8px rgba(7,31,79,.06);
        }
        [data-theme="dark"] {
            --bg: #060a13; --surface: #0d1526; --surface2: #111d33;
            --text: #eef2f8; --muted: #8fa3bc; --line: #1a2740;
            --shadow: 0 2px 12px rgba(0,0,0,.35), 0 1px 3px rgba(0,0,0,.2);
            --shadow-md: 0 8px 32px rgba(0,0,0,.45), 0 2px 8px rgba(0,0,0,.25);
            --soft-blue: rgba(11,111,238,.18); --soft-red: rgba(237,28,36,.12);
        }
        *, *::before, *::after { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body { margin: 0; font-family: "Instrument Sans", ui-sans-serif, system-ui, sans-serif; color: var(--text); background: var(--bg); line-height: 1.7; overflow-x: hidden; transition: background .22s, color .22s; }
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

        /* HERO */
        .page-hero { background: linear-gradient(145deg, #030d20 0%, #071f4f 45%, #0c1540 75%, #0e0830 100%); padding: 64px 0 72px; position: relative; overflow: hidden; color: #fff; }
        .page-hero::before { content: ""; position: absolute; inset: 0; pointer-events: none; background: radial-gradient(ellipse 70% 80% at 10% 60%, rgba(11,111,238,.32), transparent 55%), radial-gradient(ellipse 50% 60% at 90% 20%, rgba(237,28,36,.2), transparent 55%); }
        .page-hero::after { content: ""; position: absolute; inset: 0; pointer-events: none; background-image: linear-gradient(rgba(255,255,255,.025) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.025) 1px, transparent 1px); background-size: 44px 44px; mask-image: linear-gradient(to bottom, rgba(0,0,0,.4) 0%, transparent 75%); }
        .page-hero-inner { width: min(860px, calc(100% - 40px)); margin: 0 auto; position: relative; z-index: 1; text-align: center; }
        .hero-badge { display: inline-flex; align-items: center; gap: 8px; background: rgba(11,111,238,.18); border: 1px solid rgba(11,111,238,.3); color: #93c5fd; font-size: .72rem; font-weight: 800; letter-spacing: .08em; text-transform: uppercase; padding: 5px 14px; border-radius: 999px; margin-bottom: 24px; }
        .hero-logo { height: 52px; width: auto; filter: brightness(0) invert(1); margin: 0 auto 24px; }
        .page-hero h1 { font-size: clamp(2rem, 5vw, 3.2rem); font-weight: 800; line-height: 1.08; letter-spacing: -.04em; margin: 0 0 16px; }
        .page-hero h1 span { color: #ed6b6e; }
        .page-hero .tagline { font-size: 1.1rem; color: #8fa3c0; margin: 0 auto; max-width: 500px; }

        /* CONTENT */
        .content-wrap { width: min(860px, calc(100% - 40px)); margin: 64px auto 80px; }

        /* SECTION */
        .about-section { margin-bottom: 56px; }
        .section-label { font-size: .7rem; font-weight: 900; letter-spacing: .12em; text-transform: uppercase; color: var(--blue); margin-bottom: 10px; display: flex; align-items: center; gap: 8px; }
        .section-label::before { content: ""; width: 18px; height: 2px; border-radius: 2px; background: var(--blue); display: inline-block; }
        .about-section h2 { font-size: clamp(1.4rem, 3vw, 2rem); font-weight: 800; letter-spacing: -.025em; margin: 0 0 16px; }
        .about-section p { color: var(--muted); font-size: .98rem; line-height: 1.82; margin: 0 0 1em; }

        /* MISSION CARDS */
        .mission-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-top: 24px; }
        .mission-card { background: var(--surface); border: 1px solid var(--line); border-radius: var(--radius); padding: 20px; box-shadow: var(--shadow); }
        .mission-icon { width: 40px; height: 40px; border-radius: 10px; display: grid; place-items: center; margin-bottom: 12px; }
        .mission-icon.blue { background: var(--soft-blue); color: var(--blue); }
        .mission-icon.red { background: var(--soft-red); color: var(--red); }
        .mission-icon.navy { background: rgba(7,31,79,.08); color: var(--navy); }
        [data-theme="dark"] .mission-icon.navy { background: rgba(11,111,238,.1); color: #93c5fd; }
        .mission-card h3 { font-size: .95rem; font-weight: 800; margin: 0 0 8px; }
        .mission-card p { font-size: .84rem; color: var(--muted); line-height: 1.65; margin: 0; }

        /* TEAM */
        .team-card { background: var(--surface); border: 1px solid var(--line); border-radius: var(--radius); padding: 28px 32px; display: flex; align-items: flex-start; gap: 28px; box-shadow: var(--shadow-md); }
        .team-avatar { width: 100px; height: 100px; border-radius: 14px; flex-shrink: 0; overflow: hidden; border: 2px solid rgba(11,111,238,.25); box-shadow: 0 8px 24px rgba(7,31,79,.18); }
        .team-avatar img { width: 100%; height: 100%; object-fit: cover; object-position: top center; display: block; }
        .team-info h3 { font-size: 1.2rem; font-weight: 800; margin: 0 0 4px; }
        .team-info .team-role { font-size: .82rem; font-weight: 700; color: var(--blue); margin-bottom: 10px; display: flex; align-items: center; gap: 6px; }
        .team-info p { font-size: .88rem; color: var(--muted); line-height: 1.7; margin: 0 0 14px; }
        .team-social { display: flex; gap: 8px; flex-wrap: wrap; }
        .social-btn { height: 30px; padding: 0 12px; border-radius: 7px; border: 1px solid var(--line); background: var(--surface2); color: var(--muted); font-size: .75rem; font-weight: 700; display: inline-flex; align-items: center; gap: 5px; transition: .15s; }
        .social-btn:hover { background: var(--soft-blue); color: var(--blue); border-color: rgba(11,111,238,.3); }
        .social-btn.cv { background: var(--blue); color: #fff; border-color: var(--blue); }
        .social-btn.cv:hover { background: var(--blue-dark); border-color: var(--blue-dark); }

        /* STATS */
        .stats-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-top: 24px; }
        .stat-card { background: linear-gradient(145deg, var(--navy), #0c1a40); border: 1px solid rgba(11,111,238,.2); border-radius: var(--radius); padding: 24px; text-align: center; color: #fff; }
        .stat-num { width: 48px; height: 48px; margin: 0 auto 10px; border-radius: 12px; display: grid; place-items: center; color: #4a9eff; background: rgba(74,158,255,.12); border: 1px solid rgba(74,158,255,.22); }
        .stat-num.red { color: #ff6b70; background: rgba(237,28,36,.12); border-color: rgba(237,28,36,.24); }
        .stat-num.green { color: #34d399; background: rgba(16,185,129,.12); border-color: rgba(16,185,129,.24); }
        .stat-label { font-size: .78rem; font-weight: 600; color: #5a7a9a; margin-top: 6px; }

        /* CTA */
        .cta-box { background: linear-gradient(145deg, #030d20 0%, #071f4f 60%, #0c1540 100%); border-radius: var(--radius); padding: 40px; text-align: center; color: #fff; position: relative; overflow: hidden; }
        .cta-box::before { content: ""; position: absolute; inset: 0; background: radial-gradient(ellipse 60% 80% at 30% 50%, rgba(11,111,238,.28), transparent 60%), radial-gradient(ellipse 40% 60% at 80% 20%, rgba(237,28,36,.18), transparent 60%); }
        .cta-box-inner { position: relative; z-index: 1; }
        .cta-box h2 { font-size: clamp(1.4rem, 3vw, 1.9rem); font-weight: 800; margin: 0 0 10px; }
        .cta-box p { color: #8fa3c0; margin: 0 0 24px; }
        .cta-btns { display: flex; justify-content: center; gap: 12px; flex-wrap: wrap; }
        .btn-primary { height: 44px; padding: 0 24px; border-radius: 10px; background: var(--blue); color: #fff; font-size: .9rem; font-weight: 800; display: inline-flex; align-items: center; gap: 8px; border: none; cursor: pointer; transition: background .15s, transform .15s; text-decoration: none; }
        .btn-primary:hover { background: var(--blue-dark); transform: translateY(-1px); }
        .btn-soft { height: 44px; padding: 0 24px; border-radius: 10px; background: rgba(255,255,255,.1); color: #fff; font-size: .9rem; font-weight: 800; display: inline-flex; align-items: center; gap: 8px; border: 1px solid rgba(255,255,255,.2); transition: background .15s; text-decoration: none; }
        .btn-soft:hover { background: rgba(255,255,255,.18); }

        /* DIVIDER */
        hr.section-divider { border: none; border-top: 1px solid var(--line); margin: 48px 0; }

        /* FOOTER */
        .footer { background: var(--navy); padding: 0; border-top: 1px solid rgba(255,255,255,.06); }
        .footer-inner { width: min(1180px, calc(100% - 40px)); margin: 0 auto; padding: 20px 0; display: flex; align-items: center; justify-content: space-between; gap: 16px; font-size: .78rem; color: #4d6a83; border-top: 1px solid rgba(255,255,255,.07); }
        .footer-inner a { color: #4d6a83; transition: color .15s; }
        .footer-inner a:hover { color: #9ed0ff; }

        @media (max-width: 720px) {
            .mission-grid { grid-template-columns: 1fr; }
            .stats-row { grid-template-columns: 1fr 1fr; }
            .team-card { flex-direction: column; text-align: center; }
            .team-social { justify-content: center; }
            .nav-links { display: none; }
        }
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
            <a href="{{ route('listing.berita') }}">Berita</a>
            <a href="{{ route('listing.panduan') }}">Panduan</a>
            <a href="{{ route('about') }}" class="active">Tentang</a>
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
        <div class="hero-badge">
            <svg width="11" height="11" viewBox="0 0 24 24" fill="none"><path d="M13 2 3 14h9l-1 8 10-12h-9l1-8Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            Tentang Kami
        </div>
        <img class="hero-logo" src="{{ asset('images/clean/logo_full_clean.png') }}" alt="pahamIT">
        <h1>Portal IT yang <span>Bukan Sekadar</span> Belajar</h1>
        <p class="tagline">Kami hadir untuk menjembatani antara pengetahuan teknis dan praktik nyata di dunia IT Indonesia.</p>
    </div>
</div>

<div class="content-wrap">

    {{-- TENTANG --}}
    <div class="about-section">
        <div class="section-label">Tentang pahamIT</div>
        <h2>Apa itu pahamIT?</h2>
        <p>pahamIT adalah portal teknologi informasi Indonesia yang menyajikan berita IT terkini, panduan belajar step-by-step, dan solusi jasa IT profesional dalam satu platform. Dibuat agar siapapun - dari pelajar hingga profesional - bisa memahami, mempraktikkan, dan mengembangkan kemampuan IT mereka.</p>
        <p>Tidak hanya media baca biasa, pahamIT juga hadir sebagai mitra teknis - menyediakan template konfigurasi, script siap pakai, konsultasi infrastruktur, dan training IT yang terstruktur.</p>

        <div class="mission-grid">
            <div class="mission-card">
                <div class="mission-icon blue">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2V3ZM22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7V3Z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                </div>
                <h3>Edukasi Mendalam</h3>
                <p>Panduan teknis yang runtut, mulai dari konsep dasar hingga konfigurasi tingkat lanjut.</p>
            </div>
            <div class="mission-card">
                <div class="mission-icon red">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M12 3 5 6v5c0 4.5 2.8 7.7 7 9 4.2-1.3 7-4.5 7-9V6l-7-3Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg>
                </div>
                <h3>Praktik Nyata</h3>
                <p>Setiap artikel dan panduan dirancang langsung bisa dipraktikkan - bukan teori semata.</p>
            </div>
            <div class="mission-card">
                <div class="mission-icon navy">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm7 0a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                </div>
                <h3>Komunitas IT</h3>
                <p>Platform yang tumbuh bersama komunitas IT profesional Indonesia.</p>
            </div>
        </div>
    </div>

    <hr class="section-divider">

    {{-- KONTEN --}}
    <div class="about-section">
        <div class="section-label">Yang Kami Sajikan</div>
        <h2>Konten & Layanan</h2>
        <p>pahamIT menyediakan tiga pilar utama yang saling melengkapi:</p>

        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-num" aria-hidden="true">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M4 5h16M4 10h16M4 15h10M4 20h8" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/></svg>
                </div>
                <div style="font-size:1rem;font-weight:800;color:#fff;margin:8px 0 4px;">Berita IT</div>
                <div class="stat-label">Update teknologi, jaringan, keamanan siber, dan tren industri IT terkini.</div>
            </div>
            <div class="stat-card">
                <div class="stat-num red" aria-hidden="true">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20M4 19.5A2.5 2.5 0 0 0 6.5 22H20V4H6.5A2.5 2.5 0 0 0 4 6.5v13Z" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/><path d="M8 8h8M8 12h6" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/></svg>
                </div>
                <div style="font-size:1rem;font-weight:800;color:#fff;margin:8px 0 4px;">Panduan Belajar</div>
                <div class="stat-label">Tutorial networking, Linux, server, scripting, dan cyber security step-by-step.</div>
            </div>
            <div class="stat-card">
                <div class="stat-num green" aria-hidden="true">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M14.7 6.3a4 4 0 0 0-5 5L4 17v3h3l5.7-5.7a4 4 0 0 0 5-5l-2.3 2.3-2.8-2.8 2.1-2.5Z" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
                <div style="font-size:1rem;font-weight:800;color:#fff;margin:8px 0 4px;">Toko & Jasa IT</div>
                <div class="stat-label">Template konfigurasi, script, jasa instalasi, audit, dan konsultasi infrastruktur.</div>
            </div>
        </div>
    </div>

    <hr class="section-divider">

    {{-- CREATOR --}}
    <div class="about-section">
        <div class="section-label">Di Balik pahamIT</div>
        <h2>Kreator & Pengembang</h2>
        <div class="team-card">
            <div class="team-avatar">
                <img src="{{ asset('images/images/eddy adha saputra.JPG') }}" alt="Eddy Adha Saputra">
            </div>
            <div class="team-info">
                <h3>Eddy Adha Saputra</h3>
                <div class="team-role">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Founder & IT Engineer
                </div>
                <p>Network engineer & developer dengan pengalaman di infrastruktur IT, keamanan jaringan, dan pengembangan web. Mendirikan pahamIT dengan visi membuat ilmu IT yang sebelumnya tersebar dan sulit dipahami menjadi mudah diakses dan langsung bisa dipraktikkan oleh siapapun di Indonesia.</p>
                <div class="team-social">
                    <a class="social-btn cv" href="{{ asset('CV_Eddy_Adha_Saputra.pdf') }}" target="_blank" rel="noreferrer" download>
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6Z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M14 2v6h6M12 18v-6M9 15l3 3 3-3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        Download CV
                    </a>
                    <a class="social-btn" href="mailto:info@pahamit.com">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2Z" stroke="currentColor" stroke-width="2"/><path d="m22 6-10 7L2 6" stroke="currentColor" stroke-width="2"/></svg>
                        Email
                    </a>
                    <a class="social-btn" href="https://wa.me/6281250653005" target="_blank" rel="noreferrer">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5Z" stroke="currentColor" stroke-width="2"/></svg>
                        WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- CTA --}}
    <div class="cta-box">
        <div class="cta-box-inner">
            <h2>Ada pertanyaan atau ingin bekerja sama?</h2>
            <p>Dari kebutuhan panduan teknis, pemasangan iklan, hingga kerja sama konten dan jasa IT - kami siap membantu.</p>
            <div class="cta-btns">
                <a class="btn-primary" href="{{ route('listing.berita') }}">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none"><path d="M4 22V12M4 12V7a3 3 0 0 1 3-3h10a3 3 0 0 1 3 3v5M4 12h16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    Baca Berita
                </a>
                <a class="btn-primary" href="{{ route('listing.panduan') }}" style="background:#ed1c24;">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2V3Z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    Lihat Panduan
                </a>
                <a class="btn-soft" href="https://wa.me/6281250653005" target="_blank" rel="noreferrer">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5Z" stroke="currentColor" stroke-width="2"/></svg>
                    Hubungi via WA
                </a>
            </div>
        </div>
    </div>

</div>

<footer class="footer">
    @include('site.partials.footer-affiliation')
    <div class="footer-inner">
        <span>&copy; {{ date('Y') }} <strong style="color:#4d6a83;">pahamIT</strong> - Bukan Sekadar Belajar.</span>
        <div style="display:flex;gap:16px;">
            <a href="{{ route('home') }}">Beranda</a>
            <a href="{{ route('listing.berita') }}">Berita</a>
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
