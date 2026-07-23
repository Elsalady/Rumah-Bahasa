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
        .jadwal-card { background:#fff; border:1px solid var(--gray-100); border-radius:12px; padding:16px 20px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; box-shadow:0 2px 8px rgba(0,0,0,0.04); transition:box-shadow 0.2s; }
        .jadwal-card:hover { box-shadow:0 4px 16px rgba(0,0,0,0.08); }
        @media (max-width:768px) { .admin-header { padding:12px 0; } .admin-header h2 { font-size:16px; } .admin-main { padding:16px; } }
    </style>
</head>
<body>
    <div class="admin-page">
        <header class="admin-header">
            <div class="container" style="max-width:1200px;margin:0 auto;padding:0 20px;">
                <h2 style="font-size:18px;">Jadwal Kelas</h2>
                <div class="admin-header-right">
                    <a href="{{ route('member.dashboard') }}" style="color:rgba(255,255,255,0.7);font-size:13px;">Dashboard</a>
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">@csrf
                        <button type="submit" class="btn-logout">Logout</button>
                    </form>
                </div>
            </div>
        </header>
        <main class="admin-main">
            <div class="container" style="max-width:900px;margin:0 auto;padding:0 20px;">

                <div style="text-align:center;margin-bottom:32px;">
                    <h1 style="font-size:28px;font-weight:800;color:var(--gray-900);margin-bottom:8px;">Jadwal Kelas</h1>
                    <p style="color:var(--gray-500);font-size:14px;">Jadwal kelas Rumah Bahasa Surabaya</p>
                </div>

                {{-- Keterangan --}}
                <div style="display:flex;gap:16px;flex-wrap:wrap;justify-content:center;margin-bottom:28px;">
                    <div style="display:flex;align-items:center;gap:8px;background:#f8fafc;padding:8px 14px;border-radius:10px;font-size:12px;">
                        <span style="display:inline-block;width:10px;height:10px;border-radius:50%;background:#0369a1;"></span>
                        <strong>Tematik</strong> — Kelas rutin jadwal tetap
                    </div>
                    <div style="display:flex;align-items:center;gap:8px;background:#f8fafc;padding:8px 14px;border-radius:10px;font-size:12px;">
                        <span style="display:inline-block;width:10px;height:10px;border-radius:50%;background:#b45309;"></span>
                        <strong>Tentative</strong> — Kelas kondisional/jadwal dapat berubah
                    </div>
                </div>

                @if($jadwal->count())
                    @php $hariList = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu']; @endphp
                    @foreach($hariList as $hari)
                        @if(isset($jadwal[$hari]))
                            <div style="margin-bottom:28px;">
                                <h3 style="font-size:18px;font-weight:700;color:var(--teal-700);margin-bottom:12px;padding-bottom:8px;border-bottom:2px solid var(--teal-100);">{{ $hari }}</h3>
                                <div style="display:grid;gap:10px;">
                                    @foreach($jadwal[$hari] as $item)
                                        <div class="jadwal-card">
                                            <div style="flex:1;min-width:160px;">
                                                <p style="font-weight:700;font-size:14px;color:var(--gray-900);margin:0;">{{ $item->nama_kelas }}</p>
                                                <p style="font-size:12px;color:var(--gray-500);margin:4px 0 0;">
                                                    {{ \Carbon\Carbon::parse($item->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($item->jam_selesai)->format('H:i') }}
                                                    @if($item->pengajar) &middot; {{ $item->pengajar }} @endif
                                                </p>
                                            </div>
                                            <div style="display:flex;align-items:center;gap:6px;flex-wrap:wrap;">
                                                <span style="display:inline-block;padding:2px 8px;border-radius:50px;font-size:11px;font-weight:600;{{ $item->jenis === 'tematik' ? 'background:#e0f2fe;color:#0369a1;' : 'background:#fef3c7;color:#b45309;' }}">{{ ucfirst($item->jenis) }}</span>
                                                <span style="display:inline-block;padding:2px 8px;border-radius:50px;font-size:11px;font-weight:600;{{ $item->mode === 'online' ? 'background:#e0f2fe;color:#0369a1;' : 'background:#ecfdf5;color:#166534;' }}">{{ ucfirst($item->mode) }}</span>
                                                @if($item->ruangan_link)
                                                    <span style="font-size:11px;color:var(--gray-500);background:var(--gray-50);padding:2px 8px;border-radius:50px;">{{ $item->mode === 'online' ? '🔗' : '📍' }} {{ $item->ruangan_link }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                @else
                    <div style="text-align:center;padding:60px 20px;">
                        <p style="color:var(--gray-400);">Belum ada jadwal kelas yang tersedia.</p>
                    </div>
                @endif

                <p style="text-align:center;margin-top:32px;">
                    <a href="{{ route('member.dashboard') }}" style="color:var(--gray-400);font-size:13px;">← Kembali ke Dashboard</a>
                </p>
            </div>
        </main>
    </div>
</body>
</html>
