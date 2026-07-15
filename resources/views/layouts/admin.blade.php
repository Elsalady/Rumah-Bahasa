<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — Rumah Bahasa Surabaya</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        * { box-sizing: border-box; }

        body {
            background: #f0fdfa;
            min-height: 100vh;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(ellipse 600px 400px at 10% 20%, rgba(13, 148, 136, 0.06) 0%, transparent 100%),
                radial-gradient(ellipse 500px 500px at 90% 30%, rgba(45, 212, 191, 0.06) 0%, transparent 100%),
                radial-gradient(ellipse 400px 300px at 50% 80%, rgba(0, 95, 115, 0.04) 0%, transparent 100%),
                radial-gradient(ellipse 300px 400px at 20% 70%, rgba(52, 211, 153, 0.04) 0%, transparent 100%),
                radial-gradient(ellipse 350px 350px at 80% 70%, rgba(13, 148, 136, 0.05) 0%, transparent 100%);
            pointer-events: none;
            z-index: 0;
        }

        .admin-page {
            position: relative;
            z-index: 1;
        }

        /* Subtle floating orbs */
        .admin-orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(60px);
            pointer-events: none;
            z-index: 0;
            opacity: 0.4;
            animation: floatOrb 12s ease-in-out infinite;
        }

        .admin-orb-1 {
            width: 300px;
            height: 300px;
            background: rgba(13, 148, 136, 0.08);
            top: -80px;
            right: -80px;
            animation-delay: 0s;
        }

        .admin-orb-2 {
            width: 200px;
            height: 200px;
            background: rgba(45, 212, 191, 0.07);
            bottom: 10%;
            left: -60px;
            animation-delay: -4s;
        }

        .admin-orb-3 {
            width: 250px;
            height: 250px;
            background: rgba(0, 95, 115, 0.06);
            bottom: -60px;
            right: 30%;
            animation-delay: -8s;
        }

        @keyframes floatOrb {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -20px) scale(1.05); }
            66% { transform: translate(-20px, 15px) scale(0.95); }
        }

        /* Subtle dot pattern overlay */
        .admin-page::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: radial-gradient(circle, rgba(13, 148, 136, 0.05) 1px, transparent 1px);
            background-size: 40px 40px;
            pointer-events: none;
            z-index: 0;
        }

        .admin-header {
            background: linear-gradient(135deg, #005f73 0%, #0d9488 50%, #0f766e 100%);
            background-size: 200% 200%;
            animation: gradientMove 8s ease-in-out infinite;
            padding: 16px 0;
            box-shadow: 0 4px 20px rgba(13, 148, 136, 0.2);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .admin-header .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            box-sizing: border-box;
            padding: 0 20px;
        }

        .admin-header-left {
            display: flex;
            align-items: center;
            gap: 24px;
            flex: 1;
            min-width: 0;
        }

        .admin-header h2 {
            margin: 0;
            white-space: nowrap;
            color: #fff;
            font-size: 22px;
            letter-spacing: -0.3px;
        }

        .admin-nav {
            display: flex;
            gap: 6px;
            align-items: center;
        }

        .nav-link {
            padding: 8px 14px;
            border-radius: 8px;
            font-size: 13px;
            color: rgba(255, 255, 255, 0.6);
            text-decoration: none;
            transition: all 0.2s ease-in-out;
            white-space: nowrap;
            position: relative;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%) scaleX(0);
            width: 60%;
            height: 3px;
            background: #2dd4bf;
            border-radius: 3px;
            transition: transform 0.3s ease;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        .nav-link:hover::before {
            transform: translateX(-50%) scaleX(0.5);
        }

        .nav-link.active {
            background: rgba(255, 255, 255, 0.12);
            color: #fff;
            font-weight: 500;
        }

        .nav-link.active::before {
            transform: translateX(-50%) scaleX(1);
        }

        .admin-header-right {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-shrink: 0;
        }

        .admin-header-right span {
            color: rgba(255,255,255,0.85);
            font-size: 14px;
            font-weight: 500;
        }

        .btn-logout {
            padding: 8px 20px;
            background: rgba(255,255,255,0.1);
            color: var(--white);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-logout:hover { 
            background: rgba(255,255,255,0.2);
            transform: translateY(-1px);
        }

        .admin-main {
            padding: 32px 0 60px;
        }

        .admin-main .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Card entrance animation */
        .dashboard-card {
            animation: cardFadeIn 0.4s ease-out both;
        }

        @keyframes cardFadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Stagger card animations */
        .dashboard-card:nth-child(1) { animation-delay: 0.05s; }
        .dashboard-card:nth-child(2) { animation-delay: 0.1s; }
        .dashboard-card:nth-child(3) { animation-delay: 0.15s; }
        .dashboard-card:nth-child(4) { animation-delay: 0.2s; }
        .dashboard-card:nth-child(5) { animation-delay: 0.25s; }
        .dashboard-card:nth-child(6) { animation-delay: 0.3s; }
        .dashboard-card:nth-child(7) { animation-delay: 0.35s; }
        .dashboard-card:nth-child(8) { animation-delay: 0.4s; }

        /* Alert */
        .alert-success {
            padding: 14px 20px;
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            border: 1px solid #6ee7b7;
            border-radius: 12px;
            color: #065f46;
            font-weight: 500;
            font-size: 14px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from { transform: translateY(-10px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        /* ===== RESPONSIVE ALL ADMIN PAGES ===== */
        @media (max-width: 900px) {
            .admin-header .container {
                flex-direction: column;
                align-items: stretch;
                gap: 12px;
                padding: 0 16px;
            }
            .admin-header-left {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
                width: 100%;
            }
            .admin-nav {
                width: 100%;
                overflow-x: auto;
                padding-bottom: 6px;
                -webkit-overflow-scrolling: touch;
                scrollbar-width: none;
                gap: 4px;
            }
            .admin-nav::-webkit-scrollbar { display: none; }
            .nav-link {
                font-size: 12px;
                padding: 6px 10px;
            }
            .admin-header-right {
                width: 100%;
                justify-content: space-between;
                border-top: 1px solid rgba(255,255,255,0.1);
                padding-top: 12px;
            }
            .admin-header-right span { font-size: 13px; }
            .admin-main { padding: 24px 0; }
            .admin-main .container { padding: 0 16px; }
            .dashboard-card { padding: 20px 16px; }

            /* Fix all admin grid layouts: profil, layanan, galeri */
            .admin-grid-2 {
                grid-template-columns: 1fr !important;
                gap: 20px !important;
            }

            /* Fix stat cards on dashboard mobile */
            .admin-stat-grid {
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 12px !important;
            }
            .admin-stat-grid .dashboard-card {
                padding: 20px 12px !important;
            }
            .admin-stat-grid .dashboard-card div:first-child {
                font-size: 28px !important;
            }

            /* Fix dashboard 2-col layout */
            .admin-dashboard-grid {
                grid-template-columns: 1fr !important;
                gap: 20px !important;
            }

            /* Make tables scrollable horizontally on mobile */
            .table-wrap {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
                margin: 0 -16px;
                padding: 0 16px;
            }
            .table-wrap table {
                min-width: 500px;
            }
            .data-table th,
            .data-table td {
                padding: 10px 12px !important;
                font-size: 13px !important;
            }
        }
    </style>
</head>
<body>
    <div class="admin-page">
        <div class="admin-orb admin-orb-1"></div>
        <div class="admin-orb admin-orb-2"></div>
        <div class="admin-orb admin-orb-3"></div>
        <header class="admin-header">
            <div class="container">
                
                <!-- Sisi Kiri: Judul & Navigasi -->
                <div class="admin-header-left">
                    <h2>Panel Admin</h2>
                    <nav class="admin-nav">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
                        <a href="{{ route('admin.profil.index') }}" class="nav-link {{ request()->routeIs('admin.profil.*') ? 'active' : '' }}">Konten Website</a>
                        <a href="{{ route('admin.berita.index') }}" class="nav-link {{ request()->routeIs('admin.berita.*') ? 'active' : '' }}">Berita</a>
                        <a href="{{ route('admin.galeri.index') }}" class="nav-link {{ request()->routeIs('admin.galeri.*') ? 'active' : '' }}">Galeri</a>
                        <a href="{{ route('admin.layanan.index') }}" class="nav-link {{ request()->routeIs('admin.layanan.*') ? 'active' : '' }}">Program</a>
                        <a href="{{ route('admin.pendaftaran.index') }}" class="nav-link {{ request()->routeIs('admin.pendaftaran.*') ? 'active' : '' }}">Pendaftar</a>
                        <a href="{{ route('admin.kontak.index') }}" class="nav-link {{ request()->routeIs('admin.kontak.*') ? 'active' : '' }}">Pesan</a>
                    </nav>
                </div>
                
                <!-- Sisi Kanan: User Info & Logout -->
                <div class="admin-header-right">
                    <span>{{ auth()->user()->name }}</span>
                    <a href="{{ route('home') }}" target="_blank" class="btn-logout" style="display:inline-flex;align-items:center;gap:6px;background:rgba(45,212,191,0.15);border-color:rgba(45,212,191,0.3);">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                        Website
                    </a>
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn-logout">Logout</button>
                    </form>
                </div>

            </div>
        </header>

        <main class="admin-main">
            <div class="container">
                @if(session('success'))
                    <div class="alert-success">{{ session('success') }}</div>
                @endif
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>