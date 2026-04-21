<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, follow">
    <title>@yield('title', 'Terjadi Kendala') - pahamIT</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet">
    <style>
        :root {
            --navy: #071f4f;
            --brand: #0b6fee;
            --red: #ed1c24;
            --bg: #f3f6fb;
            --surface: #ffffff;
            --text: #0d1526;
            --muted: #5a6a80;
            --line: #dde3ef;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 28px;
            font-family: "Plus Jakarta Sans", ui-sans-serif, system-ui, sans-serif;
            color: var(--text);
            background:
                linear-gradient(145deg, rgba(7,31,79,.08), rgba(11,111,238,.06)),
                var(--bg);
        }
        .error-shell {
            width: min(720px, 100%);
            border: 1px solid var(--line);
            border-radius: 12px;
            background: var(--surface);
            box-shadow: 0 18px 48px rgba(7,31,79,.12);
            overflow: hidden;
        }
        .error-hero {
            position: relative;
            padding: 34px 34px 30px;
            color: #fff;
            background: linear-gradient(145deg, #030d20 0%, #071f4f 58%, #0c1540 100%);
        }
        .error-hero::after {
            content: "";
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 70% 90% at 0% 60%, rgba(11,111,238,.32), transparent 60%),
                radial-gradient(ellipse 45% 60% at 100% 10%, rgba(237,28,36,.2), transparent 55%);
            pointer-events: none;
        }
        .error-content {
            position: relative;
            z-index: 1;
        }
        .code {
            display: inline-flex;
            align-items: center;
            min-height: 30px;
            padding: 0 12px;
            border-radius: 999px;
            background: rgba(255,255,255,.1);
            border: 1px solid rgba(255,255,255,.18);
            color: #9ed0ff;
            font-weight: 800;
            font-size: .82rem;
            letter-spacing: .08em;
        }
        h1 {
            margin: 18px 0 10px;
            max-width: 560px;
            font-size: clamp(1.8rem, 6vw, 3.1rem);
            line-height: 1.06;
            letter-spacing: -.035em;
        }
        .lead {
            margin: 0;
            max-width: 560px;
            color: #b0c8e6;
            line-height: 1.75;
        }
        .error-body {
            padding: 26px 34px 34px;
        }
        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 22px;
        }
        .btn {
            min-height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 0 16px;
            border: 1px solid var(--line);
            border-radius: 8px;
            color: var(--text);
            background: #fff;
            text-decoration: none;
            font-weight: 800;
            font-size: .88rem;
        }
        .btn.primary {
            border-color: var(--brand);
            background: var(--brand);
            color: #fff;
        }
        .note {
            margin: 0;
            color: var(--muted);
            font-size: .92rem;
            line-height: 1.7;
        }
        @media (max-width: 520px) {
            body { padding: 16px; }
            .error-hero, .error-body { padding-left: 22px; padding-right: 22px; }
            .btn { width: 100%; }
        }
    </style>
</head>
<body>
    <main class="error-shell">
        <section class="error-hero">
            <div class="error-content">
                <span class="code">@yield('code', 'ERROR')</span>
                <h1>@yield('heading', 'Halaman sedang bermasalah.')</h1>
                <p class="lead">@yield('message', 'Kami sedang memeriksa kendala ini. Silakan kembali ke beranda atau hubungi pahamIT jika masalah berulang.')</p>
            </div>
        </section>
        <section class="error-body">
            <p class="note">@yield('hint', 'Tidak perlu mulai dari awal. Beberapa tautan penting sudah kami siapkan di bawah.')</p>
            <div class="actions">
                <a class="btn primary" href="{{ route('home') }}">Kembali ke Beranda</a>
                <a class="btn" href="{{ route('listing.berita') }}">Baca Berita</a>
                <a class="btn" href="{{ route('listing.panduan') }}">Lihat Panduan</a>
            </div>
        </section>
    </main>
</body>
</html>
