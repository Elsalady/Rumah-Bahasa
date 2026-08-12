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
                @if(session('error'))
                    <div style="padding:14px 20px;background:linear-gradient(135deg,#fef2f2,#fecaca);border:1px solid #fca5a5;border-radius:12px;color:#991b1b;font-weight:500;font-size:14px;margin-bottom:24px;">{{ session('error') }}</div>
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

                {{-- Jadwal Program Minggu Ini --}}
                <div style="background:#fff;border:1px solid var(--gray-100);border-radius:16px;box-shadow:0 2px 12px rgba(0,0,0,0.05);padding:24px;margin-bottom:24px;">
                    <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;margin-bottom:16px;">
                        <div>
                            <h2 style="font-size:16px;font-weight:700;color:var(--gray-900);margin:0;">Jadwal Kelas Minggu Ini</h2>
                            <p style="font-size:12px;color:var(--gray-400);margin:4px 0 0;">
                                {{ \Carbon\Carbon::now()->startOfWeek()->translatedFormat('l, d M') }} — {{ \Carbon\Carbon::now()->endOfWeek()->translatedFormat('l, d M Y') }}
                            </p>
                        </div>
                        @if($jadwalProgram->count())
                            <span style="display:inline-flex;align-items:center;gap:6px;padding:6px 14px;background:#ecfdf5;color:#166534;border-radius:50px;font-size:12px;font-weight:600;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                                {{ $jadwalProgram->count() }} sesi tersedia
                            </span>
                        @else
                            <span style="display:inline-flex;align-items:center;gap:6px;padding:6px 14px;background:#fef3c7;color:#b45309;border-radius:50px;font-size:12px;font-weight:600;">
                                Belum ada jadwal minggu ini
                            </span>
                        @endif
                    </div>

                    @if($jadwalProgram->count())
                        <div style="display:grid;gap:10px;">
                            @foreach($jadwalProgram as $item)
                                <div style="display:flex;align-items:center;gap:14px;padding:14px 16px;background:#f8fafc;border:1px solid var(--gray-100);border-radius:12px;flex-wrap:wrap;">
                                    <div style="min-width:110px;text-align:center;padding:8px 12px;background:#0167a2;color:#fff;border-radius:10px;">
                                        <p style="font-size:12px;font-weight:700;margin:0;">{{ $item->hari }}</p>
                                    </div>
                                    <div style="flex:1;min-width:160px;">
                                        <p style="font-weight:700;font-size:14px;color:var(--gray-900);margin:0;">
                                            {{ \Carbon\Carbon::parse($item->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($item->jam_selesai)->format('H:i') }} WIB
                                        </p>
                                        @if($item->pengajar)
                                            <p style="font-size:12px;color:var(--gray-500);margin:2px 0 0;">Pengajar: {{ $item->pengajar }}</p>
                                        @endif
                                    </div>
                                    <div style="display:flex;align-items:center;gap:6px;flex-wrap:wrap;">
                                        <span style="display:inline-block;padding:3px 10px;border-radius:50px;font-size:11px;font-weight:600;background:#e0f2fe;color:#0369a1;">{{ ucfirst($item->jenis) }}</span>
                                        <span style="display:inline-block;padding:3px 10px;border-radius:50px;font-size:11px;font-weight:600;background:#ecfdf5;color:#166534;">{{ ucfirst($item->mode) }}</span>
                                        @if($item->ruangan_link)
                                            <span style="font-size:12px;color:var(--gray-500);background:var(--gray-50);padding:3px 10px;border-radius:50px;">
                                                {{ $item->mode === 'online' ? '🔗' : '📍' }} {{ $item->ruangan_link }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div style="text-align:center;padding:24px;">
                            <p style="font-size:14px;color:var(--gray-500);margin:0;">Admin belum mengatur jadwal untuk program ini minggu ini.</p>
                            <p style="font-size:12px;color:var(--gray-400);margin:6px 0 0;">Kamu belum bisa mendaftar sampai jadwal kelas tersedia. Cek kembali nanti.</p>
                        </div>
                    @endif
                </div>

                {{-- Tombol Daftar --}}
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

                {{-- Tombol Daftar --}}
                <div style="max-width:400px;margin:0 auto;">
                    <div class="dashboard-card" style="padding:28px;text-align:center;">
                        @if($sudahTerdaftar)
                            <div style="display:inline-flex;align-items:center;gap:8px;padding:12px 24px;background:#ecfdf5;color:#166534;border-radius:8px;font-size:15px;font-weight:600;">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                                kamu sudah terdaftar
                            </div>
                            <p style="color:var(--gray-400);font-size:13px;margin-top:12px;">Kamu sudah terdaftar di program ini.</p>
                        @elseif(!$jadwalProgram->count())
                            <h3 style="margin-bottom:8px;">Daftar {{ $program->nama }}</h3>
                            <p style="color:var(--gray-400);font-size:13px;margin-bottom:16px;">
                                Jadwal kelas minggu ini belum tersedia. Silakan tunggu admin mengatur jadwalnya.
                            </p>
                            <button type="button" class="btn-submit" style="width:100%;padding:14px 24px;font-size:15px;background:#e5e7eb;color:#9ca3af;cursor:not-allowed;border:none;" disabled>
                                Daftar Tidak Tersedia
                            </button>
                        @else
                            <h3 style="margin-bottom:8px;">Daftar {{ $program->nama }}</h3>
                            <p style="color:var(--gray-400);font-size:13px;margin-bottom:16px;">
                                Kamu terdaftar sebagai: <strong>{{ auth()->user()->name }}</strong> ({{ auth()->user()->email }})
                            </p>
                            <form action="{{ route('pendaftaran.store') }}" method="POST" id="form-daftar">
                                @csrf
                                <input type="hidden" name="program" value="{{ $program->nama }}">

                                {{-- ===== PILIH JENIS KELAS ===== --}}
                                <div style="text-align:left;margin-bottom:16px;">
                                    <label style="display:block;font-size:13px;font-weight:700;color:var(--gray-700);margin-bottom:8px;">Pilih Jenis Kelas</label>

                                    <label style="display:flex;align-items:flex-start;gap:10px;padding:12px 14px;border:1.5px solid var(--gray-200);border-radius:10px;cursor:pointer;margin-bottom:8px;transition:all 0.2s;background:#fff;" for="jenis_tematik">
                                        <input type="radio" name="jenis" id="jenis_tematik" value="tematik" required onchange="document.getElementById('form-daftar').dataset.jenis='tematik'" style="margin-top:3px;">
                                        <div style="text-align:left;">
                                            <strong style="font-size:13px;color:var(--gray-900);display:block;">Tematik</strong>
                                            <span style="font-size:12px;color:var(--gray-500);line-height:1.5;display:block;margin-top:2px;">
                                                Daftar per minggu — tiap pertemuan materi & peserta bisa berubah. Wajib daftar ulang setiap minggu jika ingin mengikuti kelas berikutnya.
                                            </span>
                                        </div>
                                    </label>

                                    <label style="display:flex;align-items:flex-start;gap:10px;padding:12px 14px;border:1.5px solid var(--gray-200);border-radius:10px;cursor:pointer;margin-bottom:8px;transition:all 0.2s;background:#fff;" for="jenis_tentative">
                                        <input type="radio" name="jenis" id="jenis_tentative" value="tentative" required onchange="document.getElementById('form-daftar').dataset.jenis='tentative'" style="margin-top:3px;">
                                        <div style="text-align:left;">
                                            <strong style="font-size:13px;color:var(--gray-900);display:block;">Tentative</strong>
                                            <span style="font-size:12px;color:var(--gray-500);line-height:1.5;display:block;margin-top:2px;">
                                                Anggota tetap 1 semester — daftar sekali, otomatis menjadi anggota kelas selama satu semester penuh tanpa perlu mendaftar ulang tiap minggu.
                                            </span>
                                        </div>
                                    </label>
                                </div>

                                {{-- ===== PILIH JADWAL ===== --}}
                                <div style="text-align:left;margin-bottom:16px;">
                                    <label for="jadwal_id" style="display:block;font-size:13px;font-weight:700;color:var(--gray-700);margin-bottom:8px;">Pilih Jadwal Kelas</label>
                                    <select name="jadwal_id" id="jadwal_id" required style="width:100%;padding:12px 16px;border:1.5px solid var(--gray-200);border-radius:10px;font-size:14px;outline:none;background:var(--gray-50);color:var(--gray-900);box-sizing:border-box;">
                                        <option value="">— Pilih jadwal —</option>
                                        @foreach($jadwalProgram as $j)
                                            <option value="{{ $j->id }}">
                                                {{ $j->hari }}, {{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }} WIB · {{ ucfirst($j->jenis) }} · {{ ucfirst($j->mode) }}
                                                @if($j->pengajar) · {{ $j->pengajar }} @endif
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

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
