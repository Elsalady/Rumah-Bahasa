<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — Rumah Bahasa Surabaya</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        /* ===== FLEXIBLE NAVBAR STYLE ===== */
        .admin-header .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
            width: 100%;
            max-width: 1200px; /* Sesuaikan dengan layoutmu */
            margin: 0 auto;
            box-sizing: border-box;
        }

        .admin-header-left {
            display: flex;
            align-items: center;
            gap: 24px;
            flex: 1;
            min-width: 0; /* Mencegah flex child meluap */
        }

        .admin-header h2 {
            margin: 0;
            white-space: nowrap;
        }

        /* Navigasi Utama */
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

        /* Sisi Kanan Navbar */
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

        /* ===== RESPONSIVE & INSPECT BREAKPOINT ===== */
        @media (max-width: 992px) {
            /* Bungkus ulang container utama agar rapi saat ruang menyempit */
            .admin-header .container {
                flex-direction: column;
                align-items: stretch;
                gap: 14px;
            }

            .admin-header-left {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
                width: 100%;
            }

            /* Bikin menu navigasi bisa di-scroll horizontal di HP biar ga menumpuk kebawah */
            .admin-nav {
                width: 100%;
                overflow-x: auto;
                padding-bottom: 8px;
                -webkit-overflow-scrolling: touch;
                /* Sembunyikan scrollbar bawaan di browser modern */
                scrollbar-width: none; 
            }
            
            .admin-nav::-webkit-scrollbar {
                display: none; /* Sembunyikan scrollbar Chrome/Safari */
            }

            .admin-header-right {
                width: 100%;
                justify-content: space-between;
                border-top: 1px solid rgba(255, 255, 255, 0.1);
                padding-top: 12px;
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