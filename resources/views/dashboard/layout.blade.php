<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Dashboard' }} - Pahamit Admin</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <style>
        /* â”€â”€ Tokens â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
        :root {
            --brand:        #4F46E5;
            --brand-h:      #4338CA;
            --brand-soft:   #EEF2FF;
            --brand-text:   #4338CA;
            --accent:       #06B6D4;
            --green:        #10B981;
            --green-soft:   #D1FAE5;
            --amber:        #F59E0B;
            --rose:         #F43F5E;
            --rose-soft:    #FFE4E6;

            --bg:           #F1F5F9;
            --surface:      #FFFFFF;
            --surface2:     #F8FAFC;
            --border:       #E2E8F0;
            --border-soft:  #F1F5F9;
            --text:         #0F172A;
            --text2:        #475569;
            --text3:        #94A3B8;

            --sidebar-bg:   #0F172A;
            --sidebar-text: #94A3B8;
            --sidebar-hover:#1E293B;
            --sidebar-active-bg: rgba(79,70,229,.18);
            --sidebar-active-text: #A5B4FC;
            --sidebar-border: rgba(255,255,255,.07);

            --radius:       12px;
            --radius-sm:    8px;
            --shadow:       0 1px 3px rgba(15,23,42,.06), 0 6px 20px rgba(15,23,42,.05);
            --shadow-md:    0 4px 6px rgba(15,23,42,.05), 0 12px 36px rgba(15,23,42,.08);

            --sidebar-w:    260px;
            --topbar-h:     64px;
        }

        [data-theme="dark"] {
            --bg:           #0B0F1A;
            --surface:      #111827;
            --surface2:     #1E293B;
            --border:       #1E293B;
            --border-soft:  #1E293B;
            --text:         #F1F5F9;
            --text2:        #94A3B8;
            --text3:        #475569;
            --brand-soft:   #1E1B4B;
            --green-soft:   #064E3B;
            --rose-soft:    #4C0519;
            --shadow:       0 1px 3px rgba(0,0,0,.3), 0 6px 20px rgba(0,0,0,.2);
            --shadow-md:    0 4px 6px rgba(0,0,0,.3), 0 12px 36px rgba(0,0,0,.35);
        }

        /* â”€â”€ Reset â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { font-size: 16px; height: 100%; }
        body {
            font-family: "Plus Jakarta Sans", ui-sans-serif, system-ui, sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100%;
            transition: background .22s, color .22s;
        }
        a { color: inherit; text-decoration: none; }
        button, input, select, textarea { font: inherit; }
        img, svg { display: block; }

        /* â”€â”€ Shell â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
        .shell {
            display: flex;
            min-height: 100vh;
        }

        /* â”€â”€ Sidebar â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
        .sidebar {
            position: fixed; top: 0; left: 0; bottom: 0;
            width: var(--sidebar-w);
            background: var(--sidebar-bg);
            display: flex; flex-direction: column;
            z-index: 40;
            transition: transform .28s cubic-bezier(.4,0,.2,1);
            overflow: hidden;
        }
        .sidebar-inner {
            display: flex; flex-direction: column;
            height: 100%; overflow-y: auto;
            padding: 0 0 24px;
            scrollbar-width: thin;
            scrollbar-color: rgba(255,255,255,.08) transparent;
        }

        /* brand */
        .sb-brand {
            display: flex; align-items: center; gap: 10px;
            padding: 20px 20px 18px;
            border-bottom: 1px solid var(--sidebar-border);
            flex-shrink: 0;
        }
        .sb-logo {
            width: 34px; height: 34px; border-radius: 9px;
            background: var(--brand); display: grid; place-items: center;
            flex-shrink: 0; color: #fff;
        }
        .sb-name { font-size: 1.1rem; font-weight: 800; color: #fff; }
        .sb-name span { color: #818CF8; }
        .sb-role {
            margin-top: 3px; font-size: .7rem; font-weight: 600;
            color: var(--sidebar-text); letter-spacing: .04em;
            text-transform: uppercase;
        }

        /* nav sections */
        .sb-section { padding: 20px 12px 4px; }
        .sb-section-label {
            font-size: .68rem; font-weight: 700; letter-spacing: .1em;
            text-transform: uppercase; color: rgba(148,163,184,.45);
            padding: 0 8px; margin-bottom: 6px;
        }
        .sb-nav { display: flex; flex-direction: column; gap: 2px; }
        .sb-link {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 10px; border-radius: 8px;
            color: var(--sidebar-text);
            font-size: .875rem; font-weight: 600;
            transition: background .15s, color .15s, transform .15s;
            position: relative;
        }
        .sb-link:hover {
            background: var(--sidebar-hover);
            color: #E2E8F0;
        }
        .sb-link.active {
            background: var(--sidebar-active-bg);
            color: var(--sidebar-active-text);
        }
        .sb-link.active::before {
            content: "";
            position: absolute; left: 0; top: 6px; bottom: 6px;
            width: 3px; border-radius: 0 3px 3px 0;
            background: var(--brand);
        }
        .sb-link svg { flex-shrink: 0; opacity: .75; }
        .sb-link.active svg, .sb-link:hover svg { opacity: 1; }
        .sb-badge {
            margin-left: auto;
            padding: 2px 7px; border-radius: 99px;
            font-size: .68rem; font-weight: 700;
            background: rgba(79,70,229,.25); color: #A5B4FC;
        }

        /* user card at bottom */
        .sb-user {
            margin: auto 12px 0;
            padding: 12px;
            border-radius: 10px;
            background: rgba(255,255,255,.05);
            border: 1px solid rgba(255,255,255,.07);
            display: flex; align-items: center; gap: 10px;
            flex-shrink: 0; margin-top: 20px;
        }
        .sb-avatar {
            width: 34px; height: 34px; border-radius: 50%;
            background: linear-gradient(135deg, var(--brand), var(--accent));
            display: grid; place-items: center; flex-shrink: 0;
            font-size: .78rem; font-weight: 800; color: #fff;
        }
        .sb-uname { font-size: .83rem; font-weight: 700; color: #E2E8F0; }
        .sb-urole { font-size: .72rem; color: var(--sidebar-text); margin-top: 2px; }

        /* â”€â”€ Sidebar overlay (mobile) â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
        .sidebar-overlay {
            display: none;
            position: fixed; inset: 0; z-index: 39;
            background: rgba(0,0,0,.55);
            backdrop-filter: blur(4px);
        }
        .sidebar-overlay.show { display: block; }

        /* â”€â”€ Main area â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
        .main-wrap {
            flex: 1; min-width: 0;
            margin-left: var(--sidebar-w);
            display: flex; flex-direction: column;
            transition: margin-left .28s cubic-bezier(.4,0,.2,1);
        }

        /* â”€â”€ Topbar â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
        .topbar {
            position: sticky; top: 0; z-index: 30;
            height: var(--topbar-h);
            display: flex; align-items: center;
            justify-content: space-between; gap: 16px;
            padding: 0 28px;
            background: rgba(255,255,255,.88);
            border-bottom: 1px solid var(--border);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            transition: background .22s, border-color .22s;
            flex-shrink: 0;
        }
        [data-theme="dark"] .topbar {
            background: rgba(17,24,39,.9);
        }
        .topbar-left { display: flex; align-items: center; gap: 14px; }
        .topbar-title { font-size: 1rem; font-weight: 700; }
        .topbar-sub  { font-size: .78rem; color: var(--text3); margin-top: 1px; }

        .hamburger {
            width: 38px; height: 38px;
            border-radius: 9px;
            border: 1px solid var(--border);
            background: var(--surface);
            color: var(--text2);
            display: none; place-items: center;
            cursor: pointer; flex-shrink: 0;
            transition: background .15s;
        }
        .hamburger:hover { background: var(--surface2); }

        .topbar-right { display: flex; align-items: center; gap: 8px; }

        .tb-btn {
            height: 36px; padding: 0 13px;
            display: inline-flex; align-items: center; gap: 7px;
            border-radius: 8px; font-size: .83rem; font-weight: 700;
            border: 1px solid var(--border);
            background: var(--surface); color: var(--text2);
            cursor: pointer; white-space: nowrap;
            transition: background .15s, color .15s, border-color .15s;
        }
        .tb-btn:hover { background: var(--surface2); color: var(--text); }
        .tb-btn.primary {
            background: var(--rose); border-color: var(--rose);
            color: #fff;
            box-shadow: 0 4px 12px rgba(244,63,94,.25);
        }
        .tb-btn.primary:hover { background: #E11D48; }

        .theme-btn {
            width: 36px; height: 36px;
            border-radius: 8px;
            border: 1px solid var(--border);
            background: var(--surface);
            color: var(--text2); cursor: pointer;
            display: grid; place-items: center;
            transition: .15s;
        }
        .theme-btn:hover { background: var(--surface2); color: var(--text); }
        .icon-sun, .icon-moon { transition: opacity .2s; }
        [data-theme="dark"]  .icon-sun  { display: none; }
        [data-theme="light"] .icon-moon { display: none; }

        .notif-btn {
            position: relative;
            width: 36px; height: 36px; border-radius: 8px;
            border: 1px solid var(--border); background: var(--surface);
            color: var(--text2); cursor: pointer;
            display: grid; place-items: center;
            transition: .15s;
        }
        .notif-btn:hover { background: var(--surface2); }
        .notif-dot {
            position: absolute; top: 7px; right: 7px;
            width: 7px; height: 7px; border-radius: 50%;
            background: var(--rose);
            border: 1.5px solid var(--surface);
        }

        /* â”€â”€ Page content â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
        .page-content {
            flex: 1;
            padding: 28px;
        }

        /* â”€â”€ Flash â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
        .flash {
            display: flex; align-items: center; gap: 10px;
            padding: 12px 16px; border-radius: 10px;
            margin-bottom: 20px;
            background: var(--green-soft);
            color: #065F46; font-weight: 700; font-size: .9rem;
            border: 1px solid #A7F3D0;
        }

        /* â”€â”€ Cards / Panels â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
        }
        .panel { padding: 22px; }
        .panel-head {
            display: flex; align-items: flex-start;
            justify-content: space-between; gap: 16px;
            margin-bottom: 20px;
        }
        .panel-head h2 {
            font-size: 1rem; font-weight: 700;
        }
        .panel-head p { font-size: .83rem; color: var(--text2); margin-top: 3px; }

        /* â”€â”€ Stat cards â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
        }
        .stat-card {
            padding: 20px;
            border-radius: var(--radius);
            border: 1px solid var(--border);
            background: var(--surface);
            box-shadow: var(--shadow);
            position: relative; overflow: hidden;
        }
        .stat-card::after {
            content: "";
            position: absolute; right: -20px; bottom: -20px;
            width: 80px; height: 80px; border-radius: 50%;
            opacity: .08;
        }
        .stat-card.blue::after  { background: var(--brand); }
        .stat-card.green::after { background: var(--green); }
        .stat-card.amber::after { background: var(--amber); }
        .stat-card.rose::after  { background: var(--rose); }

        .stat-top { display: flex; align-items: flex-start; justify-content: space-between; gap: 12px; }
        .stat-icon {
            width: 42px; height: 42px; border-radius: 10px;
            display: grid; place-items: center; flex-shrink: 0;
        }
        .stat-icon.blue  { background: var(--brand-soft); color: var(--brand); }
        .stat-icon.green { background: var(--green-soft); color: var(--green); }
        .stat-icon.amber { background: rgba(245,158,11,.12); color: var(--amber); }
        .stat-icon.rose  { background: var(--rose-soft); color: var(--rose); }

        .stat-label { font-size: .78rem; font-weight: 700; color: var(--text2); }
        .stat-value { font-size: 2rem; font-weight: 800; line-height: 1.1; margin-top: 8px; }
        .stat-trend {
            display: inline-flex; align-items: center; gap: 4px;
            margin-top: 8px; font-size: .75rem; font-weight: 700;
        }
        .stat-trend.up   { color: var(--green); }
        .stat-trend.down { color: var(--rose); }
        .stat-trend.flat { color: var(--text3); }

        /* â”€â”€ Grid helpers â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
        .grid-2 { display: grid; gap: 16px; grid-template-columns: 1.4fr 1fr; }
        .grid-auto { display: grid; gap: 16px; }

        /* â”€â”€ Chart containers â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
        .chart-wrap {
            position: relative; width: 100%;
        }
        .chart-wrap canvas { width: 100% !important; }

        /* â”€â”€ Top list â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
        .top-list { display: grid; gap: 10px; }
        .top-item {
            display: flex; align-items: center; gap: 12px;
            padding: 12px 14px;
            border-radius: 10px;
            border: 1px solid var(--border);
            background: var(--surface2);
            transition: border-color .15s, background .15s;
        }
        .top-item:hover { background: var(--brand-soft); border-color: rgba(79,70,229,.2); }
        [data-theme="dark"] .top-item:hover { background: var(--sidebar-hover); }
        .rank-badge {
            width: 28px; height: 28px; border-radius: 8px;
            background: var(--sidebar-bg); color: #fff;
            display: grid; place-items: center;
            font-size: .72rem; font-weight: 800; flex-shrink: 0;
        }
        .rank-badge.gold   { background: linear-gradient(135deg, #F59E0B, #B45309); }
        .rank-badge.silver { background: linear-gradient(135deg, #94A3B8, #475569); }
        .rank-badge.bronze { background: linear-gradient(135deg, #CD7F32, #92400E); }
        .top-title { font-size: .86rem; font-weight: 700; line-height: 1.3; }
        .top-meta  { font-size: .75rem; color: var(--text3); margin-top: 2px; }
        .top-views {
            margin-left: auto; flex-shrink: 0;
            font-size: .78rem; font-weight: 700; color: var(--brand);
            background: var(--brand-soft);
            padding: 3px 9px; border-radius: 6px;
        }

        /* â”€â”€ Badge â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
        .badge {
            display: inline-flex; align-items: center;
            padding: 3px 9px; border-radius: 6px;
            font-size: .74rem; font-weight: 700;
        }
        .badge.blue   { background: var(--brand-soft); color: var(--brand-text); }
        .badge.green  { background: var(--green-soft); color: #065F46; }
        .badge.rose   { background: var(--rose-soft); color: #9F1239; }
        .badge.amber  { background: rgba(245,158,11,.12); color: #92400E; }
        .badge.gray   { background: var(--surface2); color: var(--text2); }

        /* â”€â”€ Table â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
        .table-wrap { overflow-x: auto; }
        .table {
            width: 100%; border-collapse: collapse; min-width: 620px;
        }
        .table th {
            padding: 10px 14px;
            text-align: left; vertical-align: middle;
            font-size: .72rem; font-weight: 700;
            letter-spacing: .06em; text-transform: uppercase;
            color: var(--text3);
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }
        .table td {
            padding: 13px 14px;
            border-bottom: 1px solid var(--border-soft);
            vertical-align: middle; font-size: .875rem;
        }
        .table tbody tr:last-child td { border-bottom: none; }
        .table tbody tr:hover td { background: var(--surface2); }
        .table .title-cell { font-weight: 700; max-width: 280px; }
        .table .muted { color: var(--text2); }

        /* â”€â”€ Quick actions â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
        .qa-list { display: grid; gap: 10px; }
        .qa-item {
            display: flex; align-items: center; gap: 12px;
            padding: 12px 14px; border-radius: 10px;
            border: 1px solid var(--border);
            background: var(--surface2);
            font-size: .875rem; font-weight: 700;
            color: var(--text2);
            transition: .15s;
        }
        .qa-item:hover { background: var(--brand-soft); border-color: rgba(79,70,229,.2); color: var(--brand); }
        [data-theme="dark"] .qa-item:hover { background: var(--sidebar-hover); color: var(--text); }
        .qa-icon {
            width: 34px; height: 34px; border-radius: 8px;
            display: grid; place-items: center; flex-shrink: 0;
        }

        /* â”€â”€ Form elements â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
        .field { display: grid; gap: 6px; }
        .field.full { grid-column: 1/-1; }
        .field label {
            font-size: .78rem; font-weight: 700; color: var(--text2);
        }
        .field input,
        .field select,
        .field textarea {
            width: 100%; min-height: 42px;
            padding: 0 12px;
            border: 1px solid var(--border); border-radius: 8px;
            background: var(--surface); color: var(--text);
            outline: none; transition: border-color .15s, box-shadow .15s;
        }
        .field textarea { min-height: 130px; padding: 10px 12px; resize: vertical; }
        .field input[type="file"] { padding: 9px 12px; }
        .field input:focus,
        .field select:focus,
        .field textarea:focus {
            border-color: var(--brand);
            box-shadow: 0 0 0 3px rgba(79,70,229,.12);
        }
        .text-danger { color: var(--rose); font-size: .8rem; }

        /* â”€â”€ Editor â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
        .editor-title {
            min-height: 54px !important;
            font-size: 1.2rem !important; font-weight: 800 !important;
        }
        .editor-toolbar {
            display: flex; flex-wrap: wrap; gap: 6px;
            padding: 10px 12px;
            border: 1px solid var(--border); border-bottom: none;
            border-radius: 10px 10px 0 0;
            background: var(--surface2);
        }
        .tool-btn {
            width: 32px; height: 32px;
            border: 1px solid var(--border); border-radius: 7px;
            background: var(--surface); color: var(--text);
            display: grid; place-items: center; cursor: pointer;
            font-weight: 800; font-size: .82rem;
            transition: background .12s, border-color .12s;
        }
        .tool-btn:hover { background: var(--brand-soft); border-color: var(--brand); color: var(--brand); }
        .tool-tab { width: auto; padding: 0 10px; font-size: .76rem; font-weight: 700; }
        .tool-tab.active { background: var(--brand-soft); border-color: var(--brand); color: var(--brand); }
        .editor-textarea {
            min-height: 400px !important;
            border-radius: 0 0 10px 10px !important;
            line-height: 1.75;
        }

        /* image upload */
        .image-preview {
            min-height: 160px;
            border: 2px dashed var(--border);
            border-radius: 10px;
            background: var(--surface2);
            color: var(--text3);
            display: grid; place-items: center;
            cursor: pointer; text-align: center;
            transition: border-color .15s;
            overflow: hidden;
        }
        .image-preview:hover { border-color: var(--brand); }
        .image-preview img { width: 100%; height: 100%; object-fit: cover; }

        /* â”€â”€ Btn â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
        .btn {
            display: inline-flex; align-items: center; gap: 7px;
            min-height: 40px; padding: 0 16px;
            border-radius: 9px; border: 1px solid transparent;
            font-size: .875rem; font-weight: 700;
            cursor: pointer; white-space: nowrap; transition: .15s;
        }
        .btn-primary { background: var(--brand); color: #fff; }
        .btn-primary:hover { background: var(--brand-h); transform: translateY(-1px); }
        .btn-danger  { background: var(--rose); color: #fff; }
        .btn-danger:hover  { background: #E11D48; }
        .btn-soft {
            background: var(--surface);
            border-color: var(--border); color: var(--text2);
        }
        .btn-soft:hover { background: var(--surface2); color: var(--text); }
        .btn-sm { min-height: 34px; padding: 0 12px; font-size: .8rem; }

        /* inline form */
        .inline-form { display: inline; }

        /* â”€â”€ Pagination â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
        .pagination {
            display: flex; flex-wrap: wrap; gap: 6px; margin-top: 16px;
        }
        .pagination a,
        .pagination span {
            min-width: 34px; min-height: 34px;
            display: inline-flex; align-items: center; justify-content: center;
            padding: 0 10px; border-radius: 8px;
            border: 1px solid var(--border); background: var(--surface);
            color: var(--text2); font-weight: 700; font-size: .83rem;
            transition: .15s;
        }
        .pagination a:hover { background: var(--brand-soft); border-color: var(--brand); color: var(--brand); }
        .pagination .active { background: var(--brand); border-color: var(--brand); color: #fff; }

        /* â”€â”€ Editor shell â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
        .editor-shell {
            display: grid;
            grid-template-columns: minmax(0, 1fr);
            gap: 24px;
            align-items: start;
            max-width: 960px;
            margin: 0 auto;
        }
        .editor-main, .editor-side { display: grid; gap: 22px; }
        .editor-side {
            grid-template-columns: repeat(3, minmax(0, 1fr));
            align-items: start;
        }
        .editor-shell .panel { padding: 26px; }
        .editor-shell .panel-head {
            gap: 18px;
            margin-bottom: 24px;
        }
        .editor-shell .field { gap: 9px; }
        .editor-shell .field input,
        .editor-shell .field select {
            min-height: 46px;
            padding-left: 14px;
            padding-right: 14px;
        }
        .editor-shell .field textarea {
            padding: 14px 16px;
            line-height: 1.75;
        }
        .editor-shell .editor-title {
            min-height: 60px !important;
            padding-left: 18px;
            padding-right: 18px;
        }
        .editor-shell .editor-toolbar {
            padding: 13px 14px;
            gap: 8px;
        }
        .editor-shell .editor-textarea {
            min-height: 560px !important;
            padding: 18px 20px !important;
            font-size: .96rem;
            line-height: 1.85;
        }
        .editor-shell #previewPane {
            height: 560px !important;
            padding: 24px 28px !important;
        }
        .editor-side { position: static; }

        /* â”€â”€ Responsive â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
        @media (max-width: 1100px) {
            :root { --sidebar-w: 240px; }
        }
        @media (max-width: 991px) {
            html, body { overflow-x: hidden; }
            .shell { display: block; min-width: 0; }
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-wrap { width: 100%; margin-left: 0; min-width: 0; }
            .hamburger { display: grid; }
            .stats-grid { grid-template-columns: 1fr 1fr; }
            .grid-2 { grid-template-columns: 1fr; }
            .editor-shell { grid-template-columns: 1fr; }
            .editor-side { position: static; }
            .topbar {
                min-height: var(--topbar-h);
                height: auto;
                padding-top: 10px;
                padding-bottom: 10px;
                align-items: flex-start;
            }
            .topbar-left { min-width: 0; flex: 1; }
            .topbar-title,
            .topbar-sub {
                max-width: 100%;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }
            .topbar-right { flex-shrink: 0; }
            .panel-head { align-items: stretch; }
            .chart-wrap { min-width: 0; }
        }
        @media (max-width: 640px) {
            :root {
                --radius: 10px;
                --topbar-h: 58px;
            }
            .sidebar { width: min(86vw, 300px); }
            .page-content { padding: 14px; }
            .topbar {
                gap: 10px;
                padding: 10px 14px;
            }
            .topbar-left { gap: 10px; }
            .topbar-title { font-size: .92rem; }
            .topbar-sub { display: none; }
            .theme-btn,
            .notif-btn,
            .hamburger {
                width: 36px;
                height: 36px;
            }
            .topbar-right .tb-btn {
                width: 36px;
                height: 36px;
                padding: 0;
                justify-content: center;
            }
            .topbar-right .tb-btn svg { display: block; }
            .topbar-right .tb-btn:not(.primary) {
                font-size: 0;
                gap: 0;
            }
            .topbar-right form .tb-btn.primary {
                width: auto;
                padding: 0 10px;
                font-size: .76rem;
            }
            .stats-grid { grid-template-columns: 1fr 1fr; gap: 12px; }
            .stat-card { padding: 15px; }
            .stat-icon {
                width: 36px;
                height: 36px;
            }
            .stat-label { font-size: .72rem; }
            .stat-value { font-size: 1.6rem; }
            .stat-trend { font-size: .68rem; }
            .panel { padding: 15px; }
            .editor-shell {
                gap: 16px;
                max-width: none;
            }
            .editor-main,
            .editor-side {
                gap: 16px;
            }
            .editor-side {
                grid-template-columns: 1fr;
            }
            .editor-shell .panel {
                padding: 18px;
            }
            .editor-shell .panel-head {
                gap: 12px;
                margin-bottom: 16px;
            }
            .panel-head {
                display: grid;
                grid-template-columns: 1fr;
                gap: 12px;
                margin-bottom: 16px;
            }
            .panel-head > div,
            .panel-head form,
            .panel-head .field,
            .panel-head input,
            .panel-head .btn {
                width: 100%;
                min-width: 0 !important;
            }
            .panel-head > div[style*="display:flex"] {
                display: grid !important;
                grid-template-columns: 1fr;
                gap: 10px !important;
                align-items: stretch !important;
            }
            .panel-head .field[style*="flex-direction:row"] {
                display: grid !important;
                grid-template-columns: 1fr auto;
                gap: 8px !important;
            }
            .btn {
                min-height: 38px;
                justify-content: center;
            }
            .table-wrap {
                width: calc(100vw - 58px);
                margin-left: -1px;
                padding-bottom: 6px;
                -webkit-overflow-scrolling: touch;
            }
            .table {
                min-width: 720px;
            }
            .top-item {
                align-items: flex-start;
                flex-wrap: wrap;
            }
            .top-views {
                margin-left: 40px;
            }
            .qa-item {
                min-height: 54px;
            }
            .editor-title {
                min-height: 48px !important;
                font-size: 1rem !important;
            }
            .editor-toolbar {
                max-width: 100%;
                overflow-x: auto;
                flex-wrap: nowrap;
                scrollbar-width: thin;
                -webkit-overflow-scrolling: touch;
            }
            .editor-toolbar .tool-btn {
                flex: 0 0 auto;
            }
            .editor-textarea {
                min-height: 420px !important;
                font-size: .92rem;
                padding: 15px !important;
            }
            #editorWrap { flex-direction: column; }
            #editorWrap textarea {
                width: 100% !important;
                border-radius: 0 0 10px 10px !important;
            }
            #previewPane {
                border-left: 1px solid var(--border) !important;
                border-top: none !important;
                border-radius: 0 0 10px 10px !important;
                height: 360px !important;
                width: 100% !important;
                padding: 16px !important;
            }
            .image-preview { min-height: 140px; }
            .pagination a,
            .pagination span {
                min-width: 32px;
                min-height: 32px;
                font-size: .78rem;
            }
        }
        @media (max-width: 479px) {
            .stats-grid { grid-template-columns: 1fr; }
            .topbar-right .tb-btn:not(.primary) { display: none; }
            .page-content { padding: 12px; }
            .card { border-radius: 10px; }
            .panel { padding: 13px; }
            .editor-shell .panel {
                padding: 15px;
            }
            .editor-shell .editor-textarea {
                min-height: 380px !important;
            }
            .topbar-right { gap: 6px; }
            .notif-btn { display: none; }
            .stat-card { min-height: 118px; }
            .table-wrap { width: calc(100vw - 50px); }
            .tool-tab {
                width: auto;
                min-width: max-content;
            }
            .top-views {
                margin-left: 0;
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>
<div class="shell">

    <!-- â”€â”€ SIDEBAR â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ -->
    <aside class="sidebar" id="sidebar" aria-label="Navigasi Admin">
        <div class="sidebar-inner">

            <!-- brand -->
            <div class="sb-brand">
                <div class="sb-logo">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                        <path d="M12 2L2 7l10 5 10-5-10-5ZM2 17l10 5 10-5M2 12l10 5 10-5" stroke="currentColor" stroke-width="2" stroke-linejoin="round" stroke-linecap="round"/>
                    </svg>
                </div>
                <div>
                    <div class="sb-name">paham<span>IT</span></div>
                    <div class="sb-role">Admin Panel</div>
                </div>
            </div>

            <!-- main nav -->
            <div class="sb-section">
                <div class="sb-section-label">Main</div>
                <nav class="sb-nav">
                    <a class="sb-link {{ request()->routeIs('dashboard.index') ? 'active' : '' }}"
                       href="{{ route('dashboard.index') }}">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none">
                            <rect x="3" y="3" width="7" height="7" rx="2" stroke="currentColor" stroke-width="2"/>
                            <rect x="14" y="3" width="7" height="7" rx="2" stroke="currentColor" stroke-width="2"/>
                            <rect x="3" y="14" width="7" height="7" rx="2" stroke="currentColor" stroke-width="2"/>
                            <rect x="14" y="14" width="7" height="7" rx="2" stroke="currentColor" stroke-width="2"/>
                        </svg>
                        Overview
                    </a>
                    <a class="sb-link {{ request()->routeIs('dashboard.ai.*') ? 'active' : '' }}"
                       href="{{ route('dashboard.ai.index') }}">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none">
                            <path d="M12 3v3M6.5 5.5l2 2M21 12h-3M17.5 5.5l-2 2M12 18v3M4 12H1M7.5 16.5l-2 2M16.5 16.5l2 2M8 12a4 4 0 1 0 8 0 4 4 0 0 0-8 0Z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        AI Agent
                    </a>
                </nav>
            </div>

            <!-- konten -->
            <div class="sb-section">
                <div class="sb-section-label">Konten</div>
                <nav class="sb-nav">
                    <a class="sb-link {{ request()->is('dashboard/berita') ? 'active' : '' }}"
                       href="{{ route('dashboard.posts.index', 'berita') }}">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none">
                            <path d="M4 5h16M4 10h10M4 15h12M4 20h8" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        Daftar Berita
                    </a>
                    <a class="sb-link {{ request()->is('dashboard/berita/create') || request()->is('dashboard/berita/*/edit') ? 'active' : '' }}"
                       href="{{ route('dashboard.posts.create', 'berita') }}">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none">
                            <path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        Posting Berita
                    </a>
                    <a class="sb-link {{ request()->is('dashboard/tutorial') ? 'active' : '' }}"
                       href="{{ route('dashboard.posts.index', 'tutorial') }}">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none">
                            <path d="M8 4h12v16H8a4 4 0 0 1-4-4V8a4 4 0 0 1 4-4Zm0 0v16M12 8h4M12 12h4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        Daftar Panduan
                    </a>
                    <a class="sb-link {{ request()->is('dashboard/tutorial/create') || request()->is('dashboard/tutorial/*/edit') ? 'active' : '' }}"
                       href="{{ route('dashboard.posts.create', 'tutorial') }}">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none">
                            <path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        Posting Panduan
                    </a>
                    <a class="sb-link {{ request()->is('dashboard/series*') ? 'active' : '' }}"
                       href="{{ route('dashboard.series.index') }}">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none">
                            <path d="M4 6h16M4 10h16M4 14h10M4 18h6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        Seri Panduan
                    </a>
                    <a class="sb-link {{ request()->is('dashboard/jualan') ? 'active' : '' }}"
                       href="{{ route('dashboard.posts.index', 'jualan') }}">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none">
                            <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4ZM3 6h18M16 10a4 4 0 0 1-8 0" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Daftar Jualan
                    </a>
                    <a class="sb-link {{ request()->is('dashboard/jualan/create') || request()->is('dashboard/jualan/*/edit') ? 'active' : '' }}"
                       href="{{ route('dashboard.posts.create', 'jualan') }}">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none">
                            <path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        Posting Jualan
                    </a>
                </nav>
            </div>

            <!-- settings -->
            <div class="sb-section">
                <div class="sb-section-label">Lainnya</div>
                <nav class="sb-nav">
                    <a class="sb-link" href="{{ route('home') }}" target="_blank">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none">
                            <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6M15 3h6v6M10 14 21 3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Lihat Website
                    </a>
                    <form method="post" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="sb-link" style="width:100%; border:none; background:none; cursor:pointer; text-align:left;">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Logout
                        </button>
                    </form>
                </nav>
            </div>

            <!-- user info -->
            <div class="sb-user">
                <div class="sb-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 2)) }}</div>
                <div>
                    <div class="sb-uname">{{ auth()->user()->name ?? 'Admin' }}</div>
                    <div class="sb-urole">Administrator</div>
                </div>
            </div>

        </div>
    </aside>

    <!-- overlay mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- â”€â”€ MAIN â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ -->
    <div class="main-wrap" id="mainWrap">

        <!-- topbar -->
        <header class="topbar">
            <div class="topbar-left">
                <button class="hamburger" id="hamburger" aria-label="Toggle sidebar" aria-expanded="false">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                        <path d="M3 12h18M3 6h18M3 18h18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </button>
                <div>
                    <div class="topbar-title">{{ $title ?? 'Dashboard' }}</div>
                    <div class="topbar-sub">{{ $description ?? 'pahamIT Admin Panel' }}</div>
                </div>
            </div>
            <div class="topbar-right">
                <button class="theme-btn" id="themeToggle" title="Ganti tema" aria-label="Toggle dark mode">
                    <svg class="icon-sun" width="16" height="16" viewBox="0 0 24 24" fill="none">
                        <circle cx="12" cy="12" r="4" stroke="currentColor" stroke-width="2"/>
                        <path d="M12 2v2m0 16v2M4.22 4.22l1.42 1.42m12.72 12.72 1.42 1.42M2 12h2m16 0h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    <svg class="icon-moon" width="16" height="16" viewBox="0 0 24 24" fill="none">
                        <path d="M21 12.79A9 9 0 1 1 11.21 3a7 7 0 0 0 9.79 9.79Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
                <button class="notif-btn" title="Notifikasi">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 0 1-3.46 0" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="notif-dot"></span>
                </button>
                <a class="tb-btn" href="{{ route('home') }}" target="_blank">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                        <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6M15 3h6v6M10 14 21 3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Website
                </a>
                <form class="inline-form" method="post" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="tb-btn primary">Logout</button>
                </form>
            </div>
        </header>

        <!-- content -->
        <main class="page-content">
            @if (session('status'))
                <div class="flash">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><polyline points="22,4 12,14.01 9,11.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    {{ session('status') }}
                </div>
            @endif
            @yield('content')
        </main>
    </div>
</div>

<script>
    // â”€â”€ Dark / Light â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
    const html = document.documentElement;
    const themeBtn = document.getElementById('themeToggle');
    const savedTheme = localStorage.getItem('pahamit-admin-theme');
    if (savedTheme) {
        html.setAttribute('data-theme', savedTheme);
    } else if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
        html.setAttribute('data-theme', 'dark');
    }
    themeBtn.addEventListener('click', () => {
        const next = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
        html.setAttribute('data-theme', next);
        localStorage.setItem('pahamit-admin-theme', next);
    });

    // â”€â”€ Sidebar toggle â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
    const sidebar  = document.getElementById('sidebar');
    const overlay  = document.getElementById('sidebarOverlay');
    const hamburger = document.getElementById('hamburger');

    function openSidebar() {
        sidebar.classList.add('open');
        overlay.classList.add('show');
        hamburger.setAttribute('aria-expanded', 'true');
        document.body.style.overflow = 'hidden';
    }
    function closeSidebar() {
        sidebar.classList.remove('open');
        overlay.classList.remove('show');
        hamburger.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
    }

    hamburger.addEventListener('click', () => {
        sidebar.classList.contains('open') ? closeSidebar() : openSidebar();
    });
    overlay.addEventListener('click', closeSidebar);

    // close on nav click (mobile)
    sidebar.querySelectorAll('.sb-link, .sb-nav a').forEach(a => {
        a.addEventListener('click', () => {
            if (window.innerWidth < 992) closeSidebar();
        });
    });
</script>
@stack('scripts')
</body>
</html>
