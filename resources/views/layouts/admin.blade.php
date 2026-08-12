<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — Rumah Bahasa Surabaya</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        /* =====================================================================
           THEME ADMIN — TERMINAL / MONOKROM GELAP
           Hitam, abu, putih. Simple & native, tidak warna-warni.
           ===================================================================== */

        /* Redefinisi palet dalam konteks admin saja (halaman publik tidak terpengaruh) */
        :root {
            --gray-50: #0d1117;
            --gray-100: #161b22;
            --gray-200: #21262d;
            --gray-300: #30363d;
            --gray-400: #8b949e;
            --gray-500: #8b949e;
            --gray-600: #a5afba;
            --gray-700: #c9d1d9;
            --gray-800: #d7dee6;
            --gray-900: #e6edf3;
            --white: #e6edf3;
            --teal-900: #0d1117;
            --teal-800: #161b22;
            --teal-700: #3fb950;
            --teal-600: #3fb950;
            --teal-500: #3fb950;
            --teal-400: #58a6ff;
            --teal-300: #3fb950;
            --teal-200: #8b949e;
            --teal-100: #21262d;
            --teal-50: #161b22;
        }

        * { box-sizing: border-box; }

        body {
            background: #0d1117;
            color: #e6edf3;
            min-height: 100vh;
            font-family: 'Segoe UI', system-ui, -apple-system, Roboto, 'Helvetica Neue', Arial, sans-serif;
            color-scheme: dark;
            font-size: 14px;
            line-height: 1.6;
        }

        /* Buang dekorasi orbs/dots/dot-pattern dari layout lama */
        body::before,
        .admin-page::before,
        .admin-orb { display: none !important; }

        .admin-page {
            min-height: 100vh;
            background: #0d1117;
            position: relative;
        }

        /* ===== SIDEBAR (kiri, ala Filament) ===== */
        .admin-page {
            display: flex;
            min-height: 100vh;
        }
        .admin-sidebar {
            width: 240px;
            flex-shrink: 0;
            background: #010409;
            border-right: 1px solid #21262d;
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            padding: 20px 0;
        }
        .admin-sidebar .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0 20px 20px;
            border-bottom: 1px solid #21262d;
            margin-bottom: 16px;
        }
        .admin-sidebar .sidebar-brand img.brand-logo {
            height: 28px;
            width: auto;
            object-fit: contain;
        }
        .admin-sidebar h2 {
            margin: 0;
            color: #e6edf3;
            font-size: 15px;
            font-weight: 600;
            letter-spacing: 0;
            font-family: 'Cascadia Mono', Consolas, Menlo, monospace;
            white-space: nowrap;
        }
        .admin-sidebar h2::before {
            content: '> ';
            color: #3fb950;
            font-weight: 700;
        }
        .admin-nav {
            display: flex;
            flex-direction: column;
            gap: 2px;
            padding: 0 10px;
            flex: 1;
        }
        .nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: 8px;
            font-size: 13px;
            color: #8b949e;
            text-decoration: none;
            transition: all 0.15s;
            white-space: nowrap;
            font-weight: 500;
            position: relative;
        }
        .nav-link svg { width: 16px; height: 16px; flex-shrink: 0; }
        .nav-link::before { display: none; }
        .nav-link:hover {
            color: #e6edf3;
            background: #161b22;
        }
        .nav-link.active {
            color: #3fb950;
            background: rgba(63, 185, 80, 0.1);
            font-weight: 600;
        }
        .nav-link.active::before { display: none; }
        .admin-sidebar .sidebar-footer {
            border-top: 1px solid #21262d;
            padding: 16px 20px 0;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .admin-sidebar .sidebar-footer span {
            color: #8b949e;
            font-size: 12px;
        }
        .btn-logout {
            padding: 8px 14px;
            background: transparent;
            color: #c9d1d9;
            border: 1px solid #30363d;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.15s;
            text-decoration: none;
            font-family: inherit;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }
        .btn-logout:hover {
            background: #21262d;
            color: #e6edf3;
            transform: none;
        }

        /* ===== KONTEN ===== */
        .admin-content {
            flex: 1;
            min-width: 0;
            margin-left: 240px;
            display: flex;
            flex-direction: column;
        }
        .admin-main { padding: 32px 0 60px; flex: 1; }
        .admin-main .container { max-width: 1200px; margin: 0 auto; padding: 0 24px; }

        /* ===== KARTU ===== */
        .dashboard-card {
            background: #161b22;
            border: 1px solid #21262d;
            border-radius: 14px;
            padding: 28px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.3);
            animation: none;
        }
        .dashboard-card::before,
        .dashboard-card:hover::before { display: none; }
        .dashboard-card h3 {
            font-size: 16px;
            font-weight: 600;
            color: #e6edf3;
            margin-bottom: 20px;
            padding-bottom: 14px;
            border-bottom: 1px solid #21262d;
        }

        /* ===== ALERT ===== */
        .alert-success {
            padding: 12px 16px;
            background: rgba(63, 185, 80, 0.08);
            border: 1px solid rgba(63, 185, 80, 0.3);
            border-radius: 8px;
            color: #3fb950;
            font-weight: 500;
            font-size: 13px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .alert-error {
            padding: 12px 16px;
            background: rgba(248, 81, 73, 0.08);
            border: 1px solid rgba(248, 81, 73, 0.3);
            border-radius: 8px;
            color: #f85149;
            font-size: 13px;
            margin-bottom: 20px;
        }

        /* ===== TABEL ===== */
        .table-wrap { overflow-x: auto; }
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th {
            text-align: left;
            padding: 12px 16px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #8b949e;
            border-bottom: 1px solid #30363d;
            background: #0d1117;
        }
        .data-table td {
            padding: 14px 16px;
            font-size: 13px;
            color: #c9d1d9;
            border-bottom: 1px solid #21262d;
            vertical-align: top;
        }
        .data-table tr:hover td { background: #1c2129; }
        .data-table .title-cell {
            font-weight: 600;
            color: #e6edf3;
        }
        .data-table .action-cell { white-space: nowrap; }

        /* ===== FORM ===== */
        .form-group label { color: #c9d1d9; }
        .form-group input,
        .dashboard-form .form-group textarea,
        .form-group select,
        .form-control-custom,
        .admin-page select {
            background: #0d1117 !important;
            border: 1px solid #30363d !important;
            border-radius: 8px;
            color: #e6edf3 !important;
        }
        .form-group input:focus,
        .dashboard-form .form-group textarea:focus,
        .form-control-custom:focus {
            border-color: #3fb950 !important;
            box-shadow: 0 0 0 3px rgba(63, 185, 80, 0.15) !important;
            background: #0d1117 !important;
        }

        /* ===== TOMBOL ===== */
        .btn-submit {
            width: 100%;
            padding: 12px;
            background: #3fb950;
            color: #0d1117;
            border: none;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s;
            font-family: inherit;
        }
        .btn-submit:hover {
            background: #56d364;
            transform: none;
            box-shadow: none;
        }
        .btn-sm {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 6px 14px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 500;
            border: 1px solid #30363d;
            cursor: pointer;
            transition: all 0.15s;
            font-family: inherit;
        }
        .btn-edit {
            background: #21262d;
            color: #e6edf3;
        }
        .btn-edit:hover { background: #30363d; }
        .btn-delete {
            background: #21262d;
            color: #f85149;
        }
        .btn-delete:hover { background: #30363d; }
        .btn-cancel {
            padding: 8px 18px;
            background: #21262d;
            color: #c9d1d9;
            border: 1px solid #30363d;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
        }
        .btn-cancel:hover { background: #30363d; }

        /* Tombol export (pakai class btn-login di view admin) */
        .btn-login {
            background: #21262d !important;
            color: #e6edf3 !important;
            border: 1px solid #30363d !important;
            border-radius: 6px;
            font-weight: 500 !important;
            font-family: inherit;
        }
        .btn-login:hover { background: #30363d !important; }

        /* ===== NEUTRALKAN WARNA INLINE ===== */
        /* Angka statistik dashboard → putih */
        .admin-stat-grid div[style*="font-size:36px"] { color: #e6edf3 !important; }
        /* Badge status warna-warni → monokrom */
        span[style*="border-radius:50px"] {
            background: #21262d !important;
            color: #c9d1d9 !important;
            border: 1px solid #30363d;
        }
        /* Badge "Baru" merah di dashboard */
        span[style*="background:#dc2626"] { background: #da3633 !important; }
        /* Label "Dibaca"/"Baru" di kontak */
        td span[style*="color:var(--teal-700)"] { color: #3fb950 !important; }
        /* Link "Lihat Semua" */
        a[style*="color:var(--teal-700)"] { color: #58a6ff !important; }
        /* Text warna teks gelap inline → terang */
        .text-muted { color: #8b949e !important; }
        .admin-page div[style*="color:var(--gray-900)"] { color: #e6edf3 !important; }
        .admin-page div[style*="color:var(--gray-800)"] { color: #d7dee6 !important; }

        /* ===== TAB NAV (kelola member) ===== */
        .tab-btn {
            padding: 10px 24px !important;
            font-size: 13px !important;
            font-weight: 500 !important;
            background: none !important;
            border: none !important;
            border-bottom: 2px solid transparent !important;
            color: #8b949e !important;
            cursor: pointer;
            white-space: nowrap;
            font-family: inherit;
        }
        .tab-btn.active {
            color: #3fb950 !important;
            border-bottom-color: #3fb950 !important;
            font-weight: 600 !important;
        }
        .tab-nav { border-bottom: 1px solid #21262d !important; }

        /* ===== PROGRAM & JADWAL ===== */
        .program-card {
            background: #161b22;
            border: 1px solid #21262d;
            border-radius: 12px;
            margin-bottom: 24px;
            box-shadow: none;
            overflow: hidden;
        }
        .program-card-header {
            padding: 18px 24px;
            background: #0d1117;
            border-bottom: 1px solid #21262d;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
            cursor: pointer;
        }
        .program-card-header:hover { background: #0d1117; }
        .program-card-header h3 { color: #e6edf3; }
        .program-card-header p { color: #8b949e !important; }
        .jadwal-row {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            background: #0d1117;
            border: 1px solid #21262d;
            border-radius: 8px;
            margin-bottom: 8px;
            flex-wrap: wrap;
        }
        .jadwal-row:hover { background: #161b22; }
        .jadwal-form {
            background: #0d1117;
            border: 1px solid #30363d;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 16px;
            display: none;
        }
        .jadwal-form.open { display: block; }
        .btn-add-jadwal {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            background: #3fb950;
            color: #0d1117;
            border: none;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            font-family: inherit;
        }
        .btn-add-jadwal:hover { background: #56d364; }
        .toggle-icon {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 11px;
            font-weight: 500;
            color: #8b949e;
            background: #21262d;
            padding: 4px 10px 4px 8px;
            border-radius: 6px;
            border: 1px solid #30363d;
            white-space: nowrap;
        }
        .toggle-icon.open { background: rgba(63, 185, 80, 0.1); color: #3fb950; }
        .jadwal-form input,
        .jadwal-form select {
            background: #0d1117 !important;
            border: 1px solid #30363d !important;
            color: #e6edf3 !important;
        }
        /* Link WA grup */
        a[style*="#25d366"] { color: #58a6ff !important; }

        /* ===== DETAIL MEMBER ===== */
        .detail-header h3 { color: #e6edf3; }
        .back-link { color: #8b949e; }
        .back-link:hover { color: #3fb950; }
        .profile-card-header { border-bottom-color: #21262d; }
        .profile-avatar-placeholder { background: #21262d; }
        .card-title { color: #c9d1d9; }
        .info-label { color: #8b949e; }
        .info-value { color: #d7dee6; }
        .doc-item { border-bottom-color: #21262d; }
        .doc-label { color: #c9d1d9; }

        /* ===== KONTEN / GRID ===== */
        .konten-grid { gap: 24px; }
        .dashboard-card select { background: #0d1117 !important; color: #e6edf3 !important; border-color: #30363d !important; }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 900px) {
            .admin-sidebar {
                width: 100%;
                position: static;
                border-right: none;
                border-bottom: 1px solid #21262d;
                padding: 12px 0;
            }
            .admin-page { flex-direction: column; }
            .admin-content { margin-left: 0; }
            .admin-sidebar .sidebar-brand { padding-bottom: 12px; margin-bottom: 10px; }
            .admin-nav {
                flex-direction: row;
                overflow-x: auto;
                padding: 0 12px;
                -webkit-overflow-scrolling: touch;
                scrollbar-width: none;
            }
            .admin-nav::-webkit-scrollbar { display: none; }
            .nav-link { white-space: nowrap; }
            .admin-sidebar .sidebar-footer {
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
                padding: 10px 16px 0;
                border-top: none;
            }
            .admin-main { padding: 24px 0; }
        }
        @media (max-width: 480px) {
            .admin-sidebar h2 { font-size: 14px; }
            .nav-link { font-size: 12px; padding: 7px 10px; }
            .admin-main .container { padding: 0 12px; }
        }
    </style>
</head>
<body>
    <div class="admin-page">
        {{-- SIDEBAR KIRI (ala Filament) --}}
        <aside class="admin-sidebar">
            <div class="sidebar-brand">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Rumah Bahasa" class="brand-logo">
                <h2>Panel Admin</h2>
            </div>
            <nav class="admin-nav">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="9" rx="1"/><rect x="14" y="3" width="7" height="5" rx="1"/><rect x="14" y="12" width="7" height="9" rx="1"/><rect x="3" y="16" width="7" height="5" rx="1"/></svg>
                    Dashboard
                </a>
                <a href="{{ route('admin.konten.index') }}" class="nav-link {{ request()->routeIs('admin.konten.*') || request()->routeIs('admin.berita.*') || request()->routeIs('admin.profil.*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                    Konten
                </a>
                <a href="{{ route('admin.program-jadwal.index') }}" class="nav-link {{ request()->routeIs('admin.program-jadwal.*') || request()->routeIs('admin.program.*') || request()->routeIs('admin.jadwal-kelas.*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    Program &amp; Jadwal
                </a>
                <a href="{{ route('admin.member.kelola') }}" class="nav-link {{ request()->routeIs('admin.member.*') || request()->routeIs('admin.pendaftaran.*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    Member
                </a>
                <a href="{{ route('admin.kontak.index') }}" class="nav-link {{ request()->routeIs('admin.kontak.*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
                    Pesan
                </a>
            </nav>
            <div class="sidebar-footer">
                <a href="{{ route('home') }}" target="_blank" class="btn-logout" style="justify-content:flex-start;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                    Website
                </a>
                <form action="{{ route('logout') }}" method="POST" style="display:block;">
                    @csrf
                    <button type="submit" class="btn-logout" style="width:100%;">Logout</button>
                </form>
            </div>
        </aside>

        <div class="admin-content">
            <main class="admin-main">
                <div class="container">
                    @if(session('success'))
                        <div class="alert-success">{{ session('success') }}</div>
                    @endif
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
</body>
</html>
