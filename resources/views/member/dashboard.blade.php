<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Member — Rumah Bahasa Surabaya</title>
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
            gap: 16px;
        }

        /* Navigasi Kembali ke Beranda dihapus */

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
        .btn-logout:hover { background: #e2e8f0; }

        .responsive-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 32px;
            align-items: start;
            margin-top: 24px;
        }

        /* Layout Profil Baru: Rapi & Minimalis (Left-Aligned) */
        .profile-header-block {
            display: flex;
            align-items: center;
            gap: 20px;
            border-bottom: 1px solid var(--gray-100);
            padding-bottom: 20px;
            margin-bottom: 20px;
        }

        .profile-avatar-circle {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: var(--teal-50);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .profile-title-meta {
            text-align: left;
        }

        /* Baris Data Diri Kiri-Kanan Clean */
        .info-row-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid var(--gray-50);
        }
        .info-row-item:last-child {
            border-bottom: none;
        }

        .info-item-label {
            font-size: 12px;
            color: var(--gray-400);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-item-value {
            color: var(--gray-700);
            font-weight: 500;
            font-size: 14px;
        }

        /* Tombol Edit Profil Solid Minimalis (Warna Teal Awal) */
        .btn-edit-profile-solid {
            display: block;
            width: 100%;
            text-align: center;
            padding: 12px 20px;
            background: #0882c4; /* Teal cerah untuk tombol */
            color: #ffffff;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            margin-top: 20px;
            transition: background 0.2s;
        }
        .btn-edit-profile-solid:hover {
            background: #0167a2; /* Teal 800 pas di-hover */
        }

        .btn-program-group {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
        .btn-program-group a {
            flex: 1;
            text-align: center;
            font-size: 13px;
            white-space: nowrap;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .admin-header { padding: 12px 0; }
            .admin-header .container { flex-wrap: wrap; }
            .admin-header h2 { font-size: 16px; }
            .admin-header-right { gap: 12px; width: 100%; justify-content: space-between; margin-top: 8px; }
            .responsive-grid { grid-template-columns: 1fr; gap: 20px; }
            .main-container { padding: 0 16px; }
            .dashboard-card { padding: 24px 20px !important; }
            .btn-program-group { flex-direction: column; }
            .btn-program-group a { width: 100%; }
            .profile-header-block { flex-direction: column; text-align: center; gap: 12px; }
            .profile-title-meta { text-align: center; }
        }

        @media (max-width: 480px) {
            .admin-main { padding: 16px 0 !important; }
            .main-container { padding: 0 12px !important; }
            .dashboard-card { padding: 20px 14px !important; border-radius: 12px !important; }
            .admin-header h2 { font-size: 14px; }
            .admin-header-right { gap: 8px; }
            .btn-logout { font-size: 12px; padding: 8px 14px; }
            .profile-header-block { flex-direction: column; text-align: center; gap: 8px; padding-bottom: 14px; }
            .profile-avatar-circle { width: 48px; height: 48px; }
            .profile-title-meta h3 { font-size: 18px !important; }
            .profile-title-meta p { font-size: 13px !important; }
            .info-row-item { padding: 10px 0; }
            .info-item-label { font-size: 11px; }
            .info-item-value { font-size: 13px; }
            .btn-edit-profile-solid { font-size: 12px; padding: 10px 16px; }
            .btn-program-group { gap: 8px; }
            .btn-program-group a { font-size: 12px !important; }
            /* Status banners */
            [style*="padding:20px 24px"] { padding: 14px 16px !important; }
            [style*="padding:20px 24px"] svg { width: 20px; height: 20px; }
            [style*="padding:20px 24px"] p:first-child { font-size: 14px !important; }
            [style*="padding:20px 24px"] p { font-size: 12px !important; }
            /* Notification card */
            .dashboard-card[style*="grid-column"] { padding: 12px 14px !important; }
        }
    </style>
</head>
<body>
    <div class="admin-page">
        <header class="admin-header">
            <div class="container">
                <h2>Dashboard</h2>
                <div class="admin-header-right">
                    <a href="{{ route('member.notifikasi') }}" style="color:rgba(255,255,255,0.8);text-decoration:none;position:relative;display:inline-flex;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                        @if($notifUnread > 0)
                            <span style="position:absolute;top:-4px;right:-6px;background:#dc2626;color:#fff;font-size:10px;font-weight:700;width:16px;height:16px;border-radius:50%;display:flex;align-items:center;justify-content:center;">{{ $notifUnread }}</span>
                        @endif
                    </a>
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn-logout">Logout</button>
                    </form>
                </div>
            </div>
        </header>

        <main class="admin-main" style="padding: 24px 0;">
            <div class="container main-container" style="max-width:900px;margin:0 auto;width:100%;box-sizing:border-box;">
                @if(session('success'))
                    <div class="alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div style="padding:14px 20px;background:linear-gradient(135deg,#fef2f2,#fecaca);border:1px solid #fca5a5;border-radius:12px;color:#991b1b;font-weight:500;font-size:14px;margin-bottom:24px;">{{ session('error') }}</div>
                @endif

                {{-- Status Banner --}}
                @if($user->status === 'pending')
                    <div style="padding:20px 24px;background:linear-gradient(135deg,#fffbeb,#fef3c7);border:1px solid #fde68a;border-radius:12px;margin-bottom:24px;display:flex;align-items:flex-start;gap:12px;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="2" style="flex-shrink:0;margin-top:2px;">
                            <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                        </svg>
                        <div>
                            <p style="font-size:15px;font-weight:700;color:#92400e;margin:0 0 4px;">Akun Sedang Ditinjau</p>
                            <p style="font-size:13px;color:#b45309;margin:0;">Akun kamu masih dalam proses verifikasi oleh staff. Kamu akan mendapatkan akses penuh setelah akun disetujui. Mohon tunggu konfirmasi dari kami.</p>
                        </div>
                    </div>
                @elseif($user->status === 'approved')
                    @if($user->catatan_member)
                        <div style="padding:16px 24px;background:linear-gradient(135deg,#ecfdf5,#d1fae5);border:1px solid #6ee7b7;border-radius:12px;margin-bottom:24px;display:flex;align-items:flex-start;gap:12px;">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2" style="flex-shrink:0;margin-top:2px;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                            <div>
                                <p style="font-size:14px;font-weight:700;color:#065f46;margin:0 0 4px;">Pesan dari Admin</p>
                                <p style="font-size:13px;color:#047857;margin:0;">{{ $user->catatan_member }}</p>
                            </div>
                        </div>
                    @endif
                @elseif($user->status === 'rejected')
                    <div style="padding:20px 24px;background:linear-gradient(135deg,#fef2f2,#fecaca);border:1px solid #fca5a5;border-radius:12px;margin-bottom:24px;display:flex;align-items:flex-start;gap:12px;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2" style="flex-shrink:0;margin-top:2px;">
                            <circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>
                        </svg>
                        <div>
                            <p style="font-size:15px;font-weight:700;color:#991b1b;margin:0 0 4px;">Akun Ditolak</p>
                            <p style="font-size:13px;color:#b91c1c;margin:0;">Akun kamu ditolak. Silakan hubungi admin untuk informasi lebih lanjut.</p>
                            @if($user->catatan_member)
                                <p style="font-size:13px;color:#b91c1c;margin-top:6px;font-style:italic;">Catatan: {{ $user->catatan_member }}</p>
                            @endif
                            <a href="{{ route('home') . '#kontak' }}" style="display:inline-flex;align-items:center;gap:6px;margin-top:10px;padding:8px 16px;background:#dc2626;color:#fff;border-radius:8px;font-size:12px;font-weight:600;text-decoration:none;transition:background 0.2s;" onmouseover="this.style.background='#b91c1c'" onmouseout="this.style.background='#dc2626'">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
                                Kirim Pesan ke Admin
                            </a>
                        </div>
                    </div>
                @endif

                <div class="responsive-grid">

                    {{-- Notifikasi --}}
                    @if($notifUnread > 0)
                    <div class="dashboard-card" style="padding:16px 20px;grid-column:1/-1;">
                        <div style="display:flex;justify-content:space-between;align-items:center;">
                            <p style="font-size:13px;font-weight:600;color:var(--teal-700);margin:0;">
                                🔔 {{ $notifUnread }} notifikasi baru
                            </p>
                            <a href="{{ route('member.notifikasi') }}" style="font-size:12px;color:var(--teal-600);">Lihat Semua →</a>
                        </div>
                        @foreach($notifikasi as $notif)
                            @if(!$notif->is_read)
                            <a href="{{ route('member.notifikasi.baca', $notif->id) }}" style="text-decoration:none;color:inherit;display:block;padding:8px 0;border-top:1px solid var(--gray-50);">
                                <p style="font-size:13px;font-weight:600;color:var(--gray-900);margin:0;">{{ $notif->judul }}</p>
                                <p style="font-size:12px;color:var(--gray-500);margin:2px 0 0;">{{ Str::limit($notif->pesan, 80) }}</p>
                            </a>
                            @endif
                        @endforeach
                    </div>
                    @endif

                    {{-- Profil Card - Rapi & Minimalis --}}
                    <div class="dashboard-card" style="padding:40px;">
                        <div class="profile-header-block">
                            @if($user->foto_profile)
                                <img src="{{ asset('storage/' . $user->foto_profile) }}" alt="Foto Profil" style="width:64px;height:64px;border-radius:50%;object-fit:cover;flex-shrink:0;">
                            @else
                            <div class="profile-avatar-circle">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--teal-700)" stroke-width="1.5">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                    <circle cx="12" cy="7" r="4"/>
                                </svg>
                            </div>
                            @endif
                            <div class="profile-title-meta">
                                <h3 style="font-size:22px;font-weight:700;color:var(--gray-900);margin:0;">{{ $user->name }}</h3>
                                <p style="color:var(--gray-500);margin:4px 0 8px 0;">{{ $user->email }}</p>
                                <span style="display:inline-block;padding:4px 16px;background:var(--teal-50);color:var(--teal-700);border-radius:50px;font-size:13px;font-weight:500;">Member</span>
                            </div>
                        </div>

                        <div style="margin-top:20px;">
                            <div class="info-row-item">
                                <span class="info-item-label">Nomor Member</span>
                                <span class="info-item-value" style="font-weight:700;color:var(--teal-700);">{{ $user->no_member ?: '-' }}</span>
                            </div>
                            <div class="info-row-item">
                                <span class="info-item-label">Telepon</span>
                                <span class="info-item-value">{{ $user->phone ?: '-' }}</span>
                            </div>
                            <div class="info-row-item">
                                <span class="info-item-label">Bergabung</span>
                                <span class="info-value info-item-value">{{ $user->created_at->timezone('Asia/Jakarta')->locale('id')->isoFormat('D MMM YYYY, HH:mm') }}</span>
                            </div>
                            <div class="info-row-item">
                                <span class="info-item-label">Alamat</span>
                                <span class="info-item-value">{{ $user->address ?: '-' }}</span>
                            </div>
                        </div>

                        {{-- Dokumen --}}
                        <div style="margin-top:20px;padding-top:16px;border-top:1px solid var(--gray-100);">
                            <p style="font-size:12px;color:var(--gray-400);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:10px;">Dokumen</p>
                            @php
                                $dokList = [
                                    'foto_profile' => 'Foto Profil',
                                    'ktp' => 'KTP',
                                    'surat_domisili' => 'Surat Domisili',
                                    'ktm' => 'KTM/Kartu Pelajar',
                                    'kk' => 'KK',
                                ];
                            @endphp
                            @foreach($dokList as $field => $label)
                                <div class="info-row-item" style="padding:8px 0;">
                                    <span class="info-item-label">{{ $label }}</span>
                                    @if($user->$field)
                                        <a href="{{ asset('storage/' . $user->$field) }}" target="_blank" style="font-size:12px;color:var(--teal-600);font-weight:500;">Lihat</a>
                                    @else
                                        <span style="font-size:11px;color:var(--gray-400);">-</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <a href="{{ route('member.edit') }}" class="btn-edit-profile-solid">Edit Profil →</a>
                    </div>

                    {{-- Pendaftaran — hanya tampil kalau status approved --}}
                    @if($user->status === 'approved')

                    {{-- ===== JADWAL MINGGUAN MEMBER ===== --}}
                    <div class="dashboard-card" style="padding:24px;grid-column:1/-1;">
                        <h3 style="margin-top:0;">📅 Jadwal Kelas Mingguan</h3>
                        <p style="font-size:13px;color:var(--gray-400);margin:0 0 16px;">Kelas yang sudah kamu daftar (pengingat jadwal).</p>

                        @if($jadwalMingguan->count())
                            <div style="display:grid;gap:10px;">
                                @foreach($hariList as $hari)
                                    @if(isset($jadwalMingguan[$hari]) && $jadwalMingguan[$hari]->count())
                                        <div style="margin-bottom:8px;">
                                            <p style="font-size:13px;font-weight:700;color:var(--teal-700);margin:0 0 6px;padding-bottom:4px;border-bottom:2px solid var(--teal-100);">{{ $hari }}</p>
                                            @foreach($jadwalMingguan[$hari] as $j)
                                                <div style="display:flex;align-items:center;gap:10px;padding:10px 14px;background:#f8fafc;border:1px solid var(--gray-100);border-radius:10px;margin-bottom:6px;flex-wrap:wrap;">
                                                    <div style="min-width:100px;text-align:center;padding:6px 10px;background:#0167a2;color:#fff;border-radius:8px;">
                                                        <p style="font-size:11px;font-weight:700;margin:0;">{{ $j->tanggal ? $j->tanggal->timezone('Asia/Jakarta')->locale('id')->isoFormat('D MMM') : $hari }}</p>
                                                    </div>
                                                    <div style="flex:1;min-width:140px;">
                                                        <p style="font-weight:600;font-size:13px;color:var(--gray-900);margin:0;">{{ $j->nama_kelas }}</p>
                                                        <p style="font-size:12px;color:var(--gray-500);margin:2px 0 0;">
                                                            {{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }} WIB
                                                            @if($j->pengajar) &middot; {{ $j->pengajar }} @endif
                                                        </p>
                                                    </div>
                                                    <div style="display:flex;align-items:center;gap:5px;flex-wrap:wrap;">
                                                        <span style="display:inline-block;padding:2px 8px;border-radius:50px;font-size:10px;font-weight:600;{{ $j->jenis === 'tematik' ? 'background:#e0f2fe;color:#0369a1;' : 'background:#fef3c7;color:#b45309;' }}">{{ ucfirst($j->jenis) }}</span>
                                                        <span style="display:inline-block;padding:2px 8px;border-radius:50px;font-size:10px;font-weight:600;{{ $j->mode === 'online' ? 'background:#e0f2fe;color:#0369a1;' : 'background:#ecfdf5;color:#166534;' }}">{{ ucfirst($j->mode) }}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @else
                            <div style="text-align:center;padding:24px;">
                                <p class="text-muted" style="margin:0 0 16px;">Belum ada kelas yang terdaftar. Yuk daftar program kelas!</p>
                                <a href="{{ route('member.program') }}" class="btn-login" style="font-size:13px;display:inline-flex;">Lihat Program</a>
                            </div>
                        @endif
                    </div>

                    <div class="dashboard-card" style="padding:24px;">
                        <h3>Histori Pendaftaran</h3>

                        @if($pendaftaran->count())
                            @foreach($pendaftaran as $p)
                                <div style="display:flex;justify-content:space-between;align-items:center;padding:14px 0;border-bottom:1px solid var(--gray-100);gap:10px;">
                                    <div style="min-width:0;">
                                        <p style="font-weight:600;color:var(--gray-900);word-break:break-word;margin:0;">{{ $p->program }}</p>
                                        <div style="display:flex;align-items:center;gap:6px;flex-wrap:wrap;margin-top:4px;">
                                            @if($p->jenis)
                                                <span style="font-size:10px;font-weight:700;padding:2px 8px;border-radius:50px;{{ $p->jenis === 'tematik' ? 'background:#e0f2fe;color:#0369a1;' : 'background:#fef3c7;color:#b45309;' }}">{{ ucfirst($p->jenis) }}</span>
                                            @endif
                                            @if($p->mode)
                                                <span style="font-size:10px;font-weight:700;padding:2px 8px;border-radius:50px;background:#ecfdf5;color:#166534;">{{ ucfirst($p->mode) }}</span>
                                            @endif
                                            @if($p->jadwal)
                                                <span style="font-size:10px;color:var(--gray-500);">{{ $p->jadwal->hari }}, {{ \Carbon\Carbon::parse($p->jadwal->jam_mulai)->format('H:i') }} WIB</span>
                                            @endif
                                        </div>
                                        <p style="font-size:12px;color:var(--gray-400);margin:4px 0 0 0;">{{ $p->created_at->timezone('Asia/Jakarta')->locale('id')->isoFormat('D MMM YYYY') }}</p>
                                        @if($p->catatan)
                                            <p style="font-size:12px;color:var(--gray-500);margin:4px 0 0 0;font-style:italic;">{{ $p->catatan }}</p>
                                        @endif
                                    </div>
                                    <div style="display:flex;align-items:center;gap:8px;flex-shrink:0;">
                                        @if($p->status === 'confirmed')
                                            <span style="font-size:11px;font-weight:600;padding:3px 10px;border-radius:50px;background:#1d4ed8;color:#fff;">Terdaftar</span>
                                            <form action="{{ route('member.pendaftaran.batal', $p->id) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan pendaftaran {{ $p->program }}?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" style="font-size:11px;font-weight:600;padding:5px 12px;border-radius:50px;background:#fee2e2;color:#b91c1c;border:1px solid #fecaca;cursor:pointer;transition:background 0.2s;" onmouseover="this.style.background='#fecaca'" onmouseout="this.style.background='#fee2e2'">Batal Daftar</button>
                                            </form>
                                        @elseif($p->status === 'rejected')
                                            <span style="font-size:11px;font-weight:600;padding:3px 10px;border-radius:50px;background:#dc2626;color:#fff;">Kuota Penuh</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div style="text-align:center;padding:24px;">
                                <p class="text-muted" style="margin:0 0 16px;">Belum ada pendaftaran. Yuk daftar program kelas!</p>
                                <a href="{{ route('member.program') }}" class="btn-login" style="font-size:13px;display:inline-flex;">Lihat Program</a>
                            </div>
                        @endif
                        <div class="btn-program-group">
                            <a href="{{ route('member.program') }}" class="btn-login" style="font-size:13px;">Lihat Program</a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </main>
    </div>
</body>
</html>