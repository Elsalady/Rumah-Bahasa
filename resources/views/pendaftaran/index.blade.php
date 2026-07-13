<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Program — Rumah Bahasa Surabaya</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        * { box-sizing: border-box; }

        .admin-header .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .admin-header-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn-logout {
            font-size: 14px;
            font-weight: 700;
            color: var(--teal-900);
            background: #fff;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            white-space: nowrap;
        }
        .btn-logout:hover { background: #f1f5f9; }

        .pendaftaran-form {
            max-width: 640px;
            margin: 0 auto;
            width: 100%;
            padding: 0 20px;
            box-sizing: border-box;
        }

        @media (max-width: 768px) {
            .admin-header { padding: 12px 0; }
            .admin-header h2 { font-size: 16px; }
            .pen-section { padding: 100px 0 60px !important; }
            .pen-section .section-title h2 { font-size: 24px; }
            .dashboard-card { padding: 20px 16px; }
            .btn-logout { padding: 8px 14px; font-size: 13px; }
            .btn-program-action { width: 100%; }
        }
    </style>
</head>
<body>
    @auth
    {{-- Member header with logout --}}
    <div class="admin-page">
        <header class="admin-header">
            <div class="container" style="max-width:1200px;margin:0 auto;padding:0 20px;">
                <h2 style="font-size:18px;">Pendaftaran Program</h2>
                <div class="admin-header-right">
                    <a href="{{ route('member.dashboard') }}" style="color:rgba(255,255,255,0.7);font-size:13px;">Dashboard</a>
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn-logout">Logout</button>
                    </form>
                </div>
            </div>
        </header>
        <main class="admin-main">
            <div class="pendaftaran-form">
                @if(session('success'))
                    <div class="alert-success">{{ session('success') }}</div>
                @endif

                <div class="section-title" style="margin-bottom:36px;text-align:center;">
                    <h2 style="font-size:28px;">Pendaftaran Program</h2>
                    <p style="color:var(--gray-500);">Daftar program yang kamu minati</p>
                </div>

                <div class="dashboard-card">
                    <h3 style="margin-bottom:20px;">Pilih Program</h3>
                    <form action="{{ route('pendaftaran.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="program">Program</label>
                            <select id="program" name="program" required style="width:100%;padding:12px 16px;border:1.5px solid var(--gray-200);border-radius:10px;font-size:15px;outline:none;background:var(--gray-50);color:var(--gray-900);">
                                <option value="">— Pilih Program —</option>
                                @foreach($programs as $p)
                                    <option value="{{ $p->nama }}">{{ $p->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <p style="color:var(--gray-400);font-size:13px;margin-bottom:20px;">
                            Kamu terdaftar sebagai: <strong>{{ auth()->user()->name }}</strong> ({{ auth()->user()->email }})
                        </p>
                        <button type="submit" class="btn-submit btn-program-action">Kirim Pendaftaran</button>
                    </form>
                    <p style="text-align:center;margin-top:20px;">
                        <a href="{{ route('member.dashboard') }}" style="color:var(--gray-400);font-size:13px;">← Kembali ke Dashboard</a>
                    </p>
                </div>
            </div>
        </main>
    </div>
    @else
    {{-- Guest (not logged in) --}}
    <section style="padding:120px 0 80px;">
        <div class="container" style="max-width:640px;">
            <div class="section-title">
                <h2>Pendaftaran Program</h2>
                <p>Daftar program yang kamu minati</p>
            </div>
            <div class="dashboard-card" style="text-align:center;padding:60px 40px;">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--gray-300)" stroke-width="1.5" style="margin:0 auto 16px;display:block;"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                <p style="color:var(--gray-500);margin-bottom:16px;">Silakan login atau daftar terlebih dahulu untuk mendaftar program.</p>
                <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;">
                    <a href="{{ route('login') }}" class="btn-login">Login</a>
                    <a href="{{ route('register') }}" class="btn-login" style="background:var(--teal-500);">Daftar</a>
                </div>
            </div>
        </div>
    </section>
    @endauth
</body>
</html>
