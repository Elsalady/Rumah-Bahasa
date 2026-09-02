<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Kelas — Rumah Bahasa Surabaya</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        * { box-sizing: border-box; }
        .admin-header .container { display:flex; align-items:center; justify-content:space-between; gap:12px; }
        .admin-header-right { display:flex; align-items:center; gap:12px; }
        .btn-logout { font-size:14px; font-weight:700; color:var(--teal-900); background:#fff; border:none; border-radius:8px; padding:10px 20px; cursor:pointer; box-shadow:0 4px 12px rgba(0,0,0,0.1); white-space:nowrap; }
        .btn-logout:hover { background:#f1f5f9; }
        .header-title-wrapper { display:flex; align-items:center; gap:12px; }
        .btn-back-header { display:inline-flex; align-items:center; color:var(--white); text-decoration:none; }
        .btn-back-header:hover { transform: translateX(-3px); }
        .jadwal-day { margin-bottom:28px; }
        .jadwal-day-title { font-size:16px; font-weight:700; color:var(--teal-700); margin:0 0 12px; padding-bottom:8px; border-bottom:2px solid var(--teal-100); }
        .jadwal-item { display:flex; align-items:center; gap:14px; padding:14px 16px; background:#fff; border:1px solid var(--gray-100); border-radius:12px; margin-bottom:10px; flex-wrap:wrap; box-shadow:0 2px 8px rgba(0,0,0,0.04); }
        .jadwal-item:hover { box-shadow:0 4px 16px rgba(0,0,0,0.08); }
        .jadwal-time { font-weight:700; font-size:14px; color:var(--gray-900); min-width:110px; }
        .jadwal-nama { font-size:14px; font-weight:600; color:var(--gray-900); margin:0; }
        .jadwal-meta { font-size:12px; color:var(--gray-500); margin:2px 0 0; }
        .badge { display:inline-block; padding:3px 10px; border-radius:50px; font-size:11px; font-weight:600; }
        .badge-tematik { background:#e0f2fe; color:#0369a1; }
        .badge-tentative { background:#fef3c7; color:#b45309; }
        .badge-online { background:#e0f2fe; color:#0369a1; }
        .badge-offline { background:#ecfdf5; color:#166534; }
        @media (max-width:768px) { .admin-header { padding:12px 0; } .admin-header h2 { font-size:16px; } .admin-main { padding:16px; } }
    </style>
</head>
<body>
    <div class="admin-page">
        <header class="admin-header">
            <div class="container" style="max-width:900px;margin:0 auto;padding:0 20px;">
                <div class="header-title-wrapper">
                    <a href="{{ route('member.dashboard') }}" class="btn-back-header" title="Kembali ke Dashboard">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                    </a>
                    <h2 style="font-size:18px;">Jadwal Kelas</h2>
                </div>
                <div class="admin-header-right">
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">@csrf
                        <button type="submit" class="btn-logout">Logout</button>
                    </form>
                </div>
            </div>
        </header>
        <main class="admin-main">
            <div class="container" style="max-width:900px;margin:0 auto;padding:0 20px;">

                <div style="text-align:center;margin-bottom:28px;">
                    <h1 style="font-size:24px;font-weight:800;color:var(--gray-900);margin-bottom:6px;">Jadwal Kelas Minggu Ini</h1>
                    <p style="color:var(--gray-500);font-size:14px;margin:0;">
                        {{ \Carbon\Carbon::now()->startOfWeek()->translatedFormat('l, d M') }} — {{ \Carbon\Carbon::now()->endOfWeek()->translatedFormat('l, d M Y') }}
                    </p>
                </div>

                @if($jadwal->count())
                    @foreach($hariList as $hari)
                        @if(isset($jadwal[$hari]) && $jadwal[$hari]->count())
                            <div class="jadwal-day">
                                <h3 class="jadwal-day-title">{{ $hari }}</h3>
                                @foreach($jadwal[$hari] as $item)
                                    <div class="jadwal-item">
                                        <div style="flex:1;min-width:160px;">
                                            <p class="jadwal-nama">{{ $item->nama_kelas }}</p>
                                            <p class="jadwal-meta">
                                                @if($item->tanggal)
                                                    {{ $item->tanggal->timezone('Asia/Jakarta')->locale('id')->isoFormat('D MMM YYYY') }} &middot;
                                                @endif
                                                {{ \Carbon\Carbon::parse($item->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($item->jam_selesai)->format('H:i') }} WIB
                                                @if($item->pengajar)
                                                    &middot; {{ $item->pengajar }}
                                                @endif
                                            </p>
                                        </div>
                                        <div style="display:flex;align-items:center;gap:6px;flex-wrap:wrap;">
                                            <span class="badge {{ $item->jenis === 'tematik' ? 'badge-tematik' : 'badge-tentative' }}">{{ ucfirst($item->jenis) }}</span>
                                            <span class="badge {{ $item->mode === 'online' ? 'badge-online' : 'badge-offline' }}">{{ ucfirst($item->mode) }}</span>
                                            @if($item->ruangan_link)
                                                <span style="font-size:12px;color:var(--gray-500);background:var(--gray-50);padding:3px 10px;border-radius:50px;">
                                                    {{ $item->mode === 'online' ? '🔗' : '📍' }} {{ $item->ruangan_link }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @endforeach
                @else
                    <div style="text-align:center;padding:60px 20px;background:#fff;border:1px solid var(--gray-100);border-radius:16px;">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--gray-300)" stroke-width="1.5" style="margin:0 auto 16px;display:block;">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                        <p style="color:var(--gray-500);font-size:15px;margin:0 0 6px;">Belum ada jadwal kelas minggu ini.</p>
                        <p style="color:var(--gray-400);font-size:13px;margin:0;">Cek kembali nanti setelah admin mengatur jadwal.</p>
                    </div>
                @endif
            </div>
        </main>
    </div>
</body>
</html>
