<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — Rumah Belajar Surabaya</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="admin-page">
        <header class="admin-header">
            <div class="container">
                <div style="display:flex;align-items:center;gap:24px;">
                    <h2>Panel Admin</h2>
                    <nav style="display:flex;gap:4px;">
                        <a href="{{ route('admin.dashboard') }}" style="padding:8px 14px;border-radius:8px;font-size:13px;color:rgba(255,255,255,0.6);text-decoration:none;transition:all 0.2s;{{ request()->routeIs('admin.dashboard') ? 'background:rgba(255,255,255,0.1);color:#fff;' : '' }}">Dashboard</a>
                        <a href="{{ route('admin.profil.index') }}" style="padding:8px 14px;border-radius:8px;font-size:13px;color:rgba(255,255,255,0.6);text-decoration:none;transition:all 0.2s;{{ request()->routeIs('admin.profil.*') ? 'background:rgba(255,255,255,0.1);color:#fff;' : '' }}">Profil</a>
                        <a href="{{ route('admin.layanan.index') }}" style="padding:8px 14px;border-radius:8px;font-size:13px;color:rgba(255,255,255,0.6);text-decoration:none;transition:all 0.2s;{{ request()->routeIs('admin.layanan.*') ? 'background:rgba(255,255,255,0.1);color:#fff;' : '' }}">Layanan</a>
                        <a href="{{ route('admin.galeri.index') }}" style="padding:8px 14px;border-radius:8px;font-size:13px;color:rgba(255,255,255,0.6);text-decoration:none;transition:all 0.2s;{{ request()->routeIs('admin.galeri.*') ? 'background:rgba(255,255,255,0.1);color:#fff;' : '' }}">Galeri</a>
                        <a href="{{ route('admin.kontak.index') }}" style="padding:8px 14px;border-radius:8px;font-size:13px;color:rgba(255,255,255,0.6);text-decoration:none;transition:all 0.2s;{{ request()->routeIs('admin.kontak.*') ? 'background:rgba(255,255,255,0.1);color:#fff;' : '' }}">Pesan</a>
                        <a href="{{ route('admin.pendaftaran.index') }}" style="padding:8px 14px;border-radius:8px;font-size:13px;color:rgba(255,255,255,0.6);text-decoration:none;transition:all 0.2s;{{ request()->routeIs('admin.pendaftaran.*') ? 'background:rgba(255,255,255,0.1);color:#fff;' : '' }}">Pendaftar</a>
                    </nav>
                </div>
                <div class="admin-header-right">
                    <span>{{ auth()->user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">@csrf<button type="submit" class="btn-logout">Logout</button></form>
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
