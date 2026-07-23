<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Program & Pendaftaran — Rumah Bahasa Surabaya</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        * { box-sizing: border-box; }
        .admin-header .container { display:flex; align-items:center; justify-content:space-between; gap:12px; }
        .admin-header-right { display:flex; align-items:center; gap:12px; }
        .btn-logout { font-size:14px; font-weight:700; color:var(--teal-900); background:#fff; border:none; border-radius:8px; padding:10px 20px; cursor:pointer; box-shadow:0 4px 12px rgba(0,0,0,0.1); white-space:nowrap; }
        .btn-logout:hover { background:#f1f5f9; }
        .program-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(280px,1fr)); gap:24px; margin-top:24px; }
        .program-card { background:#fff; border:1px solid var(--gray-100); border-radius:16px; padding:24px; box-shadow:0 2px 8px rgba(0,0,0,0.04); transition:box-shadow 0.2s,transform 0.2s; }
        .program-card:hover { box-shadow:0 8px 24px rgba(0,0,0,0.08); transform:translateY(-2px); }
        .jadwal-card { background:#fff; border:1px solid var(--gray-100); border-radius:12px; padding:14px 18px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; box-shadow:0 2px 8px rgba(0,0,0,0.04); transition:box-shadow 0.2s; }
        .jadwal-card:hover { box-shadow:0 4px 16px rgba(0,0,0,0.08); }
        .section-divider { border:none; border-top:2px solid var(--teal-100); margin:40px 0; }
        @media (max-width:768px) { .admin-header { padding:12px 0; } .admin-header h2 { font-size:16px; } .admin-main { padding:16px; } }
    </style>
</head>
<body>
    <div class="admin-page">
        <header class="admin-header">
            <div class="container" style="max-width:1200px;margin:0 auto;padding:0 20px;">
                <h2 style="font-size:18px;">Program & Pendaftaran</h2>
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

                {{-- Header --}}
                <div style="text-align:center;margin-bottom:32px;">
                    <h1 style="font-size:28px;font-weight:800;color:var(--gray-900);margin-bottom:8px;">Program Rumah Bahasa</h1>
                    <p style="color:var(--gray-500);font-size:14px;">Lihat program, jadwal kelas, dan daftar langsung di sini</p>
                </div>

                {{-- ===== PROGRAM ===== --}}
                <h2 style="font-size:20px;font-weight:700;color:var(--gray-900);margin-bottom:4px;">Daftar Program</h2>
                <p style="font-size:13px;color:var(--gray-400);margin-bottom:16px;">Pilih program yang sesuai dengan kebutuhanmu</p>

                @if($programs->count())
                    <div class="program-grid">
                        @foreach($programs as $item)
                            <div class="program-card">
                                @if($item->ikon)
                                    <div style="font-size:32px;margin-bottom:12px;">{!! $item->ikon !!}</div>
                                @endif
                                <h3 style="font-size:18px;font-weight:700;color:var(--gray-900);margin:0 0 8px;">{{ $item->nama }}</h3>
                                <p style="font-size:13px;color:var(--gray-500);line-height:1.6;margin:0;">{{ $item->deskripsi }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div style="text-align:center;padding:40px 20px;">
                        <p style="color:var(--gray-400);">Belum ada program yang tersedia.</p>
                    </div>
                @endif

                <hr class="section-divider">

                {{-- ===== JADWAL KELAS ===== --}}
                <h2 style="font-size:20px;font-weight:700;color:var(--gray-900);margin-bottom:4px;">Jadwal Kelas</h2>
                <p style="font-size:13px;color:var(--gray-400);margin-bottom:6px;">Jadwal kelas Rumah Bahasa Surabaya</p>

                <div style="display:flex;gap:12px;flex-wrap:wrap;margin-bottom:20px;">
                    <div style="display:flex;align-items:center;gap:6px;background:#f8fafc;padding:6px 12px;border-radius:8px;font-size:12px;">
                        <span style="display:inline-block;width:8px;height:8px;border-radius:50%;background:#0369a1;"></span>
                        <strong>Tematik</strong> — Kelas rutin jadwal tetap
                    </div>
                    <div style="display:flex;align-items:center;gap:6px;background:#f8fafc;padding:6px 12px;border-radius:8px;font-size:12px;">
                        <span style="display:inline-block;width:8px;height:8px;border-radius:50%;background:#b45309;"></span>
                        <strong>Tentative</strong> — Kelas kondisional
                    </div>
                </div>

                @if($jadwal->count())
                    @php $hariList = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu']; @endphp
                    @foreach($hariList as $hari)
                        @if(isset($jadwal[$hari]))
                            <div style="margin-bottom:20px;">
                                <h4 style="font-size:16px;font-weight:700;color:var(--teal-700);margin-bottom:8px;padding-bottom:6px;border-bottom:2px solid var(--teal-100);">{{ $hari }}</h4>
                                <div style="display:grid;gap:8px;">
                                    @foreach($jadwal[$hari] as $item)
                                        <div class="jadwal-card">
                                            <div style="flex:1;min-width:140px;">
                                                <p style="font-weight:700;font-size:14px;color:var(--gray-900);margin:0;">{{ $item->nama_kelas }}</p>
                                                <p style="font-size:12px;color:var(--gray-500);margin:3px 0 0;">
                                                    {{ \Carbon\Carbon::parse($item->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($item->jam_selesai)->format('H:i') }}
                                                    @if($item->pengajar) &middot; {{ $item->pengajar }} @endif
                                                </p>
                                            </div>
                                            <div style="display:flex;align-items:center;gap:5px;flex-wrap:wrap;">
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
                    <div style="text-align:center;padding:30px 20px;">
                        <p style="color:var(--gray-400);">Belum ada jadwal kelas yang tersedia.</p>
                    </div>
                @endif

                <hr class="section-divider">

                {{-- ===== FORM DAFTAR PROGRAM ===== --}}
                <div style="max-width:500px;margin:0 auto;">
                    <div class="dashboard-card" style="padding:28px;">
                        <h3 style="margin-bottom:16px;">Daftar Program</h3>
                        <form action="{{ route('pendaftaran.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="program">Pilih Program</label>
                                <select id="program" name="program" required style="width:100%;padding:12px 16px;border:1.5px solid var(--gray-200);border-radius:10px;font-size:15px;outline:none;background:var(--gray-50);color:var(--gray-900);">
                                    <option value="">— Pilih Program —</option>
                                    @foreach($programs as $p)
                                        <option value="{{ $p->nama }}">{{ $p->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <p style="color:var(--gray-400);font-size:13px;margin-bottom:16px;">
                                Kamu terdaftar sebagai: <strong>{{ auth()->user()->name }}</strong> ({{ auth()->user()->email }})
                            </p>
                            <button type="submit" class="btn-submit">Kirim Pendaftaran</button>
                        </form>
                    </div>
                </div>

                <p style="text-align:center;margin-top:24px;">
                    <a href="{{ route('member.dashboard') }}" style="color:var(--gray-400);font-size:13px;">← Kembali ke Dashboard</a>
                </p>
            </div>
        </main>
    </div>
</body>
</html>
