<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="pahamIT - Portal berita IT, panduan belajar, dan toko alat & jasa IT terpercaya. Bukan Sekadar Belajar.">
    <title>pahamIT | Bukan Sekadar Belajar.</title>
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
            --amber:     #f59e0b;
            --bg:        #f3f6fb;
            --surface:   #ffffff;
            --surface2:  #eef2f9;
            --text:      #0d1526;
            --muted:     #5a6a80;
            --line:      #dde3ef;
            --shadow:    0 2px 12px rgba(7,31,79,.07), 0 1px 3px rgba(7,31,79,.05);
            --shadow-md: 0 8px 32px rgba(7,31,79,.11), 0 2px 8px rgba(7,31,79,.06);
            --shadow-lg: 0 20px 60px rgba(7,31,79,.14), 0 4px 16px rgba(7,31,79,.07);
            --soft-blue: rgba(11,111,238,.1);
            --soft-red:  rgba(237,28,36,.1);
            --radius:    12px;
            --radius-sm: 8px;
        }
        [data-theme="dark"] {
            --bg:        #060a13;
            --surface:   #0d1526;
            --surface2:  #111d33;
            --text:      #eef2f8;
            --muted:     #8fa3bc;
            --line:      #1a2740;
            --shadow:    0 2px 12px rgba(0,0,0,.35), 0 1px 3px rgba(0,0,0,.2);
            --shadow-md: 0 8px 32px rgba(0,0,0,.45), 0 2px 8px rgba(0,0,0,.25);
            --shadow-lg: 0 20px 60px rgba(0,0,0,.55), 0 4px 16px rgba(0,0,0,.3);
            --soft-blue: rgba(11,111,238,.18);
            --soft-red:  rgba(237,28,36,.16);
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

        .wrap { width: min(1180px, calc(100% - 40px)); margin: 0 auto; }

        /* â”€â”€ Nav â”€â”€ */
        .topbar {
            position: sticky; top: 0; z-index: 50;
            background: rgba(255,255,255,.92);
            border-bottom: 1px solid var(--line);
            backdrop-filter: blur(24px);
            transition: background .22s, border-color .22s;
        }
        [data-theme="dark"] .topbar { background: rgba(6,10,19,.93); }
        .nav-inner {
            width: min(1180px, calc(100% - 40px)); margin: 0 auto;
            display: flex; align-items: center;
            justify-content: space-between; gap: 16px;
            min-height: 68px;
        }
        .brand { display: flex; align-items: center; flex-shrink: 0; }
        .brand-logo-img { height: 36px; width: auto; transition: filter .22s; }
        [data-theme="dark"] .brand-logo-img { filter: brightness(0) invert(1); }

        .nav-links { display: flex; align-items: center; gap: 2px; }
        .nav-links a {
            padding: 8px 14px; border-radius: var(--radius-sm);
            color: var(--muted); font-size: .88rem; font-weight: 700;
            transition: color .15s, background .15s; position: relative;
        }
        .nav-links a:hover { color: var(--blue); background: var(--soft-blue); }
        .nav-links a.active { color: var(--blue); }
        .nav-links a.active::after {
            content: ""; position: absolute; bottom: 3px; left: 14px; right: 14px;
            height: 2px; border-radius: 2px; background: var(--blue);
        }

        .nav-right { display: flex; align-items: center; gap: 8px; }
        .theme-btn {
            width: 38px; height: 38px; border-radius: var(--radius-sm);
            border: 1px solid var(--line); background: var(--surface);
            color: var(--muted); display: grid; place-items: center; transition: .15s;
        }
        .theme-btn:hover { background: var(--soft-blue); color: var(--blue); border-color: rgba(11,111,238,.3); }
        [data-theme="dark"] .sun { display: none; }
        [data-theme="light"] .moon { display: none; }

        .menu-btn {
            display: none; width: 38px; height: 38px; border-radius: var(--radius-sm);
            border: 1px solid var(--line); background: var(--surface);
            color: var(--text); place-items: center; transition: .15s;
        }
        .menu-btn:hover { background: var(--soft-blue); }

        .mobile-menu { display: none; padding: 0 0 14px; }
        .mobile-menu.open { display: grid; gap: 6px; }
        .mobile-menu a {
            padding: 12px 14px; border: 1px solid var(--line);
            border-radius: var(--radius-sm); background: var(--surface);
            color: var(--muted); font-weight: 700; transition: .15s;
        }
        .mobile-menu a:hover { color: var(--blue); background: var(--soft-blue); }

        /* â”€â”€ Hero â”€â”€ */
        .hero {
            position: relative; overflow: hidden; color: #fff;
            background: linear-gradient(145deg, #030d20 0%, #071f4f 45%, #0c1540 75%, #0e0830 100%);
        }
        .hero::before {
            content: ""; position: absolute; inset: 0; pointer-events: none;
            background:
                radial-gradient(ellipse 90% 80% at 10% 65%, rgba(11,111,238,.32), transparent 55%),
                radial-gradient(ellipse 65% 55% at 88% 12%, rgba(237,28,36,.2), transparent 55%),
                radial-gradient(ellipse 45% 45% at 55% 95%, rgba(8,145,178,.15), transparent 50%);
        }
        .hero::after {
            content: ""; position: absolute; inset: 0; pointer-events: none;
            background-image:
                linear-gradient(rgba(255,255,255,.035) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.035) 1px, transparent 1px);
            background-size: 44px 44px;
            mask-image: linear-gradient(to bottom, rgba(0,0,0,.6) 0%, transparent 75%);
        }
        .hero-inner {
            position: relative; z-index: 1;
            width: min(1180px, calc(100% - 40px)); margin: 0 auto;
            display: flex; align-items: center; gap: 56px;
            padding: 88px 0 80px;
        }
        .hero-text { flex: 1; min-width: 0; }
        .eyebrow {
            display: inline-flex; align-items: center; gap: 9px;
            margin: 0 0 28px; padding: 6px 16px;
            border: 1px solid rgba(255,255,255,.16); border-radius: 999px;
            background: rgba(255,255,255,.07); backdrop-filter: blur(8px);
            color: #c3d8f7; font-size: .74rem; font-weight: 800;
            text-transform: uppercase; letter-spacing: .1em;
        }
        .eyebrow-dot {
            width: 7px; height: 7px; border-radius: 50%;
            background: #22c55e; box-shadow: 0 0 0 4px rgba(34,197,94,.22);
            animation: pulse 2.2s infinite;
        }
        @keyframes pulse {
            0%,100% { box-shadow: 0 0 0 4px rgba(34,197,94,.22); }
            50%      { box-shadow: 0 0 0 8px rgba(34,197,94,.08); }
        }
        .hero h1 {
            margin: 0; font-size: clamp(2.2rem, 5.8vw, 4.2rem);
            line-height: 1.03; letter-spacing: -.03em; font-weight: 800;
        }
        .hero strong {
            background: linear-gradient(90deg, #60a5fa, #38bdf8);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .hero-copy {
            max-width: 520px; margin: 24px 0 0;
            color: #b0c8e6; font-size: 1.05rem; line-height: 1.8;
        }
        .hero-actions {
            display: flex; flex-wrap: wrap;
            gap: 12px; margin-top: 36px;
        }
        .btn {
            min-height: 48px; display: inline-flex; align-items: center;
            justify-content: center; gap: 8px; padding: 0 24px;
            border: 1px solid transparent; border-radius: var(--radius);
            font-size: .95rem; font-weight: 800; white-space: nowrap;
            transition: transform .15s, box-shadow .15s, background .15s, border-color .15s;
        }
        .btn:hover { transform: translateY(-2px); }
        .btn-primary {
            color: #fff; background: var(--blue);
            box-shadow: 0 6px 20px rgba(11,111,238,.35);
        }
        .btn-primary:hover { background: var(--blue-dark); box-shadow: 0 10px 30px rgba(11,111,238,.45); }
        .btn-soft {
            color: #fff; border-color: rgba(255,255,255,.22);
            background: rgba(255,255,255,.1); backdrop-filter: blur(4px);
        }
        .btn-soft:hover { background: rgba(255,255,255,.18); border-color: rgba(255,255,255,.32); }
        .btn-outline {
            color: var(--text); border-color: var(--line); background: var(--surface);
        }
        .btn-outline:hover { background: var(--surface2); border-color: rgba(11,111,238,.3); color: var(--blue); }

        /* hero visual canvas */
        .hero-visual {
            flex-shrink: 0;
            width: 460px; height: 380px;
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            background: linear-gradient(135deg, rgba(11,111,238,.12) 0%, rgba(7,31,79,.35) 50%, rgba(237,28,36,.08) 100%);
            border: 1px solid rgba(255,255,255,.1);
            box-shadow: 0 24px 64px rgba(0,0,0,.5), 0 0 0 1px rgba(255,255,255,.07);
        }
        .hero-visual canvas { width: 100%; height: 100%; display: block; }
        .hero-visual-badge {
            position: absolute; bottom: 22px; left: 50%; transform: translateX(-50%);
            display: flex; align-items: center; gap: 10px;
            background: rgba(7,31,79,.75); backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,.12); border-radius: 40px;
            padding: 10px 20px; white-space: nowrap;
        }
        .hero-visual-badge span { color: #c3d8f7; font-size: .76rem; font-weight: 700; letter-spacing: .04em; }
        .badge-dot { width: 7px; height: 7px; border-radius: 50%; background: #22c55e; box-shadow: 0 0 0 4px rgba(34,197,94,.22); animation: pulse 2.2s infinite; flex-shrink: 0; }

        /* â”€â”€ Focus cards â”€â”€ */
        .focus-wrap { padding: 0; }
        .focus-grid {
            display: grid; grid-template-columns: repeat(3, 1fr);
            gap: 18px; margin-top: -36px; position: relative; z-index: 5;
        }
        .focus-card {
            padding: 28px 24px 24px;
            border: 1px solid var(--line); border-radius: var(--radius);
            background: var(--surface); box-shadow: var(--shadow-md);
            transition: transform .2s, box-shadow .2s, border-color .2s;
            position: relative; overflow: hidden;
        }
        .focus-card::before {
            content: ""; position: absolute; top: 0; left: 0; right: 0; height: 3px;
            background: linear-gradient(90deg, var(--blue), #38bdf8);
            opacity: 0; transition: opacity .2s;
        }
        .focus-card:nth-child(2)::before { background: linear-gradient(90deg, var(--red), #f97316); }
        .focus-card:nth-child(3)::before { background: linear-gradient(90deg, var(--green), #06b6d4); }
        .focus-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-lg); border-color: transparent; }
        .focus-card:hover::before { opacity: 1; }
        .focus-icon {
            width: 50px; height: 50px; border-radius: 12px;
            display: grid; place-items: center; margin-bottom: 18px;
            background: var(--soft-blue); color: var(--blue);
        }
        .focus-card:nth-child(2) .focus-icon { background: var(--soft-red); color: var(--red); }
        .focus-card:nth-child(3) .focus-icon { background: rgba(22,163,74,.1); color: var(--green); }
        .focus-card h2 { margin: 0 0 9px; font-size: 1.08rem; font-weight: 800; }
        .focus-card p { margin: 0; color: var(--muted); font-size: .88rem; line-height: 1.65; }
        .focus-link {
            display: inline-flex; align-items: center; gap: 6px;
            margin-top: 16px; font-size: .82rem; font-weight: 800; color: var(--blue);
            transition: gap .15s;
        }
        .focus-link:hover { gap: 9px; }
        .focus-card:nth-child(2) .focus-link { color: var(--red); }
        .focus-card:nth-child(3) .focus-link { color: var(--green); }

        /* â”€â”€ Sections â”€â”€ */
        .section { padding: 80px 0; }
        .section-alt { background: var(--surface); }

        .section-head {
            display: flex; align-items: flex-end;
            justify-content: space-between; gap: 24px; margin-bottom: 36px;
        }
        .label {
            margin: 0 0 9px; font-size: .72rem; font-weight: 900;
            text-transform: uppercase; letter-spacing: .12em;
            display: inline-flex; align-items: center; gap: 7px;
        }
        .label::before {
            content: ""; width: 18px; height: 3px; border-radius: 2px;
            background: currentColor; display: inline-block;
        }
        .label-blue { color: var(--blue); }
        .label-red  { color: var(--red); }
        .label-green{ color: var(--green); }
        .section-title {
            max-width: 700px; margin: 0;
            font-size: clamp(1.65rem, 3.2vw, 2.5rem);
            line-height: 1.08; letter-spacing: -.022em; font-weight: 800;
        }
        .section-copy {
            max-width: 560px; margin: 12px 0 0;
            color: var(--muted); line-height: 1.75; font-size: .93rem;
        }
        .link-more {
            display: inline-flex; align-items: center; gap: 7px;
            color: var(--blue); font-weight: 900; font-size: .88rem;
            white-space: nowrap; flex-shrink: 0; transition: gap .15s;
            padding: 9px 16px; border-radius: var(--radius-sm);
            border: 1px solid rgba(11,111,238,.2); background: var(--soft-blue);
        }
        .link-more:hover { gap: 10px; background: rgba(11,111,238,.15); }

        /* â”€â”€ News grid â”€â”€ */
        .news-grid { display: grid; grid-template-columns: 1.25fr .9fr .9fr; gap: 20px; }
        .news-card {
            border: 1px solid var(--line); border-radius: var(--radius);
            background: var(--surface); overflow: hidden;
            box-shadow: var(--shadow);
            transition: transform .22s, box-shadow .22s, border-color .22s;
            display: block;
        }
        .news-card:hover { transform: translateY(-5px); box-shadow: var(--shadow-lg); border-color: transparent; }
        .news-visual {
            min-height: 190px; padding: 18px;
            display: flex; flex-direction: column; justify-content: flex-end;
            background:
                linear-gradient(175deg, rgba(7,31,79,.78) 0%, rgba(11,111,238,.45) 100%),
                var(--surface2);
            background-size: cover; background-position: center;
            position: relative;
        }
        .news-card.featured .news-visual { min-height: 250px; }
        .news-card:nth-child(2) .news-visual {
            background: linear-gradient(175deg, rgba(90,10,15,.88) 0%, rgba(237,28,36,.55) 100%), var(--surface2);
            background-size: cover; background-position: center;
        }
        .news-card:nth-child(3) .news-visual {
            background: linear-gradient(175deg, rgba(5,55,85,.88) 0%, rgba(8,145,178,.55) 100%), var(--surface2);
            background-size: cover; background-position: center;
        }
        .badge {
            display: inline-flex; align-items: center;
            height: 24px; padding: 0 10px; border-radius: 999px;
            background: rgba(255,255,255,.93); color: #071f4f;
            font-size: .7rem; font-weight: 900; width: fit-content;
            letter-spacing: .03em;
        }
        .card-body { padding: 18px 20px 22px; }
        .card-meta {
            display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 10px;
            color: var(--muted); font-size: .77rem; font-weight: 700;
        }
        .card-meta span { display: flex; align-items: center; gap: 4px; }
        .card-body h3 {
            margin: 0; font-size: 1.1rem; line-height: 1.32; font-weight: 800;
            transition: color .15s;
        }
        .news-card.featured .card-body h3 { font-size: clamp(1.25rem, 2.5vw, 1.7rem); }
        .news-card:hover .card-body h3 { color: var(--blue); }
        .card-body p {
            margin: 10px 0 0; color: var(--muted); font-size: .87rem; line-height: 1.6;
            display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
        }
        .read-link {
            display: inline-flex; align-items: center; gap: 5px; margin-top: 14px;
            font-size: .79rem; font-weight: 800; color: var(--blue);
            opacity: 0; transform: translateX(-4px);
            transition: opacity .2s, transform .2s;
        }
        .news-card:hover .read-link { opacity: 1; transform: none; }

        /* â”€â”€ Guide grid â”€â”€ */
        .guide-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 18px; }
        .guide-card {
            padding: 24px 22px; border: 1px solid var(--line); border-radius: var(--radius);
            background: var(--surface); box-shadow: var(--shadow);
            display: block; transition: transform .2s, box-shadow .2s, border-color .2s;
            position: relative; overflow: hidden;
        }
        .guide-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-md); border-color: rgba(11,111,238,.25); }
        .guide-num {
            width: 38px; height: 38px; border-radius: 9px;
            display: grid; place-items: center; margin-bottom: 16px;
            color: #fff;
            background: linear-gradient(135deg, var(--navy), var(--blue));
            font-weight: 900; font-size: .85rem; letter-spacing: -.01em;
            box-shadow: 0 4px 12px rgba(11,111,238,.3);
        }
        .guide-card h3 { margin: 0 0 9px; font-size: .98rem; line-height: 1.38; font-weight: 800; }
        .guide-card p { margin: 0; color: var(--muted); font-size: .85rem; line-height: 1.58; }
        .guide-arrow {
            display: inline-flex; align-items: center; gap: 4px;
            margin-top: 14px; font-size: .78rem; font-weight: 800; color: var(--blue);
            opacity: 0; transition: opacity .2s;
        }
        .guide-card:hover .guide-arrow { opacity: 1; }

        /* â”€â”€ Shop grid â”€â”€ */
        .shop-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
        .shop-card {
            border: 1px solid var(--line); border-radius: var(--radius);
            background: var(--surface); overflow: hidden; box-shadow: var(--shadow);
            transition: transform .2s, box-shadow .2s, border-color .2s;
        }
        .shop-card:hover { transform: translateY(-5px); box-shadow: var(--shadow-lg); border-color: transparent; }
        .shop-top {
            min-height: 150px; display: grid; place-items: center;
            background: linear-gradient(135deg, rgba(11,111,238,.08), rgba(237,28,36,.05)), var(--surface2);
            background-size: cover; background-position: center; position: relative;
        }
        .shop-icon {
            width: 72px; height: 72px; border-radius: 14px;
            display: grid; place-items: center; color: #fff;
            background: linear-gradient(135deg, var(--blue), var(--navy));
            box-shadow: 0 8px 24px rgba(11,111,238,.3);
        }
        .shop-card:nth-child(2) .shop-icon {
            background: linear-gradient(135deg, var(--red), #9f1239);
            box-shadow: 0 8px 24px rgba(237,28,36,.3);
        }
        .shop-card:nth-child(3) .shop-icon {
            background: linear-gradient(135deg, var(--green), #0891b2);
            box-shadow: 0 8px 24px rgba(22,163,74,.3);
        }
        .shop-body { padding: 20px 22px 22px; }
        .shop-cat {
            font-size: .72rem; font-weight: 800; color: var(--blue);
            text-transform: uppercase; letter-spacing: .08em; margin-bottom: 7px;
        }
        .shop-body h3 { margin: 0 0 8px; font-size: 1.02rem; font-weight: 800; line-height: 1.35; }
        .shop-body p {
            margin: 0; color: var(--muted); font-size: .86rem; line-height: 1.58;
            display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
        }
        .price-row {
            display: flex; align-items: center; justify-content: space-between;
            gap: 12px; margin-top: 18px; padding-top: 16px; border-top: 1px solid var(--line);
        }
        .price { font-weight: 900; color: var(--red); font-size: 1.02rem; }
        .small-btn {
            height: 34px; padding: 0 16px; border-radius: var(--radius-sm);
            color: #fff; background: var(--blue);
            font-size: .81rem; font-weight: 900;
            display: inline-flex; align-items: center; gap: 5px;
            transition: background .15s, transform .15s; box-shadow: 0 2px 8px rgba(11,111,238,.25);
        }
        .small-btn:hover { background: var(--blue-dark); transform: translateY(-1px); }

        /* â”€â”€ Service band â”€â”€ */
        .service-band {
            display: grid; grid-template-columns: 1fr 1.05fr;
            gap: 0; align-items: stretch;
            border-radius: var(--radius); color: #fff; overflow: hidden;
            box-shadow: var(--shadow-lg);
        }
        .service-left {
            padding: 44px 40px;
            background: linear-gradient(145deg, rgba(7,31,79,.99), rgba(11,31,70,.98));
            position: relative; overflow: hidden;
        }
        .service-left::before {
            content: ""; position: absolute; top: -40px; right: -40px;
            width: 200px; height: 200px; border-radius: 50%;
            background: radial-gradient(circle, rgba(237,28,36,.2), transparent 70%);
        }
        .service-left h2 {
            margin: 0; font-size: clamp(1.6rem, 2.8vw, 2.3rem);
            line-height: 1.1; letter-spacing: -.02em; position: relative;
        }
        .service-left > p { margin: 16px 0 0; color: #b8cfe0; font-size: .93rem; line-height: 1.75; position: relative; }
        .service-actions { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 28px; position: relative; }
        .service-right {
            padding: 36px 32px;
            background: linear-gradient(145deg, rgba(11,31,70,.97), rgba(7,20,50,.98));
            display: grid; gap: 12px;
        }
        .service-card {
            display: grid; grid-template-columns: 46px 1fr;
            gap: 14px; padding: 18px 20px;
            border: 1px solid rgba(255,255,255,.1); border-radius: 10px;
            background: rgba(255,255,255,.06); transition: background .15s, border-color .15s;
        }
        .service-card:hover { background: rgba(255,255,255,.1); border-color: rgba(255,255,255,.18); }
        .service-icon {
            width: 46px; height: 46px; border-radius: 10px;
            background: rgba(11,111,238,.25); display: grid; place-items: center; color: #60a5fa;
            flex-shrink: 0;
        }
        .service-card h3 { margin: 0 0 5px; font-size: .92rem; font-weight: 800; }
        .service-card p { margin: 0; color: #9ab8d0; font-size: .83rem; line-height: 1.55; }

        /* â”€â”€ CTA â”€â”€ */
        .cta {
            padding: 44px 40px; display: grid;
            grid-template-columns: 1fr auto; gap: 28px; align-items: center;
            border: 1px solid var(--line); border-radius: var(--radius);
            background: var(--surface); box-shadow: var(--shadow-md);
            position: relative; overflow: hidden;
        }
        .cta::before {
            content: ""; position: absolute; inset: 0; pointer-events: none;
            background: linear-gradient(135deg, rgba(11,111,238,.04), transparent 60%);
        }
        .cta h2 {
            margin: 0; font-size: clamp(1.4rem, 2.5vw, 2rem);
            line-height: 1.18; letter-spacing: -.02em; position: relative;
        }
        .cta p { margin: 10px 0 0; color: var(--muted); font-size: .93rem; line-height: 1.7; position: relative; }

        /* â”€â”€ Footer â”€â”€ */
        .footer {
            background: #030d1e; color: #5a7a96;
            position: relative; overflow: hidden;
        }
        .footer::before {
            content: ""; position: absolute; top: 0; left: 0; right: 0; height: 2px;
            background: linear-gradient(90deg, var(--blue), #38bdf8, var(--red), #38bdf8, var(--blue));
        }
        .footer-main { padding: 64px 0 48px; }
        .footer-inner {
            display: grid;
            grid-template-columns: 1.8fr 1fr 1fr 1fr;
            gap: 52px; align-items: start;
        }
        .footer-brand { display: flex; align-items: center; margin-bottom: 14px; }
        .footer-brand img { height: 30px; filter: brightness(0) invert(1) opacity(.88); }
        .footer-tagline {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 5px 13px; border-radius: 999px;
            border: 1px solid rgba(255,255,255,.1);
            background: rgba(11,111,238,.12);
            color: #4a9eff; font-size: .7rem; font-weight: 900;
            text-transform: uppercase; letter-spacing: .1em; margin-bottom: 14px;
        }
        .footer-tagline-dot {
            width: 6px; height: 6px; border-radius: 50%;
            background: #22c55e; box-shadow: 0 0 0 3px rgba(34,197,94,.2);
        }
        .footer-desc { color: #4d6a83; font-size: .84rem; line-height: 1.78; max-width: 272px; margin-bottom: 22px; }
        .footer-social { display: flex; gap: 8px; }
        .footer-social a {
            width: 36px; height: 36px; border-radius: 8px;
            border: 1px solid rgba(255,255,255,.1); background: rgba(255,255,255,.05);
            display: grid; place-items: center; color: #4d6a83;
            transition: background .15s, color .15s, border-color .15s;
        }
        .footer-social a:hover { background: rgba(11,111,238,.2); color: #4a9eff; border-color: rgba(11,111,238,.35); }
        .footer-col-title {
            font-size: .68rem; font-weight: 900; text-transform: uppercase;
            letter-spacing: .12em; color: #e2e8f0; margin-bottom: 16px;
            padding-bottom: 10px; border-bottom: 1px solid rgba(255,255,255,.08);
        }
        .footer-nav { display: flex; flex-direction: column; gap: 10px; }
        .footer-nav a {
            color: #4d6a83; font-weight: 600; font-size: .84rem;
            transition: color .15s, padding-left .15s;
            display: flex; align-items: center; gap: 6px;
        }
        .footer-nav a:hover { color: #4a9eff; padding-left: 3px; }
        .footer-contact-item {
            display: flex; align-items: flex-start; gap: 10px;
            margin-bottom: 12px; color: #4d6a83; font-size: .83rem; line-height: 1.6;
        }
        .footer-contact-item svg { flex-shrink: 0; margin-top: 1px; color: #4a9eff; }
        .footer-contact-item a { color: #4a9eff; font-weight: 700; }
        .footer-contact-item a:hover { text-decoration: underline; }
        /* affiliation bar */
        .footer-affil {
            padding: 20px 0;
            display: flex; align-items: center; justify-content: center; gap: 20px;
            flex-wrap: wrap;
        }
        .footer-affil-label {
            font-size: .7rem; font-weight: 800; letter-spacing: .12em; text-transform: uppercase;
            color: #3d5a75;
        }
        .footer-affil-logos { display: flex; align-items: center; gap: 12px; }
        .footer-affil-item {
            display: block; border-radius: 10px; overflow: hidden;
            border: 1px solid rgba(255,255,255,.12);
            background: rgba(255,255,255,.08);
            padding: 5px 10px;
            transition: border-color .2s, background .2s;
        }
        .footer-affil-item:hover { border-color: rgba(255,255,255,.28); background: rgba(255,255,255,.14); }
        .footer-affil-item img {
            height: 34px; width: auto; max-width: 120px;
            object-fit: contain; display: block;
            filter: brightness(1.05) saturate(0.9);
            mix-blend-mode: screen;
        }
        [data-theme="light"] .footer-affil-item img { mix-blend-mode: normal; filter: brightness(1); }
        .footer-affil-sep {
            width: 1px; height: 28px;
            background: rgba(255,255,255,.12);
        }
        .footer-divider { border: none; border-top: 1px solid rgba(255,255,255,.07); margin: 0; }
        .footer-bottom {
            padding: 20px 0;
            display: flex; align-items: center; justify-content: space-between;
            gap: 16px; font-size: .79rem; color: #304a62;
        }
        .footer-bottom strong { color: #4d6a83; }
        .footer-bottom-links { display: flex; gap: 20px; }
        .footer-bottom-links a { color: #304a62; transition: color .15s; }
        .footer-bottom-links a:hover { color: #4a9eff; }

        /* â”€â”€ Scroll reveal â”€â”€ */
        .reveal { opacity: 0; transform: translateY(20px); transition: opacity .6s, transform .6s; }
        .reveal.visible { opacity: 1; transform: none; }

        /* â”€â”€ Responsive â”€â”€ */
        @media (max-width: 980px) {
            .nav-links { display: none; }
            .menu-btn { display: inline-grid; }
            .service-band { grid-template-columns: 1fr; }
            .cta { grid-template-columns: 1fr; text-align: center; }
            .cta .btn { width: 100%; max-width: 300px; margin: 0 auto; }
            .focus-grid, .shop-grid { grid-template-columns: repeat(2, 1fr); }
            .news-grid { grid-template-columns: 1fr 1fr; }
            .guide-grid { grid-template-columns: repeat(2, 1fr); }
            .hero-inner { gap: 36px; padding: 72px 0 64px; }
            .hero-visual { width: 340px; height: 300px; }
            .footer-inner { grid-template-columns: 1fr 1fr; gap: 36px; }
        }
        @media (max-width: 640px) {
            .hero-inner { padding: 56px 0 48px; flex-direction: column; gap: 40px; }
            .hero-visual { width: 100%; height: 220px; }
            .hero-copy { font-size: .96rem; }
            .section { padding: 56px 0; }
            .section-head { display: block; }
            .section-head .link-more { margin-top: 14px; display: inline-flex; }
            .focus-grid, .news-grid, .guide-grid, .shop-grid { grid-template-columns: 1fr; }
            .focus-grid { margin-top: 18px; }
            .service-left { padding: 30px 24px; }
            .service-right { padding: 24px 24px 30px; }
            .cta { padding: 26px 22px; }
            .footer-inner { grid-template-columns: 1fr; gap: 28px; }
            .footer-bottom { flex-direction: column; gap: 10px; text-align: center; }
            .footer-bottom-links { justify-content: center; flex-wrap: wrap; }
        }
    </style>
</head>
<body>

    <header class="topbar">
        <nav class="nav-inner" aria-label="Navigasi utama">
            <a class="brand" href="#home" aria-label="pahamIT">
                <img class="brand-logo-img" src="{{ asset('images/clean/logo_full_clean.png') }}" alt="pahamIT">
            </a>
            <div class="nav-links" id="navLinks">
                <a href="#berita" data-section="berita">Berita IT</a>
                <a href="#panduan" data-section="panduan">Panduan</a>
                <a href="#toko" data-section="toko">Toko IT</a>
                <a href="#jasa" data-section="jasa">Jasa</a>
                <a href="{{ route('about') }}" data-section="about">Tentang</a>
                <a href="#kontak" data-section="kontak">Kontak</a>
            </div>
            <div class="nav-right">
                <button class="theme-btn" id="themeToggle" type="button" aria-label="Ganti mode warna">
                    <svg class="sun" width="17" height="17" viewBox="0 0 24 24" fill="none"><path d="M12 4V2m0 20v-2M4 12H2m20 0h-2m-2.1-5.9 1.4-1.4M4.7 19.3l1.4-1.4m0-11.8L4.7 4.7m14.6 14.6-1.4-1.4M12 16a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    <svg class="moon" width="17" height="17" viewBox="0 0 24 24" fill="none"><path d="M21 14.4A8.6 8.6 0 0 1 9.6 3 8.6 8.6 0 1 0 21 14.4Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
                <button class="menu-btn" id="menuBtn" type="button" aria-label="Buka menu" aria-expanded="false">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M4 7h16M4 12h16M4 17h16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                </button>
            </div>
        </nav>
        <div class="mobile-menu" id="mobileMenu" style="width:min(1180px,calc(100% - 40px));margin:0 auto;">
            <a href="#berita">Berita IT</a>
            <a href="#panduan">Panduan Belajar</a>
            <a href="#toko">Toko IT</a>
            <a href="#jasa">Jasa IT</a>
            <a href="{{ route('about') }}">Tentang pahamIT</a>
            <a href="#kontak">Kontak</a>
        </div>
    </header>

    <main id="home">

        {{-- â”€â”€ HERO â”€â”€ --}}
        <section class="hero">
            <div class="hero-inner">
                <div class="hero-text">
                    <p class="eyebrow"><span class="eyebrow-dot"></span>Bukan Sekadar Belajar.</p>
                    <h1>Satu portal untuk <strong>berita</strong>,<br>panduan, dan solusi IT.</h1>
                    <p class="hero-copy">Ikuti perkembangan teknologi terbaru, pelajari jaringan, server, dan keamanan dari panduan praktis, serta temukan alat dan jasa IT yang siap pakai.</p>
                    <div class="hero-actions">
                        <a class="btn btn-primary" href="#berita">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M4 5h16M4 10h16M4 15h10" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                            Mulai Baca
                        </a>
                        <a class="btn btn-soft" href="#panduan">Lihat Panduan</a>
                        <a class="btn btn-soft" href="#toko">Toko IT</a>
                    </div>
                </div>
                <div class="hero-visual" aria-hidden="true">
                    <canvas id="heroCanvas"></canvas>
                    <div class="hero-visual-badge">
                        <span class="badge-dot"></span>
                        <span>Network - Security - IT</span>
                    </div>
                </div>
            </div>
        </section>

        {{-- â”€â”€ FOCUS CARDS â”€â”€ --}}
        <section class="wrap focus-wrap">
            <div class="focus-grid reveal">
                <article class="focus-card">
                    <div class="focus-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><path d="M4 5h16M4 10h16M4 15h10" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    </div>
                    <h2>Berita IT Terkini</h2>
                    <p>Update teknologi, keamanan siber, AI, cloud, jaringan, dan insight industri - dikemas ringkas dan mudah dipahami.</p>
                    <a class="focus-link" href="#berita">Baca berita <svg width="13" height="13" viewBox="0 0 24 24" fill="none"><path d="M5 12h14m-6-6 6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
                </article>
                <article class="focus-card">
                    <div class="focus-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><path d="M8 4h12v16H8a4 4 0 0 1-4-4V8a4 4 0 0 1 4-4Zm0 0v16M12 8h4M12 12h4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    </div>
                    <h2>Panduan & Tutorial</h2>
                    <p>Tutorial bertahap untuk network, server, Linux, security, dan troubleshooting - dari dasar hingga siap praktik langsung.</p>
                    <a class="focus-link" href="#panduan">Mulai belajar <svg width="13" height="13" viewBox="0 0 24 24" fill="none"><path d="M5 12h14m-6-6 6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
                </article>
                <article class="focus-card">
                    <div class="focus-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><path d="M6 7h12l1 13H5L6 7Zm3 0a3 3 0 0 1 6 0" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg>
                    </div>
                    <h2>Toko Alat & Jasa IT</h2>
                    <p>Template, script, konsultasi, instalasi jaringan, dan paket layanan IT untuk kantor, sekolah, dan bisnis.</p>
                    <a class="focus-link" href="#toko">Lihat produk <svg width="13" height="13" viewBox="0 0 24 24" fill="none"><path d="M5 12h14m-6-6 6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
                </article>
            </div>
        </section>

        {{-- â”€â”€ BERITA â”€â”€ --}}
        <section class="section" id="berita">
            <div class="wrap">
                <div class="section-head reveal">
                    <div>
                        <p class="label label-blue">Berita IT</p>
                        <h2 class="section-title">Update teknologi, langsung ke intinya.</h2>
                        <p class="section-copy">Berita IT terbaru - jaringan, keamanan, AI, cloud, dan software - disajikan ringkas dan mudah dicerna.</p>
                    </div>
                    <a class="link-more" href="{{ route('listing.berita') }}">Lihat semua berita
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none"><path d="M5 12h14m-6-6 6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
                </div>

                <div class="news-grid reveal">
                    @forelse ($beritaPosts as $post)
                        <a href="{{ route('post.berita', $post->slug) }}"
                           class="news-card {{ $loop->first ? 'featured' : '' }}">
                            <div class="news-visual"
                                @if ($post->featured_image_url)
                                    style="background-image: linear-gradient(175deg,rgba(7,31,79,.82) 0%,rgba(11,111,238,.45) 100%), url('{{ $post->featured_image_url }}'); background-size:cover; background-position:center;"
                                @endif>
                                <span class="badge">{{ $post->category ?? 'Berita' }}</span>
                            </div>
                            <div class="card-body">
                                <div class="card-meta">
                                    <span>
                                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none"><rect x="3" y="4" width="18" height="18" rx="2" stroke="currentColor" stroke-width="2"/><path d="M16 2v4M8 2v4M3 10h18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                                        {{ optional($post->published_at)->diffForHumans() ?? 'Draft' }}
                                    </span>
                                    <span>
                                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8Z" stroke="currentColor" stroke-width="2"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2"/></svg>
                                        {{ number_format($post->views_count) }} views
                                    </span>
                                </div>
                                <h3>{{ $post->title }}</h3>
                                <p>{{ $post->excerpt ?: 'Baca selengkapnya di pahamIT.' }}</p>
                                <span class="read-link">Baca selengkapnya <svg width="12" height="12" viewBox="0 0 24 24" fill="none"><path d="M5 12h14m-6-6 6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
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

        {{-- â”€â”€ PANDUAN â”€â”€ --}}
        <section class="section section-alt" id="panduan">
            <div class="wrap">
                <div class="section-head reveal">
                    <div>
                        <p class="label label-red">Panduan & Belajar IT</p>
                        <h2 class="section-title">Dari dasar sampai siap praktik.</h2>
                        <p class="section-copy">Tutorial runtut untuk networking, server, Linux, cyber security, dan troubleshooting - cocok untuk pemula maupun yang ingin naik level.</p>
                    </div>
                    <a class="link-more" href="{{ route('listing.panduan') }}">Lihat semua panduan
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none"><path d="M5 12h14m-6-6 6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
                </div>
                <div class="guide-grid reveal">
                    @forelse ($tutorialPosts as $post)
                        <a href="{{ route('post.panduan', $post->slug) }}" class="guide-card">
                            <div class="guide-num">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</div>
                            <h3>{{ $post->title }}</h3>
                            <p>{{ Str::limit($post->excerpt ?: 'Panduan belajar dari pahamIT.', 80) }}</p>
                            <span class="guide-arrow">Pelajari <svg width="12" height="12" viewBox="0 0 24 24" fill="none"><path d="M5 12h14m-6-6 6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                        </a>
                    @empty
                        <article class="guide-card">
                            <div class="guide-num">01</div>
                            <h3>Tutorial pertama menunggu</h3>
                            <p>Tambahkan panduan dari dashboard - akan tampil otomatis di sini.</p>
                        </article>
                    @endforelse
                </div>
            </div>
        </section>

        {{-- â”€â”€ TOKO â”€â”€ --}}
        <section class="section" id="toko">
            <div class="wrap">
                <div class="section-head reveal">
                    <div>
                        <p class="label label-green">Toko IT</p>
                        <h2 class="section-title">Produk dan jasa IT, satu tempat.</h2>
                        <p class="section-copy">Template network, script konfigurasi, paket jasa instalasi, dan konsultasi IT tersedia di sini.</p>
                    </div>
                    <a class="link-more" href="#kontak">Minta penawaran
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none"><path d="M5 12h14m-6-6 6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
                </div>
                <div class="shop-grid reveal">
                    @forelse ($jualanPosts as $post)
                        <article class="shop-card">
                            <a href="{{ route('post.toko', $post->slug) }}">
                                <div class="shop-top"
                                    @if ($post->featured_image_url)
                                        style="background-image: linear-gradient(160deg,rgba(7,31,79,.5),rgba(11,111,238,.25)), url('{{ $post->featured_image_url }}'); background-size:cover; background-position:center;"
                                    @endif>
                                    @if (!$post->featured_image_url)
                                    <div class="shop-icon">
                                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none"><path d="M6 7h12l1 13H5L6 7Zm3 0a3 3 0 0 1 6 0" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg>
                                    </div>
                                    @endif
                                </div>
                            </a>
                            <div class="shop-body">
                                <div class="shop-cat">{{ $post->category ?? 'Produk IT' }}</div>
                                <a href="{{ route('post.toko', $post->slug) }}"><h3>{{ $post->title }}</h3></a>
                                <p>{{ $post->excerpt ?: 'Produk atau jasa IT dari pahamIT.' }}</p>
                                <div class="price-row">
                                    <span class="price">{{ $post->price ? 'Rp '.number_format($post->price,0,',','.') : 'Custom' }}</span>
                                    <a class="small-btn" href="{{ route('post.toko', $post->slug) }}">
                                        Detail
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none"><path d="M5 12h14m-6-6 6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @empty
                        <article class="shop-card">
                            <div class="shop-top"><div class="shop-icon"><svg width="28" height="28" viewBox="0 0 24 24" fill="none"><path d="M6 7h12l1 13H5L6 7Zm3 0a3 3 0 0 1 6 0" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg></div></div>
                            <div class="shop-body">
                                <div class="shop-cat">Produk</div>
                                <h3>Tambahkan produk pertama.</h3>
                                <p>Produk dan jasa yang dipublish akan tampil otomatis di sini.</p>
                                <div class="price-row"><span class="price">Custom</span><a class="small-btn" href="#kontak">Tanya</a></div>
                            </div>
                        </article>
                    @endforelse
                </div>
            </div>
        </section>

        {{-- â”€â”€ JASA â”€â”€ --}}
        <section class="section section-alt" id="jasa">
            <div class="wrap">
                <div class="service-band reveal">
                    <div class="service-left">
                        <p class="label" style="color:#93c5fd;margin-bottom:16px;">Jasa IT pahamIT</p>
                        <h2>Infrastruktur stabil, belajar jalan, bisnis aman.</h2>
                        <p>pahamIT hadir sebagai partner teknis untuk setup, audit, dan maintenance infrastruktur IT - tidak hanya media baca, tapi solusi nyata.</p>
                        <div class="service-actions">
                            <a class="btn btn-primary" href="#kontak">Diskusi Kebutuhan</a>
                            <a class="btn btn-soft" href="#toko">Lihat Produk</a>
                        </div>
                    </div>
                    <div class="service-right">
                        <article class="service-card">
                            <div class="service-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none"><path d="M4 7h16M7 12h10M9 17h6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg></div>
                            <div><h3>Instalasi Jaringan</h3><p>Kabel, rack, switch, WiFi, VLAN, subnetting, dan dokumentasi topologi lengkap.</p></div>
                        </article>
                        <article class="service-card">
                            <div class="service-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none"><path d="M12 3 5 6v5c0 4.5 2.8 7.7 7 9 4.2-1.3 7-4.5 7-9V6l-7-3Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg></div>
                            <div><h3>Audit Keamanan</h3><p>Review firewall, akses remote, password policy, backup, dan rekomendasi hardening.</p></div>
                        </article>
                        <article class="service-card">
                            <div class="service-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none"><path d="M5 18h14M7 14l3-3 3 2 4-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
                            <div><h3>Monitoring & Maintenance</h3><p>Dashboard monitoring, alert downtime, laporan berkala, dan perawatan perangkat.</p></div>
                        </article>
                    </div>
                </div>
            </div>
        </section>

        {{-- â”€â”€ CTA / KONTAK â”€â”€ --}}
        <section class="section" id="kontak">
            <div class="wrap">
                <div class="cta reveal">
                    <div>
                        <h2>Ada kebutuhan IT? Mari diskusi.</h2>
                        <p>Dari pertanyaan teknis hingga kebutuhan infrastruktur - tim pahamIT siap membantu lewat konsultasi langsung via WhatsApp.</p>
                    </div>
                    <a class="btn btn-primary" href="https://wa.me/6281250653005" target="_blank" rel="noreferrer" style="flex-shrink:0;">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        Hubungi via WhatsApp
                    </a>
                </div>
            </div>
        </section>

    </main>

    <footer class="footer">
        <div class="wrap">
            <div class="footer-main">
                <div class="footer-inner">
                    {{-- Brand --}}
                    <div>
                        <div class="footer-brand">
                            <img src="{{ asset('images/clean/logo_full_clean.png') }}" alt="pahamIT">
                        </div>
                        <div class="footer-tagline">
                            <span class="footer-tagline-dot"></span>
                            Bukan Sekadar Belajar
                        </div>
                        <p class="footer-desc">Portal berita IT, panduan belajar, dan toko alat & jasa IT terpercaya untuk profesional dan pelajar Indonesia.</p>
                        <div class="footer-social">
                            <a href="mailto:info@pahamit.com" title="Email" aria-label="Email pahamIT">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.746l7.73-8.835L1.254 2.25H8.08l4.253 5.622 5.91-5.622Zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                            </a>
                            <a href="https://wa.me/6281250653005" target="_blank" rel="noreferrer" title="WhatsApp" aria-label="WhatsApp pahamIT">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r=".6" fill="currentColor" stroke="none"/></svg>
                            </a>
                            <a href="{{ route('seo.sitemap') }}" title="Sitemap" aria-label="Sitemap pahamIT">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814ZM9.545 15.568V8.432L15.818 12l-6.273 3.568Z"/></svg>
                            </a>
                            <a href="{{ route('privacy') }}" title="Kebijakan Privasi" aria-label="Kebijakan Privasi pahamIT">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6ZM2 9h4v12H2z"/><circle cx="4" cy="4" r="2"/></svg>
                            </a>
                        </div>
                    </div>

                    {{-- Konten --}}
                    <div>
                        <p class="footer-col-title">Konten</p>
                        <nav class="footer-nav">
                            <a href="#berita"><svg width="11" height="11" viewBox="0 0 24 24" fill="none"><path d="M5 12h14m-6-6 6 6-6 6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>Berita IT</a>
                            <a href="#panduan"><svg width="11" height="11" viewBox="0 0 24 24" fill="none"><path d="M5 12h14m-6-6 6 6-6 6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>Panduan Belajar</a>
                            <a href="#toko"><svg width="11" height="11" viewBox="0 0 24 24" fill="none"><path d="M5 12h14m-6-6 6 6-6 6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>Toko IT</a>
                            <a href="#jasa"><svg width="11" height="11" viewBox="0 0 24 24" fill="none"><path d="M5 12h14m-6-6 6 6-6 6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>Jasa IT</a>
                        </nav>
                    </div>

                    {{-- Layanan --}}
                    <div>
                        <p class="footer-col-title">Layanan</p>
                        <nav class="footer-nav">
                            <a href="#kontak"><svg width="11" height="11" viewBox="0 0 24 24" fill="none"><path d="M5 12h14m-6-6 6 6-6 6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>Konsultasi IT</a>
                            <a href="#toko"><svg width="11" height="11" viewBox="0 0 24 24" fill="none"><path d="M5 12h14m-6-6 6 6-6 6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>Template & Tools</a>
                            <a href="#jasa"><svg width="11" height="11" viewBox="0 0 24 24" fill="none"><path d="M5 12h14m-6-6 6 6-6 6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>Pelatihan IT</a>
                            <a href="#kontak"><svg width="11" height="11" viewBox="0 0 24 24" fill="none"><path d="M5 12h14m-6-6 6 6-6 6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>Pasang Iklan</a>
                        </nav>
                    </div>

                    {{-- Kontak --}}
                    <div>
                        <p class="footer-col-title">Kontak</p>
                        <div class="footer-contact-item">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0Z" stroke="currentColor" stroke-width="2"/><circle cx="12" cy="10" r="3" stroke="currentColor" stroke-width="2"/></svg>
                            <span>Indonesia</span>
                        </div>
                        <div class="footer-contact-item">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2Z" stroke="currentColor" stroke-width="2"/><path d="m22 6-10 7L2 6" stroke="currentColor" stroke-width="2"/></svg>
                            <span><a href="mailto:info@pahamit.com">info@pahamit.com</a></span>
                        </div>
                        <div class="footer-contact-item">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5Z" stroke="currentColor" stroke-width="2"/></svg>
                            <span><a href="https://wa.me/6281250653005" target="_blank" rel="noreferrer">081250653005</a></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-affil">
                <span class="footer-affil-label">Member of</span>
                <div class="footer-affil-logos">
                    <a href="mailto:info@pahamit.com?subject=Info%20Elata" class="footer-affil-item" title="Elata">
                        <img src="{{ asset('images/images/elata.jpeg') }}" alt="Elata">
                    </a>
                    <span class="footer-affil-sep"></span>
                    <a href="https://fluxaborneo.tech" target="_blank" rel="noreferrer" class="footer-affil-item" title="Fluxa Borneo Tech">
                        <img src="{{ asset('images/images/fluxa.jpeg') }}" alt="Fluxa Borneo Tech">
                    </a>
                </div>
            </div>
            <hr class="footer-divider">
            <div class="footer-bottom">
                <span>&copy; {{ date('Y') }} <strong>pahamIT</strong>. Semua hak dilindungi.</span>
                <div class="footer-bottom-links">
                    <a href="{{ route('about') }}">Tentang</a>
                    <a href="{{ route('listing.berita') }}">Semua Berita</a>
                    <a href="{{ route('listing.panduan') }}">Semua Panduan</a>
                    <a href="{{ route('privacy') }}">Kebijakan Privasi</a>
                    <a href="{{ route('seo.sitemap') }}">Sitemap</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        const html  = document.documentElement;
        const saved = localStorage.getItem('pahamit-theme');
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

        const sections = document.querySelectorAll('section[id]');
        const navAs    = document.querySelectorAll('.nav-links a[data-section]');
        const sObs = new IntersectionObserver(entries => {
            entries.forEach(e => {
                if (e.isIntersecting)
                    navAs.forEach(a => a.classList.toggle('active', a.dataset.section === e.target.id));
            });
        }, { rootMargin: '-40% 0px -55% 0px' });
        sections.forEach(s => sObs.observe(s));

        const rObs = new IntersectionObserver(entries => {
            entries.forEach((e, i) => {
                if (e.isIntersecting) {
                    setTimeout(() => e.target.classList.add('visible'), i * 70);
                    rObs.unobserve(e.target);
                }
            });
        }, { threshold: 0.07 });
        document.querySelectorAll('.reveal').forEach(el => rObs.observe(el));

        /* â”€â”€ Hero Canvas - IT Neuron Network â”€â”€ */
        (function() {
            const canvas = document.getElementById('heroCanvas');
            if (!canvas) return;
            const ctx = canvas.getContext('2d');
            let W, H, nodes, raf;
            const dpr = window.devicePixelRatio || 1;

            const TERMS = [
                { label: 'Docker',        color: '#4a9eff' },
                { label: 'Kubernetes',    color: '#ed4a50' },
                { label: 'CI/CD',         color: '#4a9eff' },
                { label: 'Linux',         color: '#f9a825' },
                { label: 'Nginx',         color: '#4a9eff' },
                { label: 'Python',        color: '#4a9eff' },
                { label: 'DevOps',        color: '#ed4a50' },
                { label: 'Network',       color: '#4a9eff' },
                { label: 'Security',      color: '#ed4a50' },
                { label: 'DNS',           color: '#4a9eff' },
                { label: 'VPN',           color: '#4a9eff' },
                { label: 'API',           color: '#4a9eff' },
                { label: 'Cloud',         color: '#ed4a50' },
                { label: 'Firewall',      color: '#ed4a50' },
                { label: 'SSH',           color: '#4a9eff' },
                { label: 'TCP/IP',        color: '#4a9eff' },
                { label: 'Git',           color: '#f9a825' },
                { label: 'Server',        color: '#4a9eff' },
                { label: 'Ansible',       color: '#ed4a50' },
                { label: 'Terraform',     color: '#4a9eff' },
            ];

            function resize() {
                const rect = canvas.parentElement.getBoundingClientRect();
                W = canvas.width  = rect.width  * dpr;
                H = canvas.height = rect.height * dpr;
                canvas.style.width  = rect.width  + 'px';
                canvas.style.height = rect.height + 'px';
                init();
            }

            function init() {
                const pad = 48 * dpr;
                nodes = TERMS.map(t => ({
                    label: t.label,
                    color: t.color,
                    x: pad + Math.random() * (W - pad * 2),
                    y: pad + Math.random() * (H - pad * 2),
                    vx: (Math.random() - 0.5) * 0.22,
                    vy: (Math.random() - 0.5) * 0.22,
                    r:  (Math.random() * 1.5 + 2.5) * dpr,
                    phase: Math.random() * Math.PI * 2,
                }));
            }

            function draw() {
                ctx.clearRect(0, 0, W, H);
                const LINK = 125 * dpr;
                const t = performance.now() / 1000;

                for (const n of nodes) {
                    n.x += n.vx; n.y += n.vy;
                    if (n.x < 0 || n.x > W) n.vx *= -1;
                    if (n.y < 0 || n.y > H) n.vy *= -1;
                }

                /* synaptic lines */
                for (let i = 0; i < nodes.length; i++) {
                    for (let j = i + 1; j < nodes.length; j++) {
                        const dx = nodes[i].x - nodes[j].x, dy = nodes[i].y - nodes[j].y;
                        const d = Math.sqrt(dx * dx + dy * dy);
                        if (d < LINK) {
                            const a = (1 - d / LINK) * 0.3;
                            ctx.beginPath();
                            ctx.moveTo(nodes[i].x, nodes[i].y);
                            ctx.lineTo(nodes[j].x, nodes[j].y);
                            ctx.strokeStyle = `rgba(74,158,255,${a})`;
                            ctx.lineWidth = 0.8 * dpr;
                            ctx.stroke();
                        }
                    }
                }

                /* nodes + labels */
                const fontSize = Math.round(8.5 * dpr);
                ctx.font = `600 ${fontSize}px "Instrument Sans",system-ui,sans-serif`;
                ctx.textAlign = 'center';

                for (const n of nodes) {
                    const pulse = n.r + Math.sin(t * 1.8 + n.phase) * 1.2 * dpr;

                    /* soft glow */
                    const g = ctx.createRadialGradient(n.x, n.y, 0, n.x, n.y, pulse * 6);
                    const isBlue = n.color === '#4a9eff';
                    g.addColorStop(0, isBlue ? 'rgba(74,158,255,.22)' : n.color === '#f9a825' ? 'rgba(249,168,37,.18)' : 'rgba(237,74,80,.22)');
                    g.addColorStop(1, 'transparent');
                    ctx.beginPath();
                    ctx.arc(n.x, n.y, pulse * 6, 0, Math.PI * 2);
                    ctx.fillStyle = g;
                    ctx.fill();

                    /* dot */
                    ctx.beginPath();
                    ctx.arc(n.x, n.y, pulse, 0, Math.PI * 2);
                    ctx.fillStyle = n.color;
                    ctx.fill();

                    /* label */
                    ctx.fillStyle = 'rgba(193,218,255,0.78)';
                    ctx.fillText(n.label, n.x, n.y + pulse + 11 * dpr);
                }

                raf = requestAnimationFrame(draw);
            }

            const obs = new IntersectionObserver(entries => {
                if (entries[0].isIntersecting) { if (!raf) draw(); }
                else { cancelAnimationFrame(raf); raf = null; }
            });
            obs.observe(canvas.parentElement);
            resize();
            window.addEventListener('resize', resize, { passive: true });
        })();
    </script>
    @include('site.partials.adroll')
</body>
</html>
