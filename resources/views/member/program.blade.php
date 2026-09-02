<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Program — Rumah Bahasa Surabaya</title>
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
        .program-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(280px,1fr)); gap:24px; margin-top:24px; }
        .program-card { background:#fff; border:1px solid var(--gray-100); border-radius:16px; padding:24px; box-shadow:0 2px 8px rgba(0,0,0,0.04); transition:box-shadow 0.2s,transform 0.2s; display:flex; flex-direction:column; }
        .program-card:hover { box-shadow:0 8px 24px rgba(0,0,0,0.08); transform:translateY(-2px); }
        .program-card .card-body { flex:1; }
        .btn-daftar { display:inline-block; width:100%; text-align:center; padding:10px 16px; background:#0882c4; color:#fff; border:none; border-radius:8px; font-size:13px; font-weight:600; cursor:pointer; transition:background 0.2s; margin-top:16px; text-decoration:none; }
        .btn-daftar:hover { background:#0167a2; }

        @media (max-width: 768px) {
            .program-grid { grid-template-columns: repeat(auto-fill,minmax(240px,1fr)); gap: 16px; }
        }

        @media (max-width: 480px) {
            .admin-main { padding: 16px 0 !important; }
            .container[style*="max-width:900px"] { padding: 0 12px !important; }
            h1[style*="font-size:28px"] { font-size: 22px !important; }
            .program-grid { grid-template-columns: 1fr; gap: 12px; }
            .program-card { padding: 16px; }
            .program-card h3 { font-size: 16px !important; }
            .btn-daftar { font-size: 12px; padding: 8px 12px; }
            h2[style*="font-size:20px"] { font-size: 17px !important; }
            [style*="gap:12px;flex-wrap:wrap"] > div { font-size: 11px !important; padding: 4px 10px !important; }
        }
    </style>
</head>
<body>
    <div class="admin-page">
        <header class="admin-header">
            <div class="container" style="max-width:1200px;margin:0 auto;padding:0 20px;">
                <div class="header-title-wrapper">
                    <a href="{{ route('member.dashboard') }}" class="btn-back-header" title="Kembali ke Dashboard">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                    </a>
                    <h2 style="font-size:18px;">Program</h2>
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

                {{-- Header --}}
                <div style="text-align:center;margin-bottom:32px;">
                    <h1 style="font-size:28px;font-weight:800;color:var(--gray-900);margin-bottom:8px;">Program Kelas</h1>
                    <p style="color:var(--gray-500);font-size:14px;">Lihat program dan daftar langsung di sini</p>
                </div>

                @if(session('success'))
                    <div class="alert-success">{{ session('success') }}</div>
                @endif

                {{-- ===== PROGRAM ===== --}}
                <h2 style="font-size:20px;font-weight:700;color:var(--gray-900);margin-bottom:4px;">Daftar Program</h2>
                <p style="font-size:13px;color:var(--gray-400);margin-bottom:16px;">Pilih program dan klik daftar untuk mendaftar</p>

                @if($programs->count())
                    <div class="program-grid">
                        @foreach($programs as $item)
                            <div class="program-card">
                                <div class="card-body" style="display:flex;flex-direction:column;align-items:center;text-align:center;justify-content:center;">
                                    @if($item->ikon)
                                        <div style="font-size:40px;margin-bottom:12px;">{!! $item->ikon !!}</div>
                                    @endif
                                    <h3 style="font-size:18px;font-weight:700;color:var(--gray-900);margin:0;">{{ $item->nama }}</h3>
                                    @if(in_array($item->nama, $programTerdaftar))
                                        <span style="display:inline-flex;align-items:center;gap:6px;margin-top:10px;padding:4px 12px;border-radius:50px;font-size:11px;font-weight:600;background:#ecfdf5;color:#166534;">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                                            Terdaftar
                                        </span>
                                    @elseif(!in_array($item->id, $jadwalIds))
                                        <span style="display:inline-flex;align-items:center;gap:6px;margin-top:10px;padding:4px 12px;border-radius:50px;font-size:11px;font-weight:600;background:#fef3c7;color:#b45309;">
                                            Jadwal belum tersedia
                                        </span>
                                    @endif
                                </div>
                                <a href="{{ route('member.program.detail', $item->nama) }}" class="btn-daftar" style="text-decoration:none;
                                    {{ in_array($item->nama, $programTerdaftar) ? 'background:#059669;color:#fff;' : (!in_array($item->id, $jadwalIds) ? 'background:#e5e7eb;color:#9ca3af;cursor:not-allowed;' : '') }}">
                                    @if(in_array($item->nama, $programTerdaftar))
                                        Lihat Kelas
                                    @elseif(!in_array($item->id, $jadwalIds))
                                        Daftar Tidak Tersedia
                                    @else
                                        Daftar
                                    @endif
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div style="text-align:center;padding:60px 20px;">
                        <div style="width:64px;height:64px;margin:0 auto 16px;border-radius:50%;background:var(--gray-100);display:flex;align-items:center;justify-content:center;color:var(--gray-400);">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        </div>
                        <p style="color:var(--gray-500);font-size:15px;font-weight:600;margin:0 0 6px;">Belum ada program tersedia</p>
                        <p style="color:var(--gray-400);font-size:13px;margin:0;">Admin belum menambahkan program kelas. Silakan cek kembali nanti.</p>
                    </div>
                @endif
            </div>
        </main>
    </div>
</body>
</html>
