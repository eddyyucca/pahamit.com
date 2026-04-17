<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $post->excerpt ?: Str::limit(strip_tags($post->title), 155) }}">
    <title>{{ $post->title }} - Pahamit</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <style>
        :root {
            --brand:      #4F46E5;
            --accent:     #06B6D4;
            --green:      #10B981;
            --amber:      #F59E0B;
            --rose:       #F43F5E;
            --bg:         #F8FAFC;
            --surface:    #FFFFFF;
            --surface2:   #F1F5F9;
            --border:     #E2E8F0;
            --text:       #0F172A;
            --text2:      #475569;
            --text3:      #94A3B8;
            --code-bg:    #0F172A;
            --code-text:  #E2E8F0;
            --inline-bg:  #EEF2FF;
            --inline-text:#4338CA;
            --radius:     10px;
        }
        [data-theme="dark"] {
            --bg:         #0B0F1A;
            --surface:    #111827;
            --surface2:   #1E293B;
            --border:     #1E293B;
            --text:       #F1F5F9;
            --text2:      #94A3B8;
            --text3:      #475569;
            --inline-bg:  #1E1B4B;
            --inline-text:#A5B4FC;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body {
            font-family: "Plus Jakarta Sans", ui-sans-serif, system-ui, sans-serif;
            background: var(--bg); color: var(--text);
            line-height: 1.7; transition: background .22s, color .22s;
        }
        a { color: inherit; text-decoration: none; }
        img { display: block; max-width: 100%; }
        button { font: inherit; cursor: pointer; }

        /* ── Reading progress bar ── */
        #readProgress {
            position: fixed; top: 0; left: 0; z-index: 999;
            height: 3px; width: 0%;
            background: linear-gradient(90deg, var(--brand), var(--accent));
            transition: width .1s linear;
        }

        /* ── Nav ── */
        .topbar {
            position: sticky; top: 0; z-index: 50;
            background: rgba(255,255,255,.9);
            border-bottom: 1px solid var(--border);
            backdrop-filter: blur(20px);
            transition: background .22s;
        }
        [data-theme="dark"] .topbar { background: rgba(11,15,26,.92); }
        .nav-inner {
            width: min(1200px, calc(100% - 40px)); margin: 0 auto;
            display: flex; align-items: center;
            justify-content: space-between; gap: 16px;
            min-height: 64px;
        }
        .brand { display: flex; align-items: center; flex-shrink: 0; }
        .brand-logo-img { height: 34px; width: auto; transition: filter .22s; }
        [data-theme="dark"] .brand-logo-img { filter: brightness(0) invert(1); }

        .nav-right { display: flex; align-items: center; gap: 8px; }
        .nav-btn {
            height: 36px; padding: 0 14px; border-radius: 8px;
            font-size: .83rem; font-weight: 700;
            display: inline-flex; align-items: center; gap: 6px;
            border: 1px solid var(--border); background: var(--surface);
            color: var(--text2); transition: .15s;
        }
        .nav-btn:hover { background: var(--surface2); color: var(--text); }
        .theme-btn {
            width: 36px; height: 36px; border-radius: 8px;
            border: 1px solid var(--border); background: var(--surface);
            color: var(--text2); display: grid; place-items: center; transition: .15s;
        }
        .theme-btn:hover { background: var(--surface2); }
        [data-theme="dark"] .sun { display: none; }
        [data-theme="light"] .moon { display: none; }

        /* ── Preview bar ── */
        .preview-bar {
            background: linear-gradient(90deg, #F59E0B, #D97706);
            color: #fff; font-size: .83rem; font-weight: 700;
            padding: 10px 20px; text-align: center;
        }
        .preview-bar a { text-decoration: underline; color: #fff; }

        /* ── Post hero ── */
        .post-hero {
            background: linear-gradient(135deg, #0F172A 0%, #1a1040 100%);
            color: #fff; padding: 56px 0 0;
            position: relative; overflow: hidden;
        }
        .post-hero::before {
            content: ""; position: absolute; inset: 0; pointer-events: none;
            background:
                radial-gradient(ellipse 70% 60% at 20% 50%, rgba(79,70,229,.28), transparent 65%),
                radial-gradient(ellipse 50% 50% at 80% 20%, rgba(6,182,212,.15), transparent 65%);
        }
        .post-hero-inner {
            width: min(860px, calc(100% - 40px)); margin: 0 auto;
            position: relative;
        }
        .post-breadcrumb {
            display: flex; align-items: center; gap: 7px;
            font-size: .76rem; font-weight: 600; color: #64748B;
            margin-bottom: 18px; flex-wrap: wrap;
        }
        .post-breadcrumb a { color: #A5B4FC; transition: color .15s; }
        .post-breadcrumb a:hover { color: #fff; }
        .post-cat {
            display: inline-flex; align-items: center;
            padding: 4px 12px; border-radius: 99px;
            font-size: .73rem; font-weight: 700;
            background: rgba(79,70,229,.25); color: #A5B4FC;
            border: 1px solid rgba(79,70,229,.3); margin-bottom: 14px;
        }
        .post-title {
            font-size: clamp(1.75rem, 4vw, 2.8rem);
            font-weight: 800; line-height: 1.1;
            letter-spacing: -.025em; margin-bottom: 20px;
        }
        .post-meta {
            display: flex; flex-wrap: wrap; gap: 14px;
            font-size: .8rem; font-weight: 600; color: #64748B;
            margin-bottom: 32px; align-items: center;
        }
        .post-meta span { display: flex; align-items: center; gap: 5px; }
        .meta-sep { color: #334155; }
        .post-feat-img {
            width: 100%; aspect-ratio: 16/7;
            object-fit: cover; border-radius: 12px 12px 0 0; margin-top: 8px;
        }
        .post-feat-placeholder {
            width: 100%; height: 260px;
            background: linear-gradient(135deg, rgba(79,70,229,.2), rgba(6,182,212,.1));
            border-radius: 12px 12px 0 0;
            display: grid; place-items: center;
        }

        /* ── Main layout ── */
        .post-layout {
            width: min(1200px, calc(100% - 40px)); margin: 0 auto;
            display: grid; grid-template-columns: 1fr 300px;
            gap: 40px; align-items: start;
            padding: 40px 0 80px;
        }
        .post-body { min-width: 0; overflow: hidden; }

        /* ── Excerpt box ── */
        .excerpt-box {
            font-size: 1.05rem; color: var(--text2); line-height: 1.72;
            padding: 18px 22px 18px 20px;
            background: var(--surface2);
            border-left: 3px solid var(--brand);
            border-radius: 0 var(--radius) var(--radius) 0;
            margin-bottom: 2em;
        }

        /* ── Mobile TOC ── */
        .mobile-toc {
            display: none;
            margin-bottom: 2em;
            border: 1px solid var(--border); border-radius: var(--radius);
            overflow: hidden;
        }
        .mobile-toc summary {
            padding: 12px 16px; font-size: .83rem; font-weight: 700;
            background: var(--surface2); color: var(--text2);
            display: flex; align-items: center; justify-content: space-between;
            cursor: pointer; list-style: none;
        }
        .mobile-toc summary::-webkit-details-marker { display: none; }
        .mobile-toc-list {
            padding: 10px 12px; display: grid; gap: 2px;
            background: var(--surface);
        }
        .mobile-toc-list a {
            display: block; padding: 7px 10px; border-radius: 7px;
            font-size: .84rem; font-weight: 600; color: var(--text2);
            transition: .15s;
        }
        .mobile-toc-list a:hover { background: var(--surface2); color: var(--brand); }
        .mobile-toc-list .toc-h3 { padding-left: 20px; font-size: .8rem; }

        /* ── Article content ── */
        .article-content { font-size: 1.05rem; line-height: 1.85; color: var(--text); }
        .article-content h2 {
            font-size: 1.5rem; font-weight: 800;
            letter-spacing: -.02em; line-height: 1.2;
            margin: 2.2em 0 .7em;
            padding-bottom: .5em; border-bottom: 2px solid var(--border);
        }
        .article-content h3 { font-size: 1.18rem; font-weight: 700; margin: 1.8em 0 .6em; }
        .article-content h4 { font-size: 1.02rem; font-weight: 700; margin: 1.5em 0 .5em; color: var(--text2); }
        .article-content p { margin: 0 0 1.3em; }
        .article-content strong { font-weight: 800; }
        .article-content em { font-style: italic; color: var(--text2); }
        .article-content a { color: var(--brand); font-weight: 700; text-decoration: underline; text-underline-offset: 3px; }
        .article-content a:hover { color: var(--accent); }
        .article-content ul, .article-content ol { padding-left: 1.5em; margin: 0 0 1.3em; }
        .article-content li { margin-bottom: .5em; }
        .article-content blockquote {
            border-left: 3px solid var(--brand);
            background: var(--surface2);
            margin: 1.5em 0; padding: 14px 20px;
            border-radius: 0 8px 8px 0;
            color: var(--text2); font-style: italic;
        }
        [data-theme="dark"] .article-content blockquote { background: rgba(79,70,229,.1); }
        .article-content blockquote p { margin: 0; }
        .article-content code {
            font-family: "Fira Code","Cascadia Code",ui-monospace,monospace;
            font-size: .87em; background: var(--inline-bg);
            color: var(--inline-text); padding: 2px 7px; border-radius: 5px;
        }
        .code-block-wrap { margin: 1.5em 0; border-radius: var(--radius); overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,.18); }
        .code-block-header {
            display: flex; align-items: center; justify-content: space-between;
            padding: 10px 16px; background: #1E293B;
            border-bottom: 1px solid rgba(255,255,255,.07);
        }
        .code-lang { font-size: .7rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; color: #64748B; }
        .code-copy-btn {
            display: flex; align-items: center; gap: 5px;
            font-size: .72rem; font-weight: 700; color: #64748B;
            background: none; border: none; padding: 0; transition: color .15s;
        }
        .code-copy-btn:hover { color: #A5B4FC; }
        .code-block-wrap pre { margin: 0; background: var(--code-bg); overflow-x: auto; padding: 20px; -webkit-overflow-scrolling: touch; }
        .code-block-wrap code {
            font-family: "Fira Code","Cascadia Code",ui-monospace,monospace;
            font-size: .87rem; line-height: 1.75;
            background: none !important; color: var(--code-text) !important;
            padding: 0 !important; border-radius: 0 !important; white-space: pre;
        }
        .content-image { margin: 1.8em 0; border-radius: var(--radius); overflow: hidden; }
        .content-image img { width: 100%; display: block; }
        .content-image figcaption {
            padding: 9px 14px; background: var(--surface2);
            font-size: .8rem; color: var(--text3); text-align: center; font-style: italic;
        }
        .ad-slot {
            margin: 2em 0; padding: 20px;
            border: 2px dashed var(--border); border-radius: var(--radius);
            background: var(--surface2); text-align: center;
            color: var(--text3); font-size: .82rem; font-weight: 600;
        }
        .ad-slot strong { display: block; font-size: .95rem; color: var(--text2); margin-bottom: 4px; }

        /* ── Article footer ── */
        .article-footer {
            margin-top: 2.5em; padding-top: 1.5em; border-top: 2px solid var(--border);
        }
        .article-tags {
            display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 20px;
        }
        .tag {
            padding: 5px 12px; border-radius: 99px;
            background: var(--surface2); border: 1px solid var(--border);
            font-size: .78rem; font-weight: 700; color: var(--text2);
            transition: .15s;
        }
        .tag:hover { background: rgba(79,70,229,.1); border-color: var(--brand); color: var(--brand); }
        .share-row {
            display: flex; align-items: center; justify-content: space-between;
            flex-wrap: wrap; gap: 12px;
        }
        .share-label { font-size: .78rem; font-weight: 700; color: var(--text3); text-transform: uppercase; letter-spacing: .06em; }
        .share-btns { display: flex; gap: 8px; flex-wrap: wrap; }
        .share-btn {
            height: 36px; padding: 0 14px; border-radius: 8px;
            border: 1px solid var(--border); background: var(--surface);
            color: var(--text2); font-size: .8rem; font-weight: 700;
            display: inline-flex; align-items: center; gap: 6px;
            transition: .15s;
        }
        .share-btn:hover { background: var(--surface2); color: var(--text); border-color: var(--text3); }
        .share-btn.twitter:hover { background: rgba(29,161,242,.08); color: #1DA1F2; border-color: #1DA1F2; }
        .share-btn.copy-ok { background: rgba(16,185,129,.1); color: #10B981; border-color: #10B981; }

        /* ── Sidebar ── */
        .post-sidebar { position: sticky; top: 80px; }
        .sidebar-card {
            background: var(--surface); border: 1px solid var(--border);
            border-radius: 12px; padding: 18px; margin-bottom: 14px;
        }
        .sidebar-card h3 {
            font-size: .75rem; font-weight: 800;
            letter-spacing: .07em; text-transform: uppercase;
            color: var(--text3); margin-bottom: 12px;
        }
        .toc-list { list-style: none; display: grid; gap: 2px; }
        .toc-list a {
            display: block; padding: 6px 10px; border-radius: 7px;
            font-size: .83rem; font-weight: 600; color: var(--text2); transition: .15s;
        }
        .toc-list a:hover { background: var(--surface2); color: var(--brand); }
        .toc-list a.active { background: rgba(79,70,229,.1); color: var(--brand); font-weight: 700; }
        .toc-list .toc-h3 { padding-left: 18px; font-size: .79rem; }
        .related-item {
            display: flex; gap: 11px; align-items: flex-start;
            padding: 10px 0; border-bottom: 1px solid var(--border);
            transition: .15s;
        }
        .related-item:last-child { border: none; padding-bottom: 0; }
        .related-item:hover .related-title { color: var(--brand); }
        .related-thumb {
            width: 54px; height: 46px; flex-shrink: 0;
            border-radius: 7px; overflow: hidden; background: var(--surface2);
            object-fit: cover;
        }
        .related-title { font-size: .82rem; font-weight: 700; line-height: 1.35; }
        .related-meta { font-size: .72rem; color: var(--text3); margin-top: 3px; }

        /* ── Back to top ── */
        #backTop {
            position: fixed; bottom: 28px; right: 24px; z-index: 40;
            width: 42px; height: 42px; border-radius: 10px;
            background: var(--brand); color: #fff;
            border: none; display: grid; place-items: center;
            box-shadow: 0 4px 16px rgba(79,70,229,.35);
            opacity: 0; transform: translateY(12px);
            transition: opacity .25s, transform .25s;
            pointer-events: none;
        }
        #backTop.show { opacity: 1; transform: none; pointer-events: auto; }
        #backTop:hover { background: #4338CA; }

        /* ── Footer ── */
        .footer { background: var(--surface); border-top: 1px solid var(--border); padding: 30px 0; }
        .footer-inner {
            width: min(1200px, calc(100% - 40px)); margin: 0 auto;
            display: flex; align-items: center; justify-content: space-between;
            gap: 16px; font-size: .83rem; color: var(--text3);
        }

        /* ── Responsive ── */
        @media (max-width: 900px) {
            .post-layout { grid-template-columns: 1fr; gap: 24px; padding: 28px 0 60px; }
            .post-sidebar { position: static; }
            .post-hero { padding: 44px 0 0; }
            .post-hero-inner { width: calc(100% - 40px); }
            .post-title { font-size: clamp(1.5rem, 5vw, 2.2rem); }
            .article-content { font-size: 1rem; }
            .mobile-toc { display: block; }
        }
        @media (max-width: 640px) {
            .nav-inner { min-height: 56px; }
            .brand-logo-img { height: 28px; }
            .nav-right { gap: 6px; }
            .nav-btn { height: 32px; padding: 0 10px; font-size: .78rem; }
            .theme-btn { width: 32px; height: 32px; }
            .post-hero { padding: 32px 0 0; }
            .post-hero-inner { width: calc(100% - 28px); }
            .post-breadcrumb { font-size: .7rem; gap: 5px; }
            .post-title { font-size: 1.4rem; }
            .post-cat { font-size: .7rem; }
            .post-meta { gap: 8px; font-size: .75rem; }
            .meta-sep { display: none; }
            .post-meta span { padding: 2px 8px; background: rgba(255,255,255,.07); border-radius: 99px; }
            .post-feat-img { aspect-ratio: 16/9; }
            .post-feat-placeholder { height: 170px; }
            .post-layout { padding: 20px 0 48px; gap: 20px; }
            .article-content { font-size: .96rem; line-height: 1.78; }
            .article-content h2 { font-size: 1.25rem; margin: 1.8em 0 .5em; }
            .article-content h3 { font-size: 1.05rem; }
            .code-block-wrap pre { padding: 14px; font-size: .81rem; }
            .sidebar-card { padding: 14px; }
            .share-row { flex-direction: column; align-items: flex-start; }
            .footer-inner { flex-direction: column; gap: 6px; text-align: center; }
            #backTop { bottom: 20px; right: 16px; width: 38px; height: 38px; }
        }
        @media (max-width: 400px) {
            .post-title { font-size: 1.2rem; }
        }
    </style>
</head>
<body>

{{-- Reading progress --}}
<div id="readProgress"></div>

{{-- Preview bar --}}
@auth
@if ($post->status !== 'published')
<div class="preview-bar">
    Pratinjau — artikel belum dipublikasikan (status: {{ $post->status }}).
    <a href="{{ route('dashboard.posts.edit', [$post->type, $post]) }}">← Kembali ke editor</a>
</div>
@endif
@endauth

{{-- ── Nav ── --}}
<header class="topbar">
    <div class="nav-inner">
        <a class="brand" href="{{ route('home') }}" aria-label="pahamIT">
            <img class="brand-logo-img"
                 src="{{ asset('images/clean/logo_full_clean.png') }}"
                 alt="pahamIT">
        </a>
        <div class="nav-right">
            <button class="theme-btn" id="themeToggle" aria-label="Toggle dark mode">
                <svg class="sun" width="16" height="16" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="4" stroke="currentColor" stroke-width="2"/><path d="M12 2v2m0 16v2M4.22 4.22l1.42 1.42m12.72 12.72 1.42 1.42M2 12h2m16 0h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                <svg class="moon" width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M21 12.79A9 9 0 1 1 11.21 3a7 7 0 0 0 9.79 9.79Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </button>
            <a class="nav-btn" href="{{ route('home') }}">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Beranda
            </a>
            @auth
            <a class="nav-btn" href="{{ route('dashboard.posts.edit', [$post->type, $post]) }}"
               style="background:rgba(79,70,229,.1);border-color:rgba(79,70,229,.3);color:#4F46E5;">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Edit
            </a>
            @endauth
        </div>
    </div>
</header>

{{-- ── Post hero ── --}}
<div class="post-hero">
    <div class="post-hero-inner">
        <div class="post-breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <svg width="10" height="10" viewBox="0 0 24 24" fill="none"><path d="m9 18 6-6-6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            @if($post->type === 'berita')
                <a href="{{ route('home') }}#berita">Berita IT</a>
            @elseif($post->type === 'tutorial')
                <a href="{{ route('home') }}#panduan">Panduan & Belajar</a>
            @else
                <a href="{{ route('home') }}#toko">Toko IT</a>
            @endif
            <svg width="10" height="10" viewBox="0 0 24 24" fill="none"><path d="m9 18 6-6-6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            <span>{{ Str::limit($post->title, 40) }}</span>
        </div>

        @if($post->category)
        <div class="post-cat">{{ $post->category }}</div>
        @endif

        <h1 class="post-title">{{ $post->title }}</h1>

        <div class="post-meta">
            <span>
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2M12 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                Tim pahamIT
            </span>
            <span class="meta-sep">·</span>
            <span>
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none"><rect x="3" y="4" width="18" height="18" rx="2" stroke="currentColor" stroke-width="2"/><path d="M16 2v4M8 2v4M3 10h18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                {{ optional($post->published_at)->translatedFormat('d M Y') ?? 'Draft' }}
            </span>
            <span class="meta-sep">·</span>
            <span>
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8Z" stroke="currentColor" stroke-width="2"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2"/></svg>
                {{ number_format($post->views_count) }} views
            </span>
            @if($post->content)
            <span class="meta-sep">·</span>
            <span>
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2"/><path d="M12 7v5l3 3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                {{ max(1, (int)(str_word_count(strip_tags($post->content)) / 200)) }} menit baca
            </span>
            @endif
        </div>

        @if($post->featured_image_url)
            <img class="post-feat-img" src="{{ $post->featured_image_url }}" alt="{{ $post->title }}">
        @else
            <div class="post-feat-placeholder">
                <svg width="44" height="44" viewBox="0 0 24 24" fill="none" style="opacity:.25;color:#fff;"><path d="M12 2L2 7l10 5 10-5-10-5ZM2 17l10 5 10-5M2 12l10 5 10-5" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg>
            </div>
        @endif
    </div>
</div>

{{-- ── Layout ── --}}
<div class="post-layout">

    {{-- Article --}}
    <article class="post-body" id="articleBody">

        @if($post->excerpt)
        <div class="excerpt-box">{{ $post->excerpt }}</div>
        @endif

        {{-- Mobile TOC (populated by JS) --}}
        <details class="mobile-toc" id="mobileTocWrap" style="display:none;">
            <summary>
                <span>Daftar Isi</span>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </summary>
            <div class="mobile-toc-list" id="mobileTocList"></div>
        </details>

        <div class="article-content" id="articleContent">
            {!! \App\Helpers\ContentRenderer::render($post->content ?? '') !!}
        </div>

        {{-- Article footer --}}
        <div class="article-footer">
            <div class="article-tags">
                @if($post->category)
                <span class="tag">{{ $post->category }}</span>
                @endif
                <span class="tag">{{ ucfirst($post->type) }}</span>
                <span class="tag">pahamIT</span>
            </div>
            <div class="share-row">
                <span class="share-label">Bagikan artikel ini</span>
                <div class="share-btns">
                    <a class="share-btn twitter"
                       href="https://twitter.com/intent/tweet?text={{ urlencode($post->title) }}&url={{ urlencode(url()->current()) }}"
                       target="_blank" rel="noreferrer">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.746l7.73-8.835L1.254 2.25H8.08l4.259 5.63 5.905-5.63Zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        X / Twitter
                    </a>
                    <button class="share-btn" id="copyBtn" onclick="copyLink(this)">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><rect x="9" y="9" width="13" height="13" rx="2" stroke="currentColor" stroke-width="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                        Salin Link
                    </button>
                </div>
            </div>
        </div>
    </article>

    {{-- Sidebar --}}
    <aside class="post-sidebar">

        {{-- TOC --}}
        <div class="sidebar-card" id="tocCard" style="display:none;">
            <h3>Daftar Isi</h3>
            <ul class="toc-list" id="tocList"></ul>
        </div>

        {{-- Ad --}}
        <div class="sidebar-card ad-slot" style="min-height:240px;display:flex;flex-direction:column;align-items:center;justify-content:center;">
            <strong>Iklan</strong>
            Slot 300×250<br>
            <small style="margin-top:4px;color:var(--text3);">Hubungi kami untuk pasang iklan</small>
        </div>

        {{-- Related --}}
        @if($related->count())
        <div class="sidebar-card">
            <h3>Artikel Terkait</h3>
            @foreach($related as $rel)
            @php
                $relRoute = match($rel->type) {
                    'berita'   => route('post.berita',  $rel->slug),
                    'tutorial' => route('post.panduan', $rel->slug),
                    default    => route('post.toko',    $rel->slug),
                };
            @endphp
            <a href="{{ $relRoute }}" class="related-item">
                @if($rel->featured_image_url)
                    <img class="related-thumb" src="{{ $rel->featured_image_url }}" alt="{{ $rel->title }}">
                @else
                    <div class="related-thumb" style="background:linear-gradient(135deg,rgba(79,70,229,.15),rgba(6,182,212,.1));display:grid;place-items:center;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" style="opacity:.3;"><path d="M12 2L2 7l10 5 10-5-10-5Z" stroke="currentColor" stroke-width="2"/></svg>
                    </div>
                @endif
                <div>
                    <div class="related-title">{{ Str::limit($rel->title, 55) }}</div>
                    <div class="related-meta">{{ $rel->category ?? ucfirst($rel->type) }} · {{ optional($rel->published_at)->diffForHumans() }}</div>
                </div>
            </a>
            @endforeach
        </div>
        @endif

    </aside>
</div>

{{-- Footer --}}
<footer class="footer">
    <div class="footer-inner">
        <div>
            © {{ date('Y') }} <strong style="color:var(--text);">pahamIT</strong> · pahamit.com<br>
            <span>Jakarta Selatan &nbsp;·&nbsp; <a href="mailto:info@pahamit.com" style="color:var(--brand);">info@pahamit.com</a></span>
        </div>
        <div>Bukan Sekadar Belajar.</div>
    </div>
</footer>

{{-- Back to top --}}
<button id="backTop" aria-label="Kembali ke atas" onclick="window.scrollTo({top:0,behavior:'smooth'})">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M18 15l-6-6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
</button>

<script>
    // ── Theme ──
    const html = document.documentElement;
    const s    = localStorage.getItem('pahamit-theme');
    if (s) html.setAttribute('data-theme', s);
    else if (window.matchMedia('(prefers-color-scheme: dark)').matches) html.setAttribute('data-theme','dark');
    document.getElementById('themeToggle').addEventListener('click', () => {
        const n = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
        html.setAttribute('data-theme', n);
        localStorage.setItem('pahamit-theme', n);
    });

    // ── Reading progress ──
    const bar = document.getElementById('readProgress');
    const body = document.getElementById('articleBody');
    function updateProgress() {
        const rect  = body.getBoundingClientRect();
        const total = body.offsetHeight - window.innerHeight;
        const done  = Math.max(0, -rect.top);
        bar.style.width = Math.min(100, (done / total) * 100) + '%';
    }
    window.addEventListener('scroll', updateProgress, { passive: true });

    // ── Back to top ──
    const backBtn = document.getElementById('backTop');
    window.addEventListener('scroll', () => {
        backBtn.classList.toggle('show', window.scrollY > 400);
    }, { passive: true });

    // ── Copy link ──
    function copyLink(btn) {
        navigator.clipboard.writeText(location.href).then(() => {
            const orig = btn.innerHTML;
            btn.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M20 6 9 17l-5-5" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg> Tersalin!';
            btn.classList.add('copy-ok');
            setTimeout(() => { btn.innerHTML = orig; btn.classList.remove('copy-ok'); }, 2200);
        });
    }

    // ── Copy code blocks ──
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

    // ── Auto TOC ──
    (function buildToc() {
        const headings = document.querySelectorAll('.article-content h2, .article-content h3');
        if (headings.length < 2) return;

        // Sidebar TOC
        const card = document.getElementById('tocCard');
        const list = document.getElementById('tocList');
        card.style.display = 'block';
        headings.forEach((h, i) => {
            if (!h.id) h.id = 'h-' + i;
            const li = document.createElement('li');
            const a  = document.createElement('a');
            a.href = '#' + h.id; a.textContent = h.textContent;
            if (h.tagName === 'H3') a.classList.add('toc-h3');
            li.appendChild(a); list.appendChild(li);
        });

        // Mobile TOC
        const mWrap = document.getElementById('mobileTocWrap');
        const mList = document.getElementById('mobileTocList');
        mWrap.style.display = 'block';
        headings.forEach(h => {
            const a = document.createElement('a');
            a.href = '#' + h.id; a.textContent = h.textContent;
            if (h.tagName === 'H3') a.classList.add('toc-h3');
            mList.appendChild(a);
        });

        // Active heading observer
        const obs = new IntersectionObserver(entries => {
            entries.forEach(e => {
                const sel = `a[href="#${e.target.id}"]`;
                list.querySelectorAll(sel).forEach(a => a.classList.toggle('active', e.isIntersecting));
            });
        }, { rootMargin: '-20% 0px -70% 0px' });
        headings.forEach(h => obs.observe(h));
    })();
</script>
@include('site.partials.adroll')
</body>
</html>
