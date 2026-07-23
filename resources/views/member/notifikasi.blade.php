<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi — Rumah Bahasa Surabaya</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        * { box-sizing: border-box; }
        .admin-header .container { display:flex; align-items:center; justify-content:space-between; gap:12px; }
        .admin-header-right { display:flex; align-items:center; gap:12px; }
        .btn-logout { font-size:14px; font-weight:700; color:var(--teal-900); background:#fff; border:none; border-radius:8px; padding:10px 20px; cursor:pointer; box-shadow:0 4px 12px rgba(0,0,0,0.1); white-space:nowrap; }
        .btn-logout:hover { background:#f1f5f9; }
        .notif-item { display:flex; align-items:flex-start; gap:12px; padding:16px 0; border-bottom:1px solid var(--gray-100); }
        .notif-dot { width:8px; height:8px; border-radius:50%; flex-shrink:0; margin-top:6px; }
        @media (max-width:768px) { .admin-header { padding:12px 0; } .admin-main { padding:16px; } }
    </style>
</head>
<body>
    <div class="admin-page">
        <header class="admin-header">
            <div class="container" style="max-width:1200px;margin:0 auto;padding:0 20px;">
                <h2 style="font-size:18px;">Notifikasi</h2>
                <div class="admin-header-right">
                    <a href="{{ route('member.dashboard') }}" style="color:rgba(255,255,255,0.7);font-size:13px;">Dashboard</a>
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">@csrf
                        <button type="submit" class="btn-logout">Logout</button>
                    </form>
                </div>
            </div>
        </header>
        <main class="admin-main">
            <div class="container" style="max-width:700px;margin:0 auto;padding:0 20px;">

                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
                    <h1 style="font-size:22px;font-weight:700;color:var(--gray-900);margin:0;">Notifikasi</h1>
                    @if($notifikasi->where('is_read', false)->count())
                        <a href="{{ route('member.notifikasi.baca.semua') }}" style="font-size:13px;color:var(--teal-600);">Tandai semua sudah dibaca</a>
                    @endif
                </div>

                @if($notifikasi->count())
                    @foreach($notifikasi as $notif)
                        <a href="{{ route('member.notifikasi.baca', $notif->id) }}" style="text-decoration:none;color:inherit;">
                            <div class="notif-item" style="{{ $notif->is_read ? 'opacity:0.7;' : '' }}">
                                <div class="notif-dot" style="background:{{ $notif->is_read ? 'var(--gray-200)' : 'var(--teal-500)' }};"></div>
                                <div style="flex:1;">
                                    <p style="font-weight:600;font-size:14px;color:var(--gray-900);margin:0;">{{ $notif->judul }}</p>
                                    <p style="font-size:13px;color:var(--gray-500);margin:4px 0 0;">{{ $notif->pesan }}</p>
                                    <p style="font-size:11px;color:var(--gray-400);margin:4px 0 0;">{{ $notif->created_at->locale('id')->isoFormat('D MMM YYYY, HH:mm') }}</p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                @else
                    <div style="text-align:center;padding:60px 20px;">
                        <p style="color:var(--gray-400);">Belum ada notifikasi.</p>
                    </div>
                @endif

                <p style="text-align:center;margin-top:24px;">
                    <a href="{{ route('member.dashboard') }}" style="color:var(--gray-400);font-size:13px;">← Kembali ke Dashboard</a>
                </p>
            </div>
        </main>
    </div>
</body>
</html>
