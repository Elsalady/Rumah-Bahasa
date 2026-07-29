<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $program->nama }} — Rumah Bahasa Surabaya</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        * { box-sizing: border-box; }
        .admin-header .container { display:flex; align-items:center; justify-content:space-between; gap:12px; }
        .admin-header-right { display:flex; align-items:center; gap:12px; }
        .btn-logout { font-size:14px; font-weight:700; color:var(--teal-900); background:#fff; border:none; border-radius:8px; padding:10px 20px; cursor:pointer; box-shadow:0 4px 12px rgba(0,0,0,0.1); white-space:nowrap; }
        .btn-logout:hover { background:#f1f5f9; }
        .jadwal-card { background:#fff; border:1px solid var(--gray-100); border-radius:12px; padding:14px 18px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; box-shadow:0 2px 8px rgba(0,0,0,0.04); transition:box-shadow 0.2s; }
        .jadwal-card:hover { box-shadow:0 4px 16px rgba(0,0,0,0.08); }
        .detail-header { background:linear-gradient(135deg,#0167a2,#1680bd); border-radius:16px; padding:32px; color:#fff; margin-bottom:28px; }
        .btn-back { display:inline-flex;align-items:center;gap:6px;color:#fff;font-size:13px;text-decoration:none;margin-bottom:16px;font-weight:600; }
        .btn-back:hover { color:#fff; }
        @media (max-width:768px) { .admin-header { padding:12px 0; } .admin-header h2 { font-size:16px; } .admin-main { padding:16px; } .detail-header { padding:24px 20px; } }
    </style>
</head>
<body>
    <div class="admin-page">
        <header class="admin-header">
            <div class="container" style="max-width:1200px;margin:0 auto;padding:0 20px;">
                <h2 style="font-size:18px;">Detail Program</h2>
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

                @if(session('success'))
                    <div class="alert-success">{{ session('success') }}</div>
                @endif

                {{-- Info Kuota --}}
                @php
                    $totalKuota = 0;
                    foreach ($jadwal as $hariJadwal) {
                        foreach ($hariJadwal as $j) {
                            $totalKuota += $j->kuota;
                        }
                    }
                    $sisaKuota = $totalKuota - $confirmedCount;
                @endphp
                @if($totalKuota > 0)
                    <div style="display:flex;gap:16px;flex-wrap:wrap;margin-bottom:24px;padding:16px 20px;background:#f8fafc;border-radius:12px;border:1px solid #e5e7eb;">
                        <div style="display:flex;align-items:center;gap:8px;font-size:14px;">
                            <span style="font-weight:600;color:var(--gray-900);">👥 Total Kuota:</span>
                            <span style="font-weight:700;color:#1e40af;">{{ $totalKuota }}</span>
                        </div>
                        <div style="display:flex;align-items:center;gap:8px;font-size:14px;">
                            <span style="font-weight:600;color:var(--gray-900);">✅ Terdaftar:</span>
                            <span style="font-weight:700;color:#166534;">{{ $confirmedCount }}</span>
                        </div>
                        <div style="display:flex;align-items:center;gap:8px;font-size:14px;">
                            <span style="font-weight:600;color:var(--gray-900);">📌 Sisa Kuota:</span>
                            <span style="font-weight:700;{{ $sisaKuota > 0 ? 'color:#b45309;' : 'color:#dc2626;' }}">{{ max(0, $sisaKuota) }}</span>
                        </div>
                    </div>
                @endif

                {{-- Link Grup WA (setelah daftar) --}}
                @if($baruDaftar && $program->link_wa)
                    <div style="padding:20px 24px;background:linear-gradient(135deg,#ecfdf5,#d1fae5);border:1px solid #6ee7b7;border-radius:12px;margin-bottom:24px;text-align:center;">
                        <p style="font-size:15px;font-weight:700;color:#166534;margin:0 0 8px;">🎉 Kamu berhasil mendaftar {{ $program->nama }}!</p>
                        <p style="font-size:13px;color:#065f46;margin:0 0 12px;">Gabung grup WhatsApp untuk info lebih lanjut:</p>
                        <a href="{{ $program->link_wa }}" target="_blank" rel="noopener" style="display:inline-flex;align-items:center;gap:8px;padding:12px 24px;background:#25d366;color:#fff;border-radius:8px;font-size:14px;font-weight:600;text-decoration:none;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            Gabung Grup WhatsApp
                        </a>
                    </div>
                @endif

                {{-- Header Program --}}
                <div class="detail-header">
                    <a href="{{ route('member.program') }}" class="btn-back">← Kembali ke Program</a>
                    <div style="display:flex;align-items:center;gap:16px;flex-wrap:wrap;">
                        @if($program->ikon)
                            <div style="font-size:48px;">{!! $program->ikon !!}</div>
                        @endif
                        <div>
                            <h1 style="font-size:26px;font-weight:800;margin:0 0 6px;">{{ $program->nama }}</h1>
                            <p style="font-size:14px;color:rgba(255,255,255,0.8);margin:0;line-height:1.6;">{{ $program->deskripsi }}</p>
                        </div>
                    </div>
                </div>

                {{-- Jadwal Terkait --}}
                <div style="margin-bottom:28px;">
                    <h2 style="font-size:20px;font-weight:700;color:var(--gray-900);margin-bottom:4px;">Jadwal Kelas</h2>
                    <p style="font-size:13px;color:var(--gray-400);margin-bottom:12px;">Jadwal yang tersedia untuk program ini</p>

                    @if($jadwal->count())
                        @php $hariList = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu']; @endphp
                        @foreach($hariList as $hari)
                            @if(isset($jadwal[$hari]))
                                <div style="margin-bottom:16px;">
                                    <h4 style="font-size:15px;font-weight:700;color:var(--teal-700);margin-bottom:6px;padding-bottom:4px;border-bottom:2px solid var(--teal-100);">{{ $hari }}</h4>
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
                                                    @if($item->kuota > 0)
                                                        <span style="display:inline-block;padding:2px 8px;border-radius:50px;font-size:11px;font-weight:600;background:#eff6ff;color:#1e40af;">👥 Kuota: {{ $item->kuota }}</span>
                                                    @endif
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
                        <div style="text-align:center;padding:30px 20px;background:#f8fafc;border-radius:12px;">
                            <p style="color:var(--gray-400);margin:0;">Belum ada jadwal untuk program ini.</p>
                        </div>
                    @endif
                </div>

                {{-- Tombol Daftar --}}
                <div style="max-width:400px;margin:0 auto;">
                    <div class="dashboard-card" style="padding:28px;text-align:center;">
                        @if($sudahTerdaftar)
                            <div style="display:inline-flex;align-items:center;gap:8px;padding:12px 24px;background:#ecfdf5;color:#166534;border-radius:8px;font-size:15px;font-weight:600;">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                                Kamu sudah terdaftar
                            </div>
                            <p style="color:var(--gray-400);font-size:13px;margin-top:12px;">Menunggu konfirmasi admin atau sudah dikonfirmasi.</p>
                        @else
                            <h3 style="margin-bottom:8px;">Daftar {{ $program->nama }}</h3>
                            <p style="color:var(--gray-400);font-size:13px;margin-bottom:16px;">
                                Kamu terdaftar sebagai: <strong>{{ auth()->user()->name }}</strong> ({{ auth()->user()->email }})
                            </p>
                            <form action="{{ route('pendaftaran.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="program" value="{{ $program->nama }}">
                                <button type="submit" class="btn-submit" style="width:100%;padding:14px 24px;font-size:15px;">Daftar Sekarang</button>
                            </form>
                        @endif
                    </div>
                </div>

                <p style="text-align:center;margin-top:24px;">
                    <a href="{{ route('member.program') }}" style="color:var(--gray-400);font-size:13px;">← Kembali ke daftar program</a>
                </p>
            </div>
        </main>
    </div>
</body>
</html>
