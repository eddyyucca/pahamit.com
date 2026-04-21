<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $post->excerpt ?: Str::limit(strip_tags($post->title), 155) }}">
    <title>{{ $post->title }} - pahamIT</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <style>
        :root {
            --brand:       #2563EB;
            --brand-h:     #1d4ed8;
            --accent:      #06B6D4;
            --green:       #10B981;
            --amber:       #F59E0B;
            --rose:        #F43F5E;
            --bg:          #F5F7FA;
            --surface:     #FFFFFF;
            --surface2:    #F0F4F9;
            --border:      #E2E8F0;
            --text:        #0F172A;
            --text2:       #475569;
            --text3:       #94A3B8;
            --hero-bg:     #050d1f;
            --code-bg:     #0F172A;
            --code-text:   #E2E8F0;
            --inline-bg:   #EFF6FF;
            --inline-text: #1d4ed8;
            --radius:      12px;
            --shadow:      0 1px 3px rgba(15,23,42,.06), 0 4px 14px rgba(15,23,42,.05);
            --shadow-md:   0 4px 12px rgba(15,23,42,.08), 0 12px 36px rgba(15,23,42,.07);
            --font-scale:  1;
        }
        [data-theme="dark"] {
            --bg:          #090e18;
            --surface:     #0f1828;
            --surface2:    #162034;
            --border:      #1e2d45;
            --text:        #F1F5F9;
            --text2:       #94A3B8;
            --text3:       #475569;
            --hero-bg:     #030912;
            --inline-bg:   #1e2d4e;
            --inline-text: #93c5fd;
            --shadow:      0 1px 3px rgba(0,0,0,.4), 0 4px 14px rgba(0,0,0,.28);
            --shadow-md:   0 4px 12px rgba(0,0,0,.5), 0 12px 36px rgba(0,0,0,.38);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body {
            font-family: "Plus Jakarta Sans", ui-sans-serif, system-ui, sans-serif;
            background: var(--bg); color: var(--text);
            line-height: 1.7; overflow-x: hidden;
            transition: background .22s, color .22s;
        }
        a { color: inherit; text-decoration: none; }
        img { display: block; max-width: 100%; }
        button { font: inherit; cursor: pointer; }

        /* â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
           NAV
        â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• */
        .topbar {
            position: sticky; top: 0; z-index: 100;
            background: rgba(255,255,255,.93);
            border-bottom: 1px solid var(--border);
            backdrop-filter: blur(24px);
            transition: background .22s, box-shadow .22s;
        }
        .topbar.scrolled { box-shadow: 0 2px 16px rgba(15,23,42,.08); }
        [data-theme="dark"] .topbar { background: rgba(9,14,24,.94); }
        [data-theme="dark"] .topbar.scrolled { box-shadow: 0 2px 16px rgba(0,0,0,.4); }

        .nav-inner {
            width: min(1240px, calc(100% - 40px)); margin: 0 auto;
            display: flex; align-items: center;
            justify-content: space-between; gap: 12px;
            min-height: 62px;
        }
        .brand { display: flex; align-items: center; flex-shrink: 0; }
        .brand-logo-img { height: 32px; width: auto; transition: filter .22s; }
        [data-theme="dark"] .brand-logo-img { filter: brightness(0) invert(1); }

        .nav-right { display: flex; align-items: center; gap: 6px; flex-shrink: 0; }
        .nav-btn {
            height: 34px; padding: 0 12px; border-radius: 8px;
            font-size: .8rem; font-weight: 700;
            display: inline-flex; align-items: center; gap: 5px;
            border: 1px solid var(--border); background: var(--surface);
            color: var(--text2); transition: .15s; white-space: nowrap;
        }
        .nav-btn:hover { background: var(--surface2); color: var(--text); border-color: rgba(37,99,235,.25); }
        .nav-btn.edit-btn { background: rgba(37,99,235,.07); border-color: rgba(37,99,235,.22); color: var(--brand); }
        .nav-btn.edit-btn:hover { background: rgba(37,99,235,.13); }
        .icon-btn {
            width: 34px; height: 34px; border-radius: 8px;
            border: 1px solid var(--border); background: var(--surface);
            color: var(--text2); display: grid; place-items: center; transition: .15s;
            flex-shrink: 0;
        }
        .icon-btn:hover { background: var(--surface2); color: var(--brand); border-color: rgba(37,99,235,.25); }

        [data-theme="dark"] .sun { display: none; }
        [data-theme="light"] .moon { display: none; }

        /* â”€â”€ Preview bar â”€â”€ */
        .preview-bar {
            background: linear-gradient(90deg, #d97706, #b45309);
            color: #fff; font-size: .8rem; font-weight: 700;
            padding: 9px 20px; text-align: center;
        }
        .preview-bar a { text-decoration: underline; color: rgba(255,255,255,.88); }

        /* â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
           PRODUCT HEADER - light/clean
        â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• */
        .product-header {
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            padding: 28px 0 0;
        }
        .product-header-inner {
            width: min(1240px, calc(100% - 40px)); margin: 0 auto;
        }
        .product-breadcrumb {
            display: flex; align-items: center; gap: 6px; flex-wrap: wrap;
            font-size: .73rem; font-weight: 700; color: var(--text3);
            margin-bottom: 16px;
        }
        .product-breadcrumb a { color: var(--brand); transition: color .15s; }
        .product-breadcrumb a:hover { color: var(--brand-h); }
        .product-header-title {
            font-size: clamp(1.4rem, 3vw, 2.1rem);
            font-weight: 800; line-height: 1.18;
            letter-spacing: -.022em; margin-bottom: 10px;
        }
        .product-header-meta {
            display: flex; flex-wrap: wrap; align-items: center;
            gap: 8px; padding-bottom: 20px;
        }
        .product-cat-badge {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 3px 11px; border-radius: 999px;
            font-size: .7rem; font-weight: 800; letter-spacing: .05em;
            background: rgba(37,99,235,.07); color: var(--brand);
            border: 1px solid rgba(37,99,235,.18);
        }
        .meta-dot { color: var(--text3); font-size: .8rem; }
        .meta-sm { font-size: .76rem; font-weight: 700; color: var(--text3); display: inline-flex; align-items: center; gap: 4px; }

        /* â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
           MAIN PRODUCT LAYOUT
        â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• */
        .product-layout {
            width: min(1240px, calc(100% - 40px)); margin: 0 auto;
            display: grid; grid-template-columns: 1fr 380px;
            gap: 44px; align-items: start;
            padding: 40px 0 80px;
        }
        .product-body { min-width: 0; }

        /* Featured image */
        .product-feat-img {
            width: 100%; aspect-ratio: 16/9;
            object-fit: cover; border-radius: var(--radius);
            margin-bottom: 32px; box-shadow: var(--shadow-md);
        }
        .product-feat-placeholder {
            width: 100%; aspect-ratio: 16/9;
            background: linear-gradient(135deg, rgba(37,99,235,.07), rgba(6,182,212,.05));
            border-radius: var(--radius); margin-bottom: 32px;
            display: grid; place-items: center;
            border: 1px solid var(--border); box-shadow: var(--shadow);
        }

        /* Trust badges */
        .trust-badges {
            display: flex; flex-wrap: wrap; gap: 10px;
            margin-bottom: 32px;
        }
        .trust-badge {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 8px 14px; border-radius: 999px;
            background: var(--surface2); border: 1px solid var(--border);
            font-size: .78rem; font-weight: 700; color: var(--text2);
        }
        .trust-badge-icon {
            width: 20px; height: 20px; border-radius: 50%;
            background: var(--green); color: #fff;
            display: grid; place-items: center; flex-shrink: 0;
        }

        /* Description section */
        .section-label {
            font-size: .68rem; font-weight: 900; letter-spacing: .1em;
            text-transform: uppercase; color: var(--text3); margin-bottom: 14px;
            display: flex; align-items: center; gap: 7px;
        }
        .section-label::before {
            content: ""; width: 12px; height: 2px; border-radius: 2px;
            background: var(--brand); display: inline-block; flex-shrink: 0;
        }

        /* Article content */
        .article-content {
            font-size: calc(1.04rem * var(--font-scale));
            line-height: 1.88; color: var(--text);
        }
        .article-content h2 {
            font-size: calc(1.3rem * var(--font-scale));
            font-weight: 800; letter-spacing: -.02em; line-height: 1.2;
            margin: 2.2em 0 .72em;
            padding-bottom: .5em; border-bottom: 2px solid var(--border);
        }
        .article-content h3 {
            font-size: calc(1.1rem * var(--font-scale));
            font-weight: 800; margin: 1.8em 0 .6em; letter-spacing: -.01em;
        }
        .article-content h4 {
            font-size: calc(1rem * var(--font-scale));
            font-weight: 700; margin: 1.5em 0 .5em; color: var(--text2);
        }
        .article-content p { margin: 0 0 1.3em; }
        .article-content strong { font-weight: 800; }
        .article-content em { font-style: italic; color: var(--text2); }
        .article-content a {
            color: var(--brand); font-weight: 700;
            text-decoration: underline; text-underline-offset: 3px;
            text-decoration-color: rgba(37,99,235,.3); transition: text-decoration-color .15s;
        }
        .article-content a:hover { text-decoration-color: var(--brand); }
        .article-content ul, .article-content ol { padding-left: 1.55em; margin: 0 0 1.3em; }
        .article-content li { margin-bottom: .5em; }
        .article-content blockquote {
            border-left: 3px solid var(--brand);
            background: var(--surface2);
            margin: 1.8em 0; padding: 15px 20px;
            border-radius: 0 10px 10px 0;
            color: var(--text2); font-style: italic;
        }
        [data-theme="dark"] .article-content blockquote { background: rgba(37,99,235,.1); }
        .article-content blockquote p { margin: 0; }
        .article-content code {
            font-family: "Fira Code","Cascadia Code",ui-monospace,monospace;
            font-size: .85em; background: var(--inline-bg);
            color: var(--inline-text); padding: 2px 6px; border-radius: 5px;
        }

        /* Code blocks */
        .code-block-wrap { margin: 1.8em 0; border-radius: var(--radius); overflow: hidden; box-shadow: var(--shadow-md); }
        .code-block-header {
            display: flex; align-items: center; justify-content: space-between;
            padding: 9px 16px; background: #14202e;
            border-bottom: 1px solid rgba(255,255,255,.06);
        }
        .code-lang { font-size: .68rem; font-weight: 800; letter-spacing: .1em; text-transform: uppercase; color: #4a6580; }
        .code-copy-btn {
            display: flex; align-items: center; gap: 4px;
            font-size: .7rem; font-weight: 700; color: #4a6580;
            background: none; border: none; padding: 4px 8px; border-radius: 5px;
            transition: .15s; cursor: pointer;
        }
        .code-copy-btn:hover { color: #93c5fd; background: rgba(255,255,255,.07); }
        .code-block-wrap pre { margin: 0; background: var(--code-bg); overflow-x: auto; padding: 20px; }
        .code-block-wrap code {
            font-family: "Fira Code","Cascadia Code",ui-monospace,monospace;
            font-size: .86rem; line-height: 1.75;
            background: none !important; color: var(--code-text) !important;
            padding: 0 !important; border-radius: 0 !important; white-space: pre;
        }

        /* â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
           PURCHASE SIDEBAR (sticky)
        â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• */
        .purchase-sidebar {
            position: sticky; top: 76px;
            display: flex; flex-direction: column; gap: 14px;
        }
        .purchase-card {
            background: var(--surface); border: 1px solid var(--border);
            border-radius: var(--radius); padding: 22px; box-shadow: var(--shadow-md);
        }
        .purchase-title {
            font-size: 1rem; font-weight: 800; line-height: 1.35;
            margin-bottom: 14px; color: var(--text);
        }
        .price-display {
            margin-bottom: 18px;
        }
        .price-label {
            font-size: .68rem; font-weight: 800; letter-spacing: .1em;
            text-transform: uppercase; color: var(--text3); margin-bottom: 4px;
        }
        .price-value {
            font-size: 1.9rem; font-weight: 800; color: var(--brand);
            letter-spacing: -.02em; line-height: 1;
        }
        .price-contact {
            font-size: 1.4rem; font-weight: 800; color: var(--text2);
            line-height: 1;
        }
        .price-divider {
            height: 1px; background: var(--border); margin: 18px 0;
        }

        /* Category badge in sidebar */
        .sb-cat-badge {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 4px 12px; border-radius: 999px;
            font-size: .72rem; font-weight: 800; letter-spacing: .04em;
            background: rgba(37,99,235,.07); color: var(--brand);
            border: 1px solid rgba(37,99,235,.18); margin-bottom: 18px;
        }

        /* CTA buttons */
        .cta-wa {
            display: flex; align-items: center; justify-content: center; gap: 8px;
            width: 100%; height: 46px; border-radius: 10px;
            background: #25D366; color: #fff; border: none;
            font-size: .92rem; font-weight: 800;
            text-decoration: none; transition: background .18s, transform .18s;
            margin-bottom: 10px; cursor: pointer;
        }
        .cta-wa:hover { background: #1ebe5d; transform: translateY(-1px); }
        .cta-email {
            display: flex; align-items: center; justify-content: center; gap: 8px;
            width: 100%; height: 46px; border-radius: 10px;
            background: transparent; color: var(--brand);
            border: 1.5px solid var(--brand);
            font-size: .92rem; font-weight: 800;
            text-decoration: none; transition: .18s;
            cursor: pointer;
        }
        .cta-email:hover { background: rgba(37,99,235,.07); transform: translateY(-1px); }

        /* Sidebar share row */
        .sb-share {
            display: flex; align-items: center; gap: 8px; flex-wrap: wrap;
            padding-top: 16px; border-top: 1px solid var(--border); margin-top: 6px;
        }
        .sb-share-label {
            font-size: .68rem; font-weight: 900; text-transform: uppercase;
            letter-spacing: .1em; color: var(--text3); flex-shrink: 0;
        }
        .sb-share-btn {
            height: 30px; padding: 0 10px; border-radius: 7px;
            border: 1px solid var(--border); background: var(--surface2);
            color: var(--text2); font-size: .76rem; font-weight: 700;
            display: inline-flex; align-items: center; gap: 5px;
            transition: .15s; cursor: pointer; text-decoration: none;
        }
        .sb-share-btn:hover { background: var(--surface); color: var(--text); }
        .sb-share-btn.tw:hover { background: rgba(29,161,242,.07); color: #1DA1F2; border-color: rgba(29,161,242,.3); }
        .sb-share-btn.copy-ok { background: rgba(16,185,129,.08); color: #10B981; border-color: rgba(16,185,129,.3); }

        /* Views count in sidebar */
        .sb-views {
            display: flex; align-items: center; gap: 5px; justify-content: center;
            font-size: .74rem; font-weight: 700; color: var(--text3);
            padding-top: 14px; border-top: 1px solid var(--border); margin-top: 4px;
        }

        /* â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
           RELATED PRODUCTS GRID
        â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• */
        .related-section {
            width: min(1240px, calc(100% - 40px)); margin: 0 auto;
            padding-bottom: 80px;
        }
        .related-section-title {
            font-size: 1.1rem; font-weight: 800; margin-bottom: 20px;
            display: flex; align-items: center; gap: 10px;
        }
        .related-section-title::before {
            content: ""; width: 18px; height: 3px; border-radius: 3px;
            background: var(--brand); display: inline-block; flex-shrink: 0;
        }
        .related-grid {
            display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px;
        }
        .rel-card {
            background: var(--surface); border: 1px solid var(--border);
            border-radius: var(--radius); overflow: hidden; box-shadow: var(--shadow);
            transition: box-shadow .2s, transform .2s;
        }
        .rel-card:hover { box-shadow: var(--shadow-md); transform: translateY(-2px); }
        .rel-card-img {
            aspect-ratio: 16/9; width: 100%; object-fit: cover;
            background: linear-gradient(135deg, rgba(37,99,235,.07), rgba(6,182,212,.05));
        }
        .rel-card-img-placeholder {
            aspect-ratio: 16/9; display: grid; place-items: center;
            background: linear-gradient(135deg, rgba(37,99,235,.06), rgba(6,182,212,.04));
        }
        .rel-card-body { padding: 14px; }
        .rel-card-cat {
            font-size: .67rem; font-weight: 800; letter-spacing: .08em;
            text-transform: uppercase; color: var(--brand); margin-bottom: 5px;
        }
        .rel-card-title {
            font-size: .88rem; font-weight: 700; line-height: 1.4;
            color: var(--text); margin-bottom: 8px; transition: color .15s;
        }
        .rel-card:hover .rel-card-title { color: var(--brand); }
        .rel-card-price {
            font-size: .92rem; font-weight: 800; color: var(--brand);
        }
        .rel-card-price.contact { color: var(--text2); font-size: .82rem; }

        /* â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
           BACK TO TOP
        â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• */
        #backTop {
            position: fixed; bottom: 24px; right: 20px; z-index: 40;
            width: 40px; height: 40px; border-radius: 10px;
            background: var(--brand); color: #fff; border: none;
            display: grid; place-items: center;
            box-shadow: 0 4px 16px rgba(37,99,235,.35);
            opacity: 0; transform: translateY(12px);
            transition: opacity .25s, transform .25s;
            pointer-events: none; cursor: pointer;
        }
        #backTop.show { opacity: 1; transform: none; pointer-events: auto; }
        #backTop:hover { background: var(--brand-h); transform: translateY(-2px) !important; }

        /* â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
           FOOTER
        â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• */
        .footer {
            background: var(--surface); border-top: 1px solid var(--border); padding: 26px 0;
        }
        .footer-inner {
            width: min(1240px, calc(100% - 40px)); margin: 0 auto;
            display: flex; align-items: center; justify-content: space-between;
            gap: 16px; font-size: .8rem; color: var(--text3);
        }
        .footer-col-title {
            margin: 0;
            font-size: .72rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: .12em;
            color: var(--text);
        }
        .footer-partners {
            width: min(1240px, calc(100% - 40px));
            margin: 0 auto 22px;
            padding: 18px;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: var(--bg);
        }
        .footer-partners-head {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 14px;
        }
        .footer-partners-head span {
            display: block;
            margin-top: 6px;
            color: var(--text3);
            font-size: .78rem;
        }
        .footer-partners-head a {
            flex-shrink: 0;
            color: var(--brand);
            font-size: .78rem;
            font-weight: 900;
        }
        .footer-partner-list {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 10px;
        }
        .footer-partner-card {
            min-width: 0;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: var(--surface);
        }
        .footer-partner-mark {
            width: 38px;
            height: 38px;
            flex: 0 0 38px;
            border-radius: 8px;
            display: grid;
            place-items: center;
            background: color-mix(in srgb, var(--brand) 13%, transparent);
            border: 1px solid color-mix(in srgb, var(--brand) 24%, var(--border));
            color: var(--brand);
            font-size: .72rem;
            font-weight: 950;
        }
        .footer-partner-card strong {
            display: block;
            color: var(--text);
            font-size: .82rem;
            margin-bottom: 2px;
        }
        .footer-partner-card small {
            display: block;
            color: var(--text3);
            font-size: .72rem;
            line-height: 1.45;
        }

        /* â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
           RESPONSIVE
        â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• */
        @media (max-width: 1100px) {
            .product-layout { grid-template-columns: 1fr 320px; }
            .related-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 860px) {
            .product-layout { grid-template-columns: 1fr; gap: 28px; padding: 28px 0 60px; }
            .purchase-sidebar { position: static; }
        }
        @media (max-width: 640px) {
            .nav-inner { min-height: 56px; }
            .brand-logo-img { height: 28px; }
            .nav-right { gap: 5px; }
            .nav-btn span { display: none; }
            .nav-btn { padding: 0 8px; }
            .trust-badges { gap: 8px; }
            .trust-badge { font-size: .72rem; padding: 6px 10px; }
            .footer-inner { flex-direction: column; gap: 6px; text-align: center; }
            .footer-partners { width: calc(100% - 28px); padding: 16px; }
            .footer-partners-head { display: block; }
            .footer-partners-head a { display: inline-flex; margin-top: 10px; }
            .footer-partner-list { grid-template-columns: 1fr; }
            #backTop { bottom: 18px; right: 14px; width: 38px; height: 38px; }
            .related-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; }
            .price-value { font-size: 1.6rem; }
        }
        @media (max-width: 400px) {
            .related-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

@auth
@if ($post->status !== 'published')
<div class="preview-bar">
    Pratinjau - belum dipublikasikan (status: {{ $post->status }}).
    <a href="{{ route('dashboard.posts.edit', [$post->type, $post]) }}"><- Kembali ke editor</a>
</div>
@endif
@endauth

{{-- â•â• NAVBAR â•â• --}}
<header class="topbar" id="topbar">
    <div class="nav-inner">
        <a class="brand" href="{{ route('home') }}" aria-label="pahamIT">
            <img class="brand-logo-img" src="{{ asset('images/clean/logo_full_clean.png') }}" alt="pahamIT">
        </a>

        <div class="nav-right">
            <button class="icon-btn" id="themeToggle" aria-label="Ganti tema">
                <svg class="sun" width="15" height="15" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="4" stroke="currentColor" stroke-width="2"/><path d="M12 2v2m0 16v2M4.22 4.22l1.42 1.42m12.72 12.72 1.42 1.42M2 12h2m16 0h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                <svg class="moon" width="15" height="15" viewBox="0 0 24 24" fill="none"><path d="M21 12.79A9 9 0 1 1 11.21 3a7 7 0 0 0 9.79 9.79Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </button>
            <a class="nav-btn" href="{{ route('home') }}">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <span>Beranda</span>
            </a>
            @auth
            <a class="nav-btn edit-btn" href="{{ route('dashboard.posts.edit', [$post->type, $post]) }}">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <span>Edit</span>
            </a>
            @endauth
        </div>
    </div>
</header>

{{-- â•â• PRODUCT HEADER â•â• --}}
<div class="product-header">
    <div class="product-header-inner">
        <nav class="product-breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <svg width="9" height="9" viewBox="0 0 24 24" fill="none"><path d="m9 18 6-6-6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            <a href="{{ route('home') }}#toko">Toko IT</a>
            <svg width="9" height="9" viewBox="0 0 24 24" fill="none"><path d="m9 18 6-6-6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            <span>{{ Str::limit($post->title, 40) }}</span>
        </nav>

        <h1 class="product-header-title">{{ $post->title }}</h1>

        <div class="product-header-meta">
            @if($post->category)
            <span class="product-cat-badge">
                <svg width="9" height="9" viewBox="0 0 24 24" fill="none"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                {{ $post->category }}
            </span>
            <span class="meta-dot">-</span>
            @endif
            <span class="meta-sm">
                <svg width="11" height="11" viewBox="0 0 24 24" fill="none"><rect x="3" y="4" width="18" height="18" rx="2" stroke="currentColor" stroke-width="2"/><path d="M16 2v4M8 2v4M3 10h18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                {{ $post->published_at?->isoFormat('D MMMM Y') ?? 'Draft' }}
            </span>
            <span class="meta-dot">-</span>
            <span class="meta-sm">
                <svg width="11" height="11" viewBox="0 0 24 24" fill="none"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8Z" stroke="currentColor" stroke-width="2"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2"/></svg>
                {{ number_format($post->views_count) }} views
            </span>
        </div>
    </div>
</div>

{{-- â•â• MAIN PRODUCT LAYOUT â•â• --}}
<div class="product-layout">

    {{-- LEFT: content --}}
    <div class="product-body" id="productBody">

        {{-- Featured image --}}
        @if($post->featured_image_url)
            <img class="product-feat-img" src="{{ $post->featured_image_url }}" alt="{{ $post->title }}">
        @else
            <div class="product-feat-placeholder">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" style="opacity:.18;color:var(--text3);"><rect x="3" y="3" width="18" height="18" rx="2" stroke="currentColor" stroke-width="1.5"/><circle cx="8.5" cy="8.5" r="1.5" stroke="currentColor" stroke-width="1.5"/><path d="M21 15l-5-5L5 21" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
        @endif

        {{-- Trust badges --}}
        <div class="trust-badges">
            <div class="trust-badge">
                <div class="trust-badge-icon">
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
                Respon &lt; 1 Jam
            </div>
            <div class="trust-badge">
                <div class="trust-badge-icon">
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 1.27h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.75a16 16 0 0 0 6 6l1.27-.95a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
                Support Aktif
            </div>
            <div class="trust-badge">
                <div class="trust-badge-icon">
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
                Konsultasi Gratis
            </div>
        </div>

        {{-- Product description --}}
        <div class="section-label">Deskripsi Produk</div>
        <div class="article-content" id="articleContent">
            {!! \App\Helpers\ContentRenderer::render($post->content ?? '') !!}
        </div>

    </div>

    {{-- RIGHT: sticky purchase sidebar --}}
    <aside class="purchase-sidebar">

        <div class="purchase-card">
            <div class="purchase-title">{{ $post->title }}</div>

            @if($post->category)
            <div class="sb-cat-badge">
                <svg width="9" height="9" viewBox="0 0 24 24" fill="none"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                {{ $post->category }}
            </div>
            @endif

            <div class="price-display">
                <div class="price-label">Harga</div>
                @if($post->price && $post->price > 0)
                    <div class="price-value">Rp {{ number_format($post->price, 0, ',', '.') }}</div>
                @else
                    <div class="price-contact">Hubungi Kami</div>
                @endif
            </div>

            <div class="price-divider"></div>

            {{-- WhatsApp CTA --}}
            <a class="cta-wa"
               href="https://wa.me/6281250653005?text={{ urlencode('Halo, saya tertarik dengan: ' . $post->title . ' - ' . url()->current()) }}"
               target="_blank" rel="noreferrer">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                Hubungi via WhatsApp
            </a>

            {{-- Email CTA --}}
            <a class="cta-email"
               href="mailto:info@pahamit.com?subject={{ urlencode('Minat: ' . $post->title) }}&body={{ urlencode('Halo, saya tertarik dengan produk: ' . $post->title . "\n\n" . url()->current()) }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><rect x="2" y="4" width="20" height="16" rx="2" stroke="currentColor" stroke-width="2"/><path d="m2 7 10 7 10-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Kirim Email
            </a>

            {{-- Share row --}}
            <div class="sb-share">
                <span class="sb-share-label">Bagikan:</span>
                <a class="sb-share-btn tw"
                   href="https://twitter.com/intent/tweet?text={{ urlencode($post->title) }}&url={{ urlencode(url()->current()) }}"
                   target="_blank" rel="noreferrer">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.746l7.73-8.835L1.254 2.25H8.08l4.259 5.63 5.905-5.63Zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    Twitter
                </a>
                <button class="sb-share-btn" id="sbCopyBtn" onclick="sbCopyLink(this)">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none"><rect x="9" y="9" width="13" height="13" rx="2" stroke="currentColor" stroke-width="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    Salin Link
                </button>
            </div>

            {{-- Views --}}
            <div class="sb-views">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8Z" stroke="currentColor" stroke-width="2"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2"/></svg>
                {{ number_format($post->views_count) }} kali dilihat
            </div>
        </div>

    </aside>
</div>

{{-- â•â• RELATED PRODUCTS â•â• --}}
@if($related->count())
<div class="related-section">
    <div class="related-section-title">Produk &amp; Layanan Lainnya</div>
    <div class="related-grid">
        @foreach($related->take(4) as $rel)
        <a href="{{ route('post.toko', $rel->slug) }}" class="rel-card">
            @if($rel->featured_image_url)
                <img class="rel-card-img" src="{{ $rel->featured_image_url }}" alt="{{ $rel->title }}">
            @else
                <div class="rel-card-img-placeholder">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" style="opacity:.18;color:var(--text3);"><rect x="3" y="3" width="18" height="18" rx="2" stroke="currentColor" stroke-width="1.5"/><path d="M21 15l-5-5L5 21" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
            @endif
            <div class="rel-card-body">
                <div class="rel-card-cat">{{ $rel->category ?? 'Produk' }}</div>
                <div class="rel-card-title">{{ Str::limit($rel->title, 58) }}</div>
                @if($rel->price && $rel->price > 0)
                    <div class="rel-card-price">Rp {{ number_format($rel->price, 0, ',', '.') }}</div>
                @else
                    <div class="rel-card-price contact">Hubungi Kami</div>
                @endif
            </div>
        </a>
        @endforeach
    </div>
</div>
@endif

<footer class="footer">
    @include('site.partials.footer-partners')
    <div class="footer-inner">
        <div>
            &copy; {{ date('Y') }} <strong style="color:var(--text);">pahamIT</strong> - pahamit.com<br>
            <span>Indonesia &nbsp;-&nbsp; <a href="mailto:info@pahamit.com" style="color:var(--brand);">info@pahamit.com</a> &nbsp;-&nbsp; <a href="https://wa.me/6281250653005" target="_blank" rel="noreferrer" style="color:var(--brand);">081250653005</a></span>
        </div>
        <div>Bukan Sekadar Belajar.</div>
    </div>
</footer>

<button id="backTop" aria-label="Kembali ke atas" onclick="window.scrollTo({top:0,behavior:'smooth'})">
    <svg width="15" height="15" viewBox="0 0 24 24" fill="none"><path d="M18 15l-6-6-6 6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
</button>

<script>
(function () {
    'use strict';

    /* â”€â”€ Theme â”€â”€ */
    const html = document.documentElement;
    const saved = localStorage.getItem('pahamit-theme');
    if (saved) html.setAttribute('data-theme', saved);
    else if (window.matchMedia('(prefers-color-scheme: dark)').matches) html.setAttribute('data-theme', 'dark');
    document.getElementById('themeToggle').addEventListener('click', () => {
        const n = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
        html.setAttribute('data-theme', n);
        localStorage.setItem('pahamit-theme', n);
    });

    /* â”€â”€ Scroll state â”€â”€ */
    const topbar  = document.getElementById('topbar');
    const backBtn = document.getElementById('backTop');

    function onScroll() {
        const scrollY = window.scrollY;
        backBtn.classList.toggle('show', scrollY > 400);
        topbar.classList.toggle('scrolled', scrollY > 10);
    }
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();

    /* â”€â”€ Copy link (sidebar) â”€â”€ */
    window.sbCopyLink = function (btn) {
        navigator.clipboard.writeText(location.href).then(() => {
            const orig = btn.innerHTML;
            btn.innerHTML = '<svg width="11" height="11" viewBox="0 0 24 24" fill="none"><path d="M20 6 9 17l-5-5" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg> Tersalin!';
            btn.classList.add('copy-ok');
            setTimeout(() => { btn.innerHTML = orig; btn.classList.remove('copy-ok'); }, 2200);
        });
    };

    /* â”€â”€ Copy code blocks â”€â”€ */
    document.querySelectorAll('.code-copy-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const code = btn.closest('.code-block-wrap').querySelector('code').textContent;
            navigator.clipboard.writeText(code).then(() => {
                const orig = btn.innerHTML;
                btn.textContent = 'Tersalin!';
                setTimeout(() => btn.innerHTML = orig, 2000);
            });
        });
    });

})();
</script>
@include('site.partials.adroll')
</body>
</html>
