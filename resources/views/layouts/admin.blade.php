<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — Rumah Bahasa Surabaya</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        * { box-sizing: border-box; }

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
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
        }

        .nav-link.active {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            font-weight: 500;
        }

        .admin-header-right {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-shrink: 0;
        }

        .admin-header-right span {
            color: #fff;
            font-size: 14px;
            font-weight: 500;
        }

        .btn-logout {
            padding: 8px 20px;
            background: rgba(255,255,255,0.1);
            color: var(--white);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-logout:hover { background: rgba(255,255,255,0.15); }

        .admin-main .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
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
        <header class="admin-header">
            <div class="container">
                
                <!-- Sisi Kiri: Judul & Navigasi -->
                <div class="admin-header-left">
                    <h2>Panel Admin</h2>
                    <nav class="admin-nav">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
                        <a href="{{ route('admin.profil.index') }}" class="nav-link {{ request()->routeIs('admin.profil.*') ? 'active' : '' }}">konten website</a>
                        <a href="{{ route('admin.layanan.index') }}" class="nav-link {{ request()->routeIs('admin.layanan.*') ? 'active' : '' }}">Program</a>
                        <a href="{{ route('admin.galeri.index') }}" class="nav-link {{ request()->routeIs('admin.galeri.*') ? 'active' : '' }}">Berita</a>
                        <a href="{{ route('admin.kontak.index') }}" class="nav-link {{ request()->routeIs('admin.kontak.*') ? 'active' : '' }}">Pesan</a>
                        <a href="{{ route('admin.pendaftaran.index') }}" class="nav-link {{ request()->routeIs('admin.pendaftaran.*') ? 'active' : '' }}">Pendaftar</a>
                    </nav>
                </div>
                
                <!-- Sisi Kanan: User Info & Logout -->
                <div class="admin-header-right">
                    <span>{{ auth()->user()->name }}</span>
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