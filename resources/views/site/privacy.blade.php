<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Kebijakan Privasi pahamIT tentang data kunjungan, kontak, dan penggunaan layanan.">
    <link rel="canonical" href="{{ route('privacy') }}">
    <title>Kebijakan Privasi - pahamIT</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet">
    <style>
        :root { --navy:#071f4f; --brand:#0b6fee; --bg:#f3f6fb; --surface:#fff; --text:#0d1526; --muted:#5a6a80; --line:#dde3ef; }
        * { box-sizing: border-box; }
        body { margin:0; font-family:"Plus Jakarta Sans",ui-sans-serif,system-ui,sans-serif; background:var(--bg); color:var(--text); line-height:1.75; }
        a { color: inherit; text-decoration: none; }
        .topbar { position:sticky; top:0; background:rgba(255,255,255,.94); border-bottom:1px solid var(--line); backdrop-filter:blur(18px); z-index:10; }
        .nav { width:min(920px, calc(100% - 40px)); margin:0 auto; min-height:64px; display:flex; align-items:center; justify-content:space-between; gap:16px; }
        .brand { font-weight:900; color:var(--navy); letter-spacing:-.02em; }
        .nav a:not(.brand) { color:var(--muted); font-size:.88rem; font-weight:800; }
        .hero { background:linear-gradient(145deg,#030d20 0%,#071f4f 60%,#0c1540 100%); color:#fff; padding:64px 0; }
        .wrap { width:min(920px, calc(100% - 40px)); margin:0 auto; }
        .hero p { margin:0; color:#b0c8e6; max-width:640px; }
        h1 { margin:0 0 14px; font-size:clamp(2rem,5vw,3.2rem); line-height:1.08; letter-spacing:-.035em; }
        .content { width:min(920px, calc(100% - 40px)); margin:44px auto 72px; display:grid; gap:18px; }
        .panel { background:var(--surface); border:1px solid var(--line); border-radius:12px; padding:26px; box-shadow:0 2px 14px rgba(7,31,79,.06); }
        h2 { margin:0 0 10px; font-size:1.15rem; }
        p, li { color:var(--muted); }
        ul { margin:10px 0 0; padding-left:1.2rem; }
        .contact { display:flex; flex-wrap:wrap; gap:10px; margin-top:16px; }
        .btn { min-height:40px; display:inline-flex; align-items:center; padding:0 14px; border-radius:8px; border:1px solid var(--line); background:#fff; font-weight:800; font-size:.86rem; }
        .btn.primary { border-color:var(--brand); background:var(--brand); color:#fff; }
        footer { width:min(920px, calc(100% - 40px)); margin:0 auto 34px; color:var(--muted); font-size:.82rem; }
    </style>
</head>
<body>
    <header class="topbar">
        <nav class="nav">
            <a class="brand" href="{{ route('home') }}">pahamIT</a>
            <a href="{{ route('home') }}">Beranda</a>
        </nav>
    </header>
    <section class="hero">
        <div class="wrap">
            <h1>Kebijakan Privasi</h1>
            <p>Kami menjaga data pengunjung secara proporsional: cukup untuk keamanan, analitik dasar, dan komunikasi layanan pahamIT.</p>
        </div>
    </section>
    <main class="content">
        <section class="panel">
            <h2>Data Yang Kami Kumpulkan</h2>
            <p>pahamIT dapat menyimpan data kunjungan dasar seperti tanggal, halaman yang dibuka, hash alamat IP, user agent, referer, serta data yang Anda kirim melalui formulir, email, atau WhatsApp.</p>
        </section>
        <section class="panel">
            <h2>Penggunaan Data</h2>
            <ul>
                <li>Mengukur performa konten dan memperbaiki pengalaman membaca.</li>
                <li>Menjaga keamanan dashboard, formulir, dan layanan AI internal.</li>
                <li>Menjawab pertanyaan, permintaan kerja sama, konsultasi, atau pembelian layanan.</li>
            </ul>
        </section>
        <section class="panel">
            <h2>Cookie, Log, Dan Pihak Ketiga</h2>
            <p>Website dapat memakai session cookie Laravel, penyimpanan preferensi tema di browser, layanan font, dan slot iklan atau embed pihak ketiga bila diaktifkan. Tautan eksternal mengikuti kebijakan privasi layanan masing-masing.</p>
        </section>
        <section class="panel">
            <h2>Kontak Privasi</h2>
            <p>Untuk pertanyaan data, koreksi informasi, atau permintaan penghapusan data komunikasi, hubungi pahamIT melalui kanal berikut.</p>
            <div class="contact">
                <a class="btn primary" href="https://wa.me/6281250653005" target="_blank" rel="noreferrer">WhatsApp 081250653005</a>
                <a class="btn" href="mailto:info@pahamit.com">info@pahamit.com</a>
            </div>
        </section>
    </main>
    <footer>Terakhir diperbarui: {{ now()->format('d M Y') }}. &copy; {{ date('Y') }} pahamIT.</footer>
</body>
</html>
