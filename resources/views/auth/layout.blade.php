<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Auth' }} | Pahamit.com</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800&display=swap" rel="stylesheet">
    <style>
        :root {
            --navy: #071f4f;
            --blue: #0b6fee;
            --red: #ed1c24;
            --bg: #f6f8fc;
            --surface: #ffffff;
            --text: #0f172a;
            --muted: #64748b;
            --line: #dbe4f0;
        }

        * { box-sizing: border-box; }
        body {
            min-height: 100vh;
            margin: 0;
            display: grid;
            place-items: center;
            padding: 24px;
            font-family: "Instrument Sans", ui-sans-serif, system-ui, sans-serif;
            color: var(--text);
            background:
                linear-gradient(135deg, rgba(7, 31, 79, .94), rgba(237, 28, 36, .78)),
                radial-gradient(circle at 20% 20%, rgba(255,255,255,.18), transparent 30%);
        }

        a { color: inherit; text-decoration: none; }

        .auth-card {
            width: min(100%, 440px);
            padding: 28px;
            border-radius: 8px;
            background: var(--surface);
            box-shadow: 0 24px 90px rgba(0,0,0,.22);
        }

        .brand {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 22px;
        }

        .brand img {
            width: 190px;
            max-width: 100%;
        }

        h1 {
            margin: 0;
            font-size: 1.75rem;
            line-height: 1.12;
            text-align: center;
        }

        .subtitle {
            margin: 10px 0 24px;
            color: var(--muted);
            text-align: center;
            line-height: 1.6;
        }

        .field {
            display: grid;
            gap: 7px;
            margin-bottom: 14px;
        }

        label {
            color: var(--muted);
            font-size: .88rem;
            font-weight: 900;
        }

        input {
            width: 100%;
            min-height: 46px;
            padding: 0 13px;
            border: 1px solid var(--line);
            border-radius: 8px;
            color: var(--text);
            font: inherit;
            outline: none;
        }

        input:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 4px rgba(11,111,238,.1);
        }

        .check-row,
        .footer-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin: 8px 0 18px;
            color: var(--muted);
            font-size: .9rem;
        }

        .check-row label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-weight: 700;
        }

        .check-row input {
            width: 16px;
            min-height: 16px;
        }

        .link {
            color: var(--blue);
            font-weight: 900;
        }

        .btn {
            width: 100%;
            min-height: 46px;
            border: 0;
            border-radius: 8px;
            color: #ffffff;
            background: var(--red);
            font: inherit;
            font-weight: 900;
            cursor: pointer;
            box-shadow: 0 12px 26px rgba(237, 28, 36, .2);
        }

        .alert {
            margin-bottom: 16px;
            padding: 12px 14px;
            border-radius: 8px;
            color: #075985;
            background: #e0f2fe;
            font-size: .92rem;
            font-weight: 700;
        }

        .error {
            margin-top: 6px;
            color: var(--red);
            font-size: .84rem;
            font-weight: 800;
        }

        .back {
            display: block;
            margin-top: 18px;
            color: var(--muted);
            text-align: center;
            font-weight: 800;
        }
    </style>
</head>
<body>
    <main class="auth-card">
        <a class="brand" href="{{ route('home') }}" aria-label="Pahamit.com">
            <img src="{{ asset('images/clean/logo_full_clean.png') }}" alt="Pahamit.com">
        </a>

        @yield('content')
    </main>
</body>
</html>
