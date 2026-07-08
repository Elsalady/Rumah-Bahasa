<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Member — Rumah Belajar Surabaya</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="admin-page">
        <header class="admin-header">
            <div class="container">
                <h2>Dashboard Member</h2>
                <div class="admin-header-right">
                    <span>{{ $user->name }}</span>
                    <a href="{{ route('member.edit') }}" class="btn-logout" style="background:rgba(255,255,255,0.15);">Edit Profil</a>
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn-logout">Logout</button>
                    </form>
                </div>
            </div>
        </header>

        <main class="admin-main">
            <div class="container" style="max-width:900px;margin:0 auto;">
                @if(session('success'))
                    <div class="alert-success">{{ session('success') }}</div>
                @endif

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:32px;align-items:start;">

                    {{-- Profil --}}
                    <div class="dashboard-card" style="text-align:center;padding:40px;">
                        <div style="width:80px;height:80px;border-radius:50%;background:var(--teal-50);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="var(--teal-700)" stroke-width="1.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        </div>
                        <h3 style="font-size:22px;font-weight:700;color:var(--gray-900);">{{ $user->name }}</h3>
                        <p style="color:var(--gray-500);margin-bottom:8px;">{{ $user->email }}</p>
                        <span style="display:inline-block;padding:4px 16px;background:var(--teal-50);color:var(--teal-700);border-radius:50px;font-size:13px;font-weight:500;">Member</span>
                        <div style="margin-top:24px;text-align:left;display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                            <div><p style="font-size:11px;color:var(--gray-400);text-transform:uppercase;">Telepon</p><p style="color:var(--gray-700);font-weight:500;">{{ $user->phone ?: '-' }}</p></div>
                            <div><p style="font-size:11px;color:var(--gray-400);text-transform:uppercase;">Bergabung</p><p style="color:var(--gray-700);font-weight:500;">{{ $user->created_at->locale('id')->isoFormat('D MMM YYYY') }}</p></div>
                        </div>
                        <div style="margin-top:12px;">
                            <p style="font-size:11px;color:var(--gray-400);text-transform:uppercase;margin-bottom:4px;">Alamat</p>
                            <p style="color:var(--gray-700);font-weight:500;">{{ $user->address ?: '-' }}</p>
                        </div>
                    </div>

                    {{-- Pendaftaran --}}
                    <div class="dashboard-card" style="padding:24px;">
                        <h3>Histori Pendaftaran</h3>
                        @if($pendaftaran->count())
                            @foreach($pendaftaran as $p)
                                <div style="display:flex;justify-content:space-between;align-items:center;padding:14px 0;border-bottom:1px solid var(--gray-100);">
                                    <div>
                                        <p style="font-weight:600;color:var(--gray-900);">{{ $p->program }}</p>
                                        <p style="font-size:12px;color:var(--gray-400);">{{ $p->created_at->locale('id')->isoFormat('D MMM YYYY') }}</p>
                                    </div>
                                    <span style="font-size:11px;font-weight:600;padding:3px 10px;border-radius:50px;
                                        {{ $p->status === 'confirmed' ? 'background:#ecfdf5;color:#166534;' : '' }}
                                        {{ $p->status === 'rejected' ? 'background:#fef2f2;color:#dc2626;' : '' }}
                                        {{ $p->status === 'pending' ? 'background:#fffbeb;color:#b45309;' : '' }}">
                                        {{ ucfirst($p->status) }}
                                    </span>
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted" style="text-align:center;padding:24px;">Belum ada pendaftaran.</p>
                        @endif
                        <div style="margin-top:20px;display:flex;gap:10px;">
                            <a href="{{ route('pendaftaran') }}" class="btn-login" style="flex:1;text-align:center;font-size:13px;">Daftar Program</a>
                            <a href="{{ route('layanan') }}" class="btn-login" style="flex:1;text-align:center;font-size:13px;background:var(--teal-500);">Lihat Program</a>
                        </div>
                    </div>
                </div>

                <p style="text-align:center;margin-top:24px;">
                    <a href="{{ route('home') }}" style="color:var(--gray-400);font-size:13px;">← Kembali ke Beranda</a>
                </p>
            </div>
        </main>
    </div>
</body>
</html>
