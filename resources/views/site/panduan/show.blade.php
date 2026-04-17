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
            --brand:       #10B981;
            --brand-h:     #059669;
            --accent:      #34D399;
            --green:       #10B981;
            --amber:       #F59E0B;
            --rose:        #F43F5E;
            --blue:        #2563EB;
            --bg:          #F5F7FA;
            --surface:     #FFFFFF;
            --surface2:    #F0F4F9;
            --border:      #E2E8F0;
            --text:        #0F172A;
            --text2:       #475569;
            --text3:       #94A3B8;
            --hero-bg:     #071a12;
            --code-bg:     #0F172A;
            --code-text:   #E2E8F0;
            --inline-bg:   #ECFDF5;
            --inline-text: #065F46;
            --radius:      12px;
            --shadow:      0 1px 3px rgba(15,23,42,.06), 0 4px 14px rgba(15,23,42,.05);
            --shadow-md:   0 4px 12px rgba(15,23,42,.08), 0 12px 36px rgba(15,23,42,.07);
            --font-scale:  1;
        }
        [data-theme="dark"] {
            --bg:          #060f0b;
            --surface:     #0c1812;
            --surface2:    #112118;
            --border:      #1a3026;
            --text:        #F1F5F9;
            --text2:       #94A3B8;
            --text3:       #475569;
            --hero-bg:     #030d07;
            --inline-bg:   #0d2b1e;
            --inline-text: #6ee7b7;
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

        /* ── Reading progress bar ── */
        #readProgress {
            position: fixed; top: 0; left: 0; z-index: 9999;
            height: 3px; width: 0%;
            background: linear-gradient(90deg, var(--brand), var(--accent));
            transition: width .08s linear;
            border-radius: 0 2px 2px 0;
        }

        /* ══════════════════════════════
           NAV
        ══════════════════════════════ */
        .topbar {
            position: sticky; top: 0; z-index: 100;
            background: rgba(255,255,255,.93);
            border-bottom: 1px solid var(--border);
            backdrop-filter: blur(24px);
            transition: background .22s, box-shadow .22s;
        }
        .topbar.scrolled { box-shadow: 0 2px 16px rgba(15,23,42,.08); }
        [data-theme="dark"] .topbar { background: rgba(6,15,11,.94); }
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

        .nav-center {
            flex: 1; display: flex; align-items: center; justify-content: center;
            gap: 4px; min-width: 0;
        }
        .reading-pct {
            font-size: .72rem; font-weight: 800; color: var(--brand);
            padding: 3px 9px; border-radius: 999px;
            background: rgba(16,185,129,.08); border: 1px solid rgba(16,185,129,.18);
            display: none; white-space: nowrap;
        }
        .reading-pct.show { display: inline-flex; align-items: center; gap: 4px; }

        .nav-right { display: flex; align-items: center; gap: 6px; flex-shrink: 0; }
        .nav-btn {
            height: 34px; padding: 0 12px; border-radius: 8px;
            font-size: .8rem; font-weight: 700;
            display: inline-flex; align-items: center; gap: 5px;
            border: 1px solid var(--border); background: var(--surface);
            color: var(--text2); transition: .15s; white-space: nowrap;
        }
        .nav-btn:hover { background: var(--surface2); color: var(--text); border-color: rgba(16,185,129,.25); }
        .nav-btn.edit-btn { background: rgba(16,185,129,.07); border-color: rgba(16,185,129,.22); color: var(--brand); }
        .nav-btn.edit-btn:hover { background: rgba(16,185,129,.13); }
        .icon-btn {
            width: 34px; height: 34px; border-radius: 8px;
            border: 1px solid var(--border); background: var(--surface);
            color: var(--text2); display: grid; place-items: center; transition: .15s;
            flex-shrink: 0;
        }
        .icon-btn:hover { background: var(--surface2); color: var(--brand); border-color: rgba(16,185,129,.25); }

        /* font-size controls */
        .font-ctrl {
            display: inline-flex; align-items: center;
            border: 1px solid var(--border); border-radius: 8px;
            overflow: hidden; background: var(--surface);
        }
        .font-ctrl button {
            width: 28px; height: 34px; border: none; background: none;
            color: var(--text2); font-weight: 800; font-size: .8rem;
            display: grid; place-items: center; transition: .15s;
        }
        .font-ctrl button:hover { background: var(--surface2); color: var(--brand); }
        .font-ctrl span {
            font-size: .7rem; font-weight: 700; color: var(--text3);
            padding: 0 4px; border-left: 1px solid var(--border); border-right: 1px solid var(--border);
            height: 34px; display: grid; place-items: center;
        }

        [data-theme="dark"] .sun { display: none; }
        [data-theme="light"] .moon { display: none; }

        /* ── Preview bar ── */
        .preview-bar {
            background: linear-gradient(90deg, #d97706, #b45309);
            color: #fff; font-size: .8rem; font-weight: 700;
            padding: 9px 20px; text-align: center;
        }
        .preview-bar a { text-decoration: underline; color: rgba(255,255,255,.88); }

        /* ══════════════════════════════
           HERO — tutorial dark
        ══════════════════════════════ */
        .post-hero {
            background: var(--hero-bg);
            color: #fff;
            padding: 36px 0 40px;
            position: relative; overflow: hidden;
        }
        .post-hero::before {
            content: ""; position: absolute; inset: 0; pointer-events: none;
            background:
                radial-gradient(ellipse 70% 100% at 0% 50%, rgba(16,185,129,.2), transparent 60%),
                radial-gradient(ellipse 50% 80% at 100% 0%, rgba(52,211,153,.1), transparent 60%);
        }
        .post-hero-inner {
            width: min(860px, calc(100% - 40px)); margin: 0 auto;
            position: relative; z-index: 1;
        }

        .post-breadcrumb {
            display: flex; align-items: center; gap: 6px; flex-wrap: wrap;
            font-size: .73rem; font-weight: 700; color: #3a5a48;
            margin-bottom: 16px;
        }
        .post-breadcrumb a { color: #5aaa80; transition: color .15s; }
        .post-breadcrumb a:hover { color: #fff; }

        /* Type label */
        .post-type-label {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 3px 11px; border-radius: 999px;
            font-size: .7rem; font-weight: 800; letter-spacing: .06em;
            background: rgba(16,185,129,.2); color: #6ee7b7;
            border: 1px solid rgba(16,185,129,.3); margin-bottom: 10px;
        }

        /* Difficulty / category badge */
        .difficulty-badge {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 3px 11px; border-radius: 999px;
            font-size: .7rem; font-weight: 800; letter-spacing: .05em;
            background: rgba(245,158,11,.15); color: #fbbf24;
            border: 1px solid rgba(245,158,11,.25); margin-bottom: 14px;
            margin-left: 8px;
        }

        .post-title {
            font-size: clamp(1.6rem, 3.8vw, 2.6rem);
            font-weight: 800; line-height: 1.12;
            letter-spacing: -.026em; margin-bottom: 20px;
        }

        .post-meta {
            display: flex; flex-wrap: wrap; gap: 8px;
            align-items: center;
        }
        .meta-item {
            display: inline-flex; align-items: center; gap: 5px;
            font-size: .76rem; font-weight: 700; color: #4a8a68;
        }
        .meta-sep { color: #2a4a38; font-size: .8rem; }

        /* ══════════════════════════════
           FEATURED IMAGE
        ══════════════════════════════ */
        .feat-img-wrap {
            width: min(860px, calc(100% - 40px)); margin: 0 auto;
            transform: translateY(-1px);
        }
        .feat-img-wrap img {
            width: 100%; aspect-ratio: 16/7;
            object-fit: cover; border-radius: var(--radius);
            display: block; box-shadow: var(--shadow-md);
        }
        .feat-img-placeholder {
            width: 100%; aspect-ratio: 21/6;
            background: linear-gradient(135deg, rgba(16,185,129,.1), rgba(52,211,153,.07));
            border-radius: var(--radius);
            display: grid; place-items: center;
            border: 1px solid var(--border);
        }

        /* ══════════════════════════════
           LAYOUT
        ══════════════════════════════ */
        .post-layout {
            width: min(1240px, calc(100% - 40px)); margin: 0 auto;
            display: grid; grid-template-columns: 1fr 296px;
            gap: 44px; align-items: start;
            padding: 40px 0 88px;
        }
        .post-body { min-width: 0; }

        /* Prerequisites box */
        .prereq-box {
            background: rgba(37,99,235,.05);
            border: 1px solid rgba(37,99,235,.15);
            border-left: 3px solid var(--blue, #2563EB);
            border-radius: 0 var(--radius) var(--radius) 0;
            padding: 18px 20px;
            margin-bottom: 2em;
        }
        [data-theme="dark"] .prereq-box {
            background: rgba(37,99,235,.08);
            border-color: rgba(37,99,235,.25);
        }
        .prereq-box-title {
            font-size: .72rem; font-weight: 900; letter-spacing: .1em;
            text-transform: uppercase; color: var(--blue, #2563EB);
            margin-bottom: 10px; display: flex; align-items: center; gap: 6px;
        }
        .prereq-box p {
            font-size: .95rem; color: var(--text2); line-height: 1.75; margin: 0;
        }

        /* Mobile TOC */
        .mobile-toc {
            display: none; margin-bottom: 2em;
            border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden;
        }
        .mobile-toc summary {
            padding: 12px 16px; font-size: .82rem; font-weight: 800;
            background: var(--surface2); color: var(--text2);
            display: flex; align-items: center; justify-content: space-between;
            cursor: pointer; list-style: none; user-select: none;
        }
        .mobile-toc summary::-webkit-details-marker { display: none; }
        .mobile-toc-list { padding: 8px 10px; display: grid; gap: 2px; background: var(--surface); }
        .mobile-toc-list a {
            display: block; padding: 7px 10px; border-radius: 7px;
            font-size: .82rem; font-weight: 600; color: var(--text2); transition: .15s;
        }
        .mobile-toc-list a:hover { background: var(--surface2); color: var(--brand); }
        .mobile-toc-list .toc-h3 { padding-left: 20px; font-size: .78rem; }

        /* ══════════════════════════════
           ARTICLE CONTENT — numbered steps
        ══════════════════════════════ */
        .article-content {
            font-size: calc(1.04rem * var(--font-scale));
            line-height: 1.88; color: var(--text);
            transition: font-size .2s;
            counter-reset: step-counter;
        }
        .article-content h2 {
            font-size: calc(1.46rem * var(--font-scale));
            font-weight: 800; letter-spacing: -.02em; line-height: 1.2;
            margin: 2.4em 0 .72em;
            padding: .6em 0 .5em .8em;
            border-bottom: 2px solid var(--border);
            border-left: 4px solid var(--brand);
            border-radius: 0 0 0 0;
            position: relative;
            counter-increment: step-counter;
            display: flex; align-items: baseline; gap: .5em;
        }
        .article-content h2::before {
            content: counter(step-counter);
            display: inline-flex; align-items: center; justify-content: center;
            min-width: 1.65rem; height: 1.65rem;
            background: var(--brand); color: #fff;
            border-radius: 50%;
            font-size: .72em; font-weight: 900; letter-spacing: 0;
            flex-shrink: 0; line-height: 1;
            box-shadow: 0 2px 8px rgba(16,185,129,.3);
        }
        .article-content h3 {
            font-size: calc(1.15rem * var(--font-scale));
            font-weight: 800; margin: 1.9em 0 .6em; letter-spacing: -.01em;
            color: var(--brand);
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
            text-decoration-color: rgba(16,185,129,.3); transition: text-decoration-color .15s;
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
        [data-theme="dark"] .article-content blockquote { background: rgba(16,185,129,.08); }
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
            padding: 9px 16px; background: #0e1f17;
            border-bottom: 1px solid rgba(255,255,255,.06);
        }
        .code-lang { font-size: .68rem; font-weight: 800; letter-spacing: .1em; text-transform: uppercase; color: #3a6a52; }
        .code-copy-btn {
            display: flex; align-items: center; gap: 4px;
            font-size: .7rem; font-weight: 700; color: #3a6a52;
            background: none; border: none; padding: 4px 8px; border-radius: 5px;
            transition: .15s; cursor: pointer;
        }
        .code-copy-btn:hover { color: #6ee7b7; background: rgba(255,255,255,.07); }
        .code-block-wrap pre { margin: 0; background: var(--code-bg); overflow-x: auto; padding: 20px; -webkit-overflow-scrolling: touch; }
        .code-block-wrap code {
            font-family: "Fira Code","Cascadia Code",ui-monospace,monospace;
            font-size: .86rem; line-height: 1.75;
            background: none !important; color: var(--code-text) !important;
            padding: 0 !important; border-radius: 0 !important; white-space: pre;
        }

        .content-image { margin: 2em 0; border-radius: var(--radius); overflow: hidden; box-shadow: var(--shadow); }
        .content-image img { width: 100%; }
        .content-image figcaption {
            padding: 8px 14px; background: var(--surface2);
            font-size: .78rem; color: var(--text3); text-align: center; font-style: italic;
        }

        /* ══════════════════════════════
           ARTICLE FOOTER
        ══════════════════════════════ */
        .article-footer { margin-top: 2.8em; }

        .tags-row { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 20px; }
        .tag {
            padding: 5px 13px; border-radius: 999px;
            background: var(--surface2); border: 1px solid var(--border);
            font-size: .76rem; font-weight: 700; color: var(--text2); transition: .15s;
        }
        .tag:hover { background: rgba(16,185,129,.08); border-color: rgba(16,185,129,.25); color: var(--brand); }

        /* Helpful poll */
        .helpful-box {
            margin: 20px 0; padding: 20px 22px;
            background: var(--surface); border: 1px solid var(--border);
            border-radius: var(--radius); text-align: center; box-shadow: var(--shadow);
        }
        .helpful-box p { font-size: .88rem; font-weight: 700; color: var(--text2); margin-bottom: 14px; }
        .helpful-btns { display: flex; justify-content: center; gap: 10px; }
        .helpful-btn {
            height: 36px; padding: 0 18px; border-radius: 999px;
            border: 1px solid var(--border); background: var(--surface2);
            color: var(--text2); font-size: .82rem; font-weight: 700;
            display: inline-flex; align-items: center; gap: 7px; transition: .2s; cursor: pointer;
        }
        .helpful-btn.yes:hover { background: rgba(16,185,129,.1); color: #059669; border-color: rgba(16,185,129,.3); }
        .helpful-btn.no:hover  { background: rgba(244,63,94,.08); color: var(--rose); border-color: rgba(244,63,94,.25); }
        .helpful-thanks {
            display: none; font-size: .84rem; font-weight: 700; color: var(--green);
            align-items: center; justify-content: center; gap: 6px;
        }
        .helpful-thanks.show { display: flex; }

        /* Share row */
        .share-row {
            display: flex; align-items: center; justify-content: space-between;
            flex-wrap: wrap; gap: 12px; padding: 18px 0;
            border-top: 1px solid var(--border);
        }
        .share-label { font-size: .73rem; font-weight: 800; color: var(--text3); text-transform: uppercase; letter-spacing: .08em; }
        .share-btns { display: flex; gap: 8px; flex-wrap: wrap; }
        .share-btn {
            height: 34px; padding: 0 13px; border-radius: 8px;
            border: 1px solid var(--border); background: var(--surface);
            color: var(--text2); font-size: .78rem; font-weight: 700;
            display: inline-flex; align-items: center; gap: 5px; transition: .15s; cursor: pointer;
        }
        .share-btn:hover      { background: var(--surface2); color: var(--text); }
        .share-btn.tw:hover   { background: rgba(29,161,242,.07); color: #1DA1F2; border-color: rgba(29,161,242,.3); }
        .share-btn.wa:hover   { background: rgba(37,211,102,.07); color: #25D366; border-color: rgba(37,211,102,.3); }
        .share-btn.copy-ok    { background: rgba(16,185,129,.08); color: #10B981; border-color: rgba(16,185,129,.3); }

        /* ══════════════════════════════
           SIDEBAR
        ══════════════════════════════ */
        .post-sidebar { position: sticky; top: 76px; display: flex; flex-direction: column; gap: 12px; }
        .sidebar-card {
            background: var(--surface); border: 1px solid var(--border);
            border-radius: var(--radius); padding: 16px; box-shadow: var(--shadow);
        }
        .sb-title {
            font-size: .68rem; font-weight: 900; letter-spacing: .1em;
            text-transform: uppercase; color: var(--text3); margin-bottom: 12px;
            display: flex; align-items: center; gap: 7px;
        }
        .sb-title::before {
            content: ""; width: 12px; height: 2px; border-radius: 2px;
            background: var(--brand); display: inline-block; flex-shrink: 0;
        }

        /* ── Step TOC with checkboxes ── */
        .step-toc-list { list-style: none; display: grid; gap: 2px; }
        .step-toc-item {
            display: flex; align-items: flex-start; gap: 8px;
            padding: 5px 0;
        }
        .step-checkbox {
            width: 16px; height: 16px; flex-shrink: 0;
            border-radius: 4px; border: 2px solid var(--border);
            background: var(--surface); cursor: pointer;
            appearance: none; -webkit-appearance: none;
            transition: .18s; margin-top: 2px;
        }
        .step-checkbox:checked {
            background: var(--brand); border-color: var(--brand);
            background-image: url("data:image/svg+xml,%3Csvg width='10' height='10' viewBox='0 0 10 10' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M2 5l2.5 2.5L8 3' stroke='white' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat; background-position: center;
        }
        .step-toc-link {
            font-size: .8rem; font-weight: 600; color: var(--text2);
            line-height: 1.4; transition: color .15s; flex: 1;
        }
        .step-toc-link:hover { color: var(--brand); }
        .step-toc-link.active { color: var(--brand); font-weight: 800; }
        .step-toc-link.done { color: var(--text3); text-decoration: line-through; }
        .step-toc-h3 { padding-left: 20px; font-size: .76rem; }

        /* Reading progress ring */
        .reading-ring-wrap { display: flex; align-items: center; gap: 12px; }
        .reading-ring { width: 44px; height: 44px; flex-shrink: 0; position: relative; }
        .reading-ring svg { transform: rotate(-90deg); }
        .reading-ring-bg  { fill: none; stroke: var(--border); stroke-width: 4; }
        .reading-ring-bar { fill: none; stroke: var(--brand); stroke-width: 4; stroke-linecap: round;
            stroke-dasharray: 113; stroke-dashoffset: 113; transition: stroke-dashoffset .2s linear; }
        .reading-ring-pct {
            position: absolute; inset: 0; display: grid; place-items: center;
            font-size: .62rem; font-weight: 900; color: var(--brand);
        }
        .reading-ring-text { font-size: .79rem; color: var(--text2); line-height: 1.4; }
        .reading-ring-text strong { display: block; font-weight: 800; color: var(--text); font-size: .82rem; }

        /* Related tutorials */
        .related-item {
            display: flex; gap: 10px; align-items: flex-start;
            padding: 9px 0; border-bottom: 1px solid var(--border); transition: .15s;
        }
        .related-item:last-child { border: none; padding-bottom: 0; }
        .related-item:hover .related-title { color: var(--brand); }
        .related-thumb {
            width: 50px; height: 42px; flex-shrink: 0;
            border-radius: 7px; overflow: hidden; background: var(--surface2); object-fit: cover;
        }
        .related-title { font-size: .79rem; font-weight: 700; line-height: 1.38; }
        .related-meta  { font-size: .7rem; color: var(--text3); margin-top: 3px; }

        /* ══════════════════════════════
           RELATED GRID (bottom)
        ══════════════════════════════ */
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
            background: linear-gradient(135deg, rgba(16,185,129,.1), rgba(52,211,153,.07));
        }
        .rel-card-img-placeholder {
            aspect-ratio: 16/9; display: grid; place-items: center;
            background: linear-gradient(135deg, rgba(16,185,129,.08), rgba(52,211,153,.05));
        }
        .rel-card-body { padding: 14px; }
        .rel-card-cat {
            font-size: .67rem; font-weight: 800; letter-spacing: .08em;
            text-transform: uppercase; color: var(--brand); margin-bottom: 6px;
        }
        .rel-card-title {
            font-size: .88rem; font-weight: 700; line-height: 1.4;
            color: var(--text); margin-bottom: 8px; transition: color .15s;
        }
        .rel-card:hover .rel-card-title { color: var(--brand); }
        .rel-card-meta { font-size: .7rem; color: var(--text3); }

        /* ══════════════════════════════
           FLOATING SHARE
        ══════════════════════════════ */
        .float-share {
            position: fixed; left: max(12px, calc(50vw - 660px));
            top: 50%; transform: translateY(-50%);
            display: flex; flex-direction: column; gap: 8px;
            z-index: 40; opacity: 0; pointer-events: none; transition: opacity .3s;
        }
        .float-share.show { opacity: 1; pointer-events: auto; }
        .float-btn {
            width: 40px; height: 40px; border-radius: 10px;
            border: 1px solid var(--border); background: var(--surface);
            color: var(--text2); display: grid; place-items: center;
            box-shadow: var(--shadow); transition: .18s; cursor: pointer; position: relative;
        }
        .float-btn:hover { transform: translateX(3px); }
        .float-btn.tw:hover  { background: #1DA1F2; color: #fff; border-color: #1DA1F2; }
        .float-btn.wa:hover  { background: #25D366; color: #fff; border-color: #25D366; }
        .float-btn.cp:hover  { background: var(--brand); color: #fff; border-color: var(--brand); }
        .float-btn.cp.copied { background: var(--brand); color: #fff; border-color: var(--brand); }
        .float-btn-tip {
            position: absolute; left: calc(100% + 8px); top: 50%; transform: translateY(-50%);
            background: var(--text); color: #fff; font-size: .7rem; font-weight: 700;
            padding: 4px 8px; border-radius: 6px; white-space: nowrap;
            opacity: 0; pointer-events: none; transition: opacity .15s;
        }
        .float-btn:hover .float-btn-tip { opacity: 1; }

        /* ══════════════════════════════
           BACK TO TOP
        ══════════════════════════════ */
        #backTop {
            position: fixed; bottom: 24px; right: 20px; z-index: 40;
            width: 40px; height: 40px; border-radius: 10px;
            background: var(--brand); color: #fff; border: none;
            display: grid; place-items: center;
            box-shadow: 0 4px 16px rgba(16,185,129,.35);
            opacity: 0; transform: translateY(12px);
            transition: opacity .25s, transform .25s;
            pointer-events: none; cursor: pointer;
        }
        #backTop.show { opacity: 1; transform: none; pointer-events: auto; }
        #backTop:hover { background: var(--brand-h); transform: translateY(-2px) !important; }

        /* ══════════════════════════════
           FOOTER
        ══════════════════════════════ */
        .footer {
            background: var(--surface); border-top: 1px solid var(--border); padding: 26px 0;
        }
        .footer-inner {
            width: min(1240px, calc(100% - 40px)); margin: 0 auto;
            display: flex; align-items: center; justify-content: space-between;
            gap: 16px; font-size: .8rem; color: var(--text3);
        }

        /* ══════════════════════════════
           RESPONSIVE
        ══════════════════════════════ */
        @media (max-width: 1100px) {
            .related-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 960px) {
            .post-layout { grid-template-columns: 1fr; gap: 28px; padding: 32px 0 64px; }
            .post-sidebar { position: static; }
            .mobile-toc { display: block; }
            .float-share { display: none; }
        }
        @media (max-width: 640px) {
            .nav-inner { min-height: 56px; }
            .brand-logo-img { height: 28px; }
            .nav-right { gap: 5px; }
            .nav-btn span { display: none; }
            .nav-btn { padding: 0 8px; }
            .nav-center { display: none; }
            .font-ctrl { display: none; }
            .post-hero { padding: 28px 0 32px; }
            .post-hero-inner { width: calc(100% - 28px); }
            .post-title { font-size: 1.38rem; }
            .post-meta { gap: 6px; }
            .feat-img-wrap { width: calc(100% - 28px); }
            .feat-img-wrap img { aspect-ratio: 16/9; }
            .post-layout { padding: 20px 0 52px; gap: 20px; }
            .article-content { font-size: .96rem; line-height: 1.8; }
            .article-content h2 { font-size: 1.2rem; }
            .article-content h3 { font-size: 1.05rem; }
            .code-block-wrap pre { padding: 14px; }
            .share-row { flex-direction: column; align-items: flex-start; }
            .footer-inner { flex-direction: column; gap: 6px; text-align: center; }
            #backTop { bottom: 18px; right: 14px; width: 38px; height: 38px; }
            .related-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; }
        }
        @media (max-width: 400px) {
            .related-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<div id="readProgress"></div>

@auth
@if ($post->status !== 'published')
<div class="preview-bar">
    Pratinjau — belum dipublikasikan (status: {{ $post->status }}).
    <a href="{{ route('dashboard.posts.edit', [$post->type, $post]) }}">← Kembali ke editor</a>
</div>
@endif
@endauth

{{-- ══ NAVBAR ══ --}}
<header class="topbar" id="topbar">
    <div class="nav-inner">
        <a class="brand" href="{{ route('home') }}" aria-label="pahamIT">
            <img class="brand-logo-img" src="{{ asset('images/clean/logo_full_clean.png') }}" alt="pahamIT">
        </a>

        <div class="nav-center">
            <span class="reading-pct" id="readingPct">
                <svg width="10" height="10" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2.5"/><path d="M12 7v5l3 3" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/></svg>
                <span id="readingPctNum">0%</span> dibaca
            </span>
        </div>

        <div class="nav-right">
            <div class="font-ctrl" title="Ukuran font">
                <button onclick="adjustFont(-1)" aria-label="Perkecil font">A−</button>
                <span id="fontLabel">M</span>
                <button onclick="adjustFont(1)" aria-label="Perbesar font">A+</button>
            </div>
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

{{-- ══ HERO ══ --}}
<div class="post-hero">
    <div class="post-hero-inner">
        <nav class="post-breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <svg width="9" height="9" viewBox="0 0 24 24" fill="none"><path d="m9 18 6-6-6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            <a href="{{ route('home') }}#panduan">Panduan</a>
            <svg width="9" height="9" viewBox="0 0 24 24" fill="none"><path d="m9 18 6-6-6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            <span style="color:#3a5a48;">{{ Str::limit($post->title, 40) }}</span>
        </nav>

        <div style="display:flex;align-items:center;flex-wrap:wrap;gap:6px;margin-bottom:14px;">
            <span class="post-type-label">
                <svg width="11" height="11" viewBox="0 0 24 24" fill="none"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2V3ZM22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7V3Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Panduan
            </span>
            @if($post->category)
            <span class="difficulty-badge">
                <svg width="10" height="10" viewBox="0 0 24 24" fill="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                {{ $post->category }}
            </span>
            @endif
        </div>

        <h1 class="post-title">{{ $post->title }}</h1>

        <div class="post-meta">
            <span class="meta-item">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2M12 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                Tim pahamIT
            </span>
            <span class="meta-sep">·</span>
            <span class="meta-item">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none"><rect x="3" y="4" width="18" height="18" rx="2" stroke="currentColor" stroke-width="2"/><path d="M16 2v4M8 2v4M3 10h18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                {{ $post->published_at?->isoFormat('D MMMM Y') ?? 'Draft' }}
            </span>
            <span class="meta-sep">·</span>
            <span class="meta-item">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2"/><path d="M12 7v5l3 3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                {{ max(1, (int)(str_word_count(strip_tags($post->content)) / 200)) }} menit baca
            </span>
            <span class="meta-sep">·</span>
            <span class="meta-item">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8Z" stroke="currentColor" stroke-width="2"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2"/></svg>
                {{ number_format($post->views_count) }} views
            </span>
        </div>
    </div>
</div>

{{-- ══ FEATURED IMAGE ══ --}}
<div class="feat-img-wrap" style="margin-top:28px;">
    @if($post->featured_image_url)
        <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}">
    @else
        <div class="feat-img-placeholder">
            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" style="opacity:.2;color:var(--text3);"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2V3ZM22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7V3Z" stroke="currentColor" stroke-width="1.5"/></svg>
        </div>
    @endif
</div>

{{-- ══ FLOATING SHARE ══ --}}
<div class="float-share" id="floatShare">
    <a class="float-btn tw"
       href="https://twitter.com/intent/tweet?text={{ urlencode($post->title) }}&url={{ urlencode(url()->current()) }}"
       target="_blank" rel="noreferrer" aria-label="Share ke Twitter">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.746l7.73-8.835L1.254 2.25H8.08l4.259 5.63 5.905-5.63Zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
        <span class="float-btn-tip">Twitter / X</span>
    </a>
    <a class="float-btn wa"
       href="https://wa.me/?text={{ urlencode($post->title . ' ' . url()->current()) }}"
       target="_blank" rel="noreferrer" aria-label="Share ke WhatsApp">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
        <span class="float-btn-tip">WhatsApp</span>
    </a>
    <button class="float-btn cp" id="floatCopy" onclick="floatCopyLink()" aria-label="Salin link">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none"><rect x="9" y="9" width="13" height="13" rx="2" stroke="currentColor" stroke-width="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
        <span class="float-btn-tip">Salin link</span>
    </button>
</div>

{{-- ══ MAIN LAYOUT ══ --}}
<div class="post-layout">

    <article class="post-body" id="articleBody">

        @if($post->excerpt)
        <div class="prereq-box">
            <div class="prereq-box-title">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none"><path d="M9 11l3 3L22 4M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Apa yang kamu butuhkan
            </div>
            <p>{{ $post->excerpt }}</p>
        </div>
        @endif

        <details class="mobile-toc" id="mobileTocWrap" style="display:none;">
            <summary>
                <span>Langkah-Langkah</span>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </summary>
            <div class="mobile-toc-list" id="mobileTocList"></div>
        </details>

        <div class="article-content" id="articleContent">
            {!! \App\Helpers\ContentRenderer::render($post->content ?? '') !!}
        </div>

        <div class="article-footer">
            <div class="tags-row">
                @if($post->category)
                <span class="tag">{{ $post->category }}</span>
                @endif
                <span class="tag">Tutorial</span>
                <span class="tag">pahamIT</span>
            </div>

            <div class="helpful-box" id="helpfulBox">
                <p>Apakah panduan ini membantu?</p>
                <div class="helpful-btns" id="helpfulBtns">
                    <button class="helpful-btn yes" onclick="vote('yes')">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3H14ZM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        Ya, berhasil!
                    </button>
                    <button class="helpful-btn no" onclick="vote('no')">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none"><path d="M10 15v4a3 3 0 0 0 3 3l4-9V2H5.72a2 2 0 0 0-2 1.7l-1.38 9a2 2 0 0 0 2 2.3H10ZM17 2h2.67A2.31 2.31 0 0 1 22 4v7a2.31 2.31 0 0 1-2.33 2H17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        Ada yang kurang jelas
                    </button>
                </div>
                <div class="helpful-thanks" id="helpfulThanks">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="m9 11 3 3L22 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Terima kasih atas masukan Anda!
                </div>
            </div>

            <div class="share-row">
                <span class="share-label">Bagikan</span>
                <div class="share-btns">
                    <a class="share-btn tw"
                       href="https://twitter.com/intent/tweet?text={{ urlencode($post->title) }}&url={{ urlencode(url()->current()) }}"
                       target="_blank" rel="noreferrer">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.746l7.73-8.835L1.254 2.25H8.08l4.259 5.63 5.905-5.63Zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        Twitter
                    </a>
                    <a class="share-btn wa"
                       href="https://wa.me/?text={{ urlencode($post->title . ' – ' . url()->current()) }}"
                       target="_blank" rel="noreferrer">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                        WhatsApp
                    </a>
                    <button class="share-btn" id="copyBtn" onclick="copyLink(this)">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none"><rect x="9" y="9" width="13" height="13" rx="2" stroke="currentColor" stroke-width="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                        Salin Link
                    </button>
                </div>
            </div>
        </div>
    </article>

    {{-- ══ SIDEBAR ══ --}}
    <aside class="post-sidebar">

        {{-- Reading progress ring --}}
        <div class="sidebar-card" id="readingCard">
            <div class="sb-title">Progress Baca</div>
            <div class="reading-ring-wrap">
                <div class="reading-ring">
                    <svg width="44" height="44" viewBox="0 0 44 44">
                        <circle class="reading-ring-bg" cx="22" cy="22" r="18"/>
                        <circle class="reading-ring-bar" id="ringBar" cx="22" cy="22" r="18"/>
                    </svg>
                    <div class="reading-ring-pct" id="ringPct">0%</div>
                </div>
                <div class="reading-ring-text">
                    <strong id="ringTimeLeft">{{ max(1, (int)(str_word_count(strip_tags($post->content ?? '')) / 200)) }} menit</strong>
                    estimasi waktu baca
                </div>
            </div>
        </div>

        {{-- Step TOC with checkboxes --}}
        <div class="sidebar-card" id="tocCard" style="display:none;">
            <div class="sb-title">Langkah-Langkah</div>
            <ul class="step-toc-list" id="tocList"></ul>
        </div>

        {{-- Related in sidebar --}}
        @if($related->count())
        <div class="sidebar-card">
            <div class="sb-title">Tutorial Terkait</div>
            @foreach($related->take(3) as $rel)
            @php
                $relRoute = route('post.panduan', $rel->slug);
            @endphp
            <a href="{{ $relRoute }}" class="related-item">
                @if($rel->featured_image_url)
                    <img class="related-thumb" src="{{ $rel->featured_image_url }}" alt="{{ $rel->title }}">
                @else
                    <div class="related-thumb" style="background:linear-gradient(135deg,rgba(16,185,129,.1),rgba(52,211,153,.07));display:grid;place-items:center;">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" style="opacity:.25;"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2V3Z" stroke="currentColor" stroke-width="2"/></svg>
                    </div>
                @endif
                <div>
                    <div class="related-title">{{ Str::limit($rel->title, 52) }}</div>
                    <div class="related-meta">{{ $rel->category ?? 'Tutorial' }} · {{ $rel->published_at?->diffForHumans() }}</div>
                </div>
            </a>
            @endforeach
        </div>
        @endif

    </aside>
</div>

{{-- ══ RELATED GRID (bottom) ══ --}}
@if($related->count())
<div class="related-section">
    <div class="related-section-title">Tutorial Lainnya</div>
    <div class="related-grid">
        @foreach($related->take(4) as $rel)
        <a href="{{ route('post.panduan', $rel->slug) }}" class="rel-card">
            @if($rel->featured_image_url)
                <img class="rel-card-img" src="{{ $rel->featured_image_url }}" alt="{{ $rel->title }}">
            @else
                <div class="rel-card-img-placeholder">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" style="opacity:.2;color:var(--text3);"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2V3ZM22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7V3Z" stroke="currentColor" stroke-width="1.5"/></svg>
                </div>
            @endif
            <div class="rel-card-body">
                <div class="rel-card-cat">{{ $rel->category ?? 'Tutorial' }}</div>
                <div class="rel-card-title">{{ Str::limit($rel->title, 60) }}</div>
                <div class="rel-card-meta">{{ $rel->published_at?->diffForHumans() }}</div>
            </div>
        </a>
        @endforeach
    </div>
</div>
@endif

<footer class="footer">
    <div class="footer-inner">
        <div>
            © {{ date('Y') }} <strong style="color:var(--text);">pahamIT</strong> · pahamit.com<br>
            <span>Jakarta Selatan &nbsp;·&nbsp; <a href="mailto:info@pahamit.com" style="color:var(--brand);">info@pahamit.com</a></span>
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

    const SLUG = '{{ $post->slug }}';

    /* ── Theme ── */
    const html = document.documentElement;
    const saved = localStorage.getItem('pahamit-theme');
    if (saved) html.setAttribute('data-theme', saved);
    else if (window.matchMedia('(prefers-color-scheme: dark)').matches) html.setAttribute('data-theme', 'dark');
    document.getElementById('themeToggle').addEventListener('click', () => {
        const n = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
        html.setAttribute('data-theme', n);
        localStorage.setItem('pahamit-theme', n);
    });

    /* ── Font size ── */
    const fontSteps  = [.88, 1, 1.1, 1.22];
    const fontLabels = ['S', 'M', 'L', 'XL'];
    let fontIdx = parseInt(localStorage.getItem('pahamit-font') || '1', 10);

    function applyFont() {
        html.style.setProperty('--font-scale', fontSteps[fontIdx]);
        document.getElementById('fontLabel').textContent = fontLabels[fontIdx];
    }
    window.adjustFont = function (dir) {
        fontIdx = Math.min(3, Math.max(0, fontIdx + dir));
        localStorage.setItem('pahamit-font', fontIdx);
        applyFont();
    };
    applyFont();

    /* ── Scroll state ── */
    const topbar      = document.getElementById('topbar');
    const readBar     = document.getElementById('readProgress');
    const backBtn     = document.getElementById('backTop');
    const floatShare  = document.getElementById('floatShare');
    const readingPct  = document.getElementById('readingPct');
    const readingNum  = document.getElementById('readingPctNum');
    const ringBar     = document.getElementById('ringBar');
    const ringPct     = document.getElementById('ringPct');
    const ringTimeEl  = document.getElementById('ringTimeLeft');
    const articleBody = document.getElementById('articleBody');

    const totalWords    = {{ max(1, str_word_count(strip_tags($post->content ?? ''))) }};
    const totalMinutes  = Math.max(1, Math.round(totalWords / 200));
    const circumference = 2 * Math.PI * 18;

    function onScroll() {
        const scrollY = window.scrollY;
        const rect    = articleBody.getBoundingClientRect();
        const total   = articleBody.offsetHeight - window.innerHeight;
        const done    = Math.max(0, -rect.top);
        const pct     = total > 0 ? Math.min(100, Math.round((done / total) * 100)) : 0;

        readBar.style.width = pct + '%';

        if (scrollY > 300) {
            readingPct.classList.add('show');
            readingNum.textContent = pct + '%';
        } else {
            readingPct.classList.remove('show');
        }

        const offset = circumference - (pct / 100) * circumference;
        ringBar.style.strokeDashoffset = offset;
        ringPct.textContent = pct + '%';
        const minsLeft = Math.max(0, Math.round(totalMinutes * (1 - pct / 100)));
        ringTimeEl.textContent = minsLeft > 0 ? minsLeft + ' menit' : 'Selesai ✓';

        backBtn.classList.toggle('show', scrollY > 450);
        floatShare.classList.toggle('show', scrollY > 500);
        topbar.classList.toggle('scrolled', scrollY > 10);
    }
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();

    /* ── Copy link ── */
    window.copyLink = function (btn) {
        navigator.clipboard.writeText(location.href).then(() => {
            const orig = btn.innerHTML;
            btn.innerHTML = '<svg width="12" height="12" viewBox="0 0 24 24" fill="none"><path d="M20 6 9 17l-5-5" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg> Tersalin!';
            btn.classList.add('copy-ok');
            setTimeout(() => { btn.innerHTML = orig; btn.classList.remove('copy-ok'); }, 2200);
        });
    };
    window.floatCopyLink = function () {
        navigator.clipboard.writeText(location.href).then(() => {
            const btn = document.getElementById('floatCopy');
            btn.classList.add('copied');
            setTimeout(() => btn.classList.remove('copied'), 2000);
        });
    };

    /* ── Copy code blocks ── */
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

    /* ── Helpful poll ── */
    window.vote = function (answer) {
        document.getElementById('helpfulBtns').style.display = 'none';
        document.getElementById('helpfulThanks').classList.add('show');
    };

    /* ── Step TOC with checkbox state (localStorage) ── */
    (function buildStepToc() {
        const headings = document.querySelectorAll('.article-content h2, .article-content h3');
        if (headings.length < 2) return;

        const card = document.getElementById('tocCard');
        const list = document.getElementById('tocList');
        card.style.display = 'block';

        const storageKey = 'pahamit-steps-' + SLUG;
        let checkedSteps = {};
        try { checkedSteps = JSON.parse(localStorage.getItem(storageKey) || '{}'); } catch(e) {}

        headings.forEach((h, i) => {
            if (!h.id) h.id = 'h-' + i;

            const li   = document.createElement('li');
            li.classList.add('step-toc-item');

            const cb = document.createElement('input');
            cb.type = 'checkbox';
            cb.classList.add('step-checkbox');
            cb.id = 'cb-' + h.id;
            cb.checked = !!checkedSteps[h.id];

            const a = document.createElement('a');
            a.href = '#' + h.id;
            a.classList.add('step-toc-link');
            if (h.tagName === 'H3') a.classList.add('step-toc-h3');
            a.textContent = h.textContent;
            if (cb.checked) a.classList.add('done');

            cb.addEventListener('change', () => {
                checkedSteps[h.id] = cb.checked;
                try { localStorage.setItem(storageKey, JSON.stringify(checkedSteps)); } catch(e) {}
                a.classList.toggle('done', cb.checked);
            });

            li.appendChild(cb);
            li.appendChild(a);
            list.appendChild(li);
        });

        /* Mobile TOC */
        const mWrap = document.getElementById('mobileTocWrap');
        const mList = document.getElementById('mobileTocList');
        mWrap.style.display = 'block';
        headings.forEach(h => {
            const a = document.createElement('a');
            a.href = '#' + h.id;
            a.textContent = h.textContent;
            if (h.tagName === 'H3') a.classList.add('toc-h3');
            mList.appendChild(a);
        });

        /* Active heading via IntersectionObserver */
        const obs = new IntersectionObserver(entries => {
            entries.forEach(e => {
                const link = list.querySelector(`.step-toc-link[href="#${e.target.id}"]`);
                if (link) link.classList.toggle('active', e.isIntersecting);
            });
        }, { rootMargin: '-18% 0px -72% 0px' });
        headings.forEach(h => obs.observe(h));
    })();
})();
</script>
@include('site.partials.adroll')
</body>
</html>
