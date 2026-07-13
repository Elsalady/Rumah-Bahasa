<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Member — Rumah Belajar Surabaya</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        /* ===== UI/UX Visual Hierarchy & Responsive Style ===== */
        .admin-header .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .admin-header-right {
            display: flex;
            align-items: center;
            gap: 24px; /* Jarak yang pas antar opsi */
        }

        /* Tombol Edit Profil: Cuma teks font warna Hijau Neon, Tanpa Border */
        .btn-edit-profile {
            font-size: 14px;
            font-weight: 600;
            color: #39ff14; /* Warna hijau neon menyala */
            text-decoration: none;
            background: none;
            border: none;
            padding: 0;
            cursor: pointer;
            transition: color 0.2s ease-in-out;
        }
        .btn-edit-profile:hover {
            color: #5eead4; /* Berubah agak mint green pas di-hover */
        }

        /* Tombol Logout: Tombol background putih solid tebal & menonjol */
        .btn-logout {
            font-size: 14px;
            font-weight: 700;
            color: var(--teal-900, #005f73); /* Teks gelap agar kontras di atas putih */
            background: #ffffff; /* Putih solid */
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); /* Bayangan tipis biar popup */
            transition: all 0.2s ease-in-out;
        }
        .btn-logout:hover {
            background: #f8fafc;
            transform: translateY(-1px);
        }

        /* Penanganan Khusus Pas Inspect / Mobile View */
        @media (max-width: 768px) {
            .admin-header {
                padding: 12px 16px;
            }
            .admin-header h2 {
                font-size: 18px;
            }
            .admin-header-right {
                gap: 16px;
            }
            .btn-logout {
                padding: 8px 14px;
                font-size: 13px;
            }
            .btn-edit-profile {
                font-size: 13px;
            }
            /* Grid berubah dari 2 kolom jadi 1 kolom vertikal di mobile */
            .responsive-grid {
                grid-template-columns: 1fr !important;
                gap: 20px !important;
            }
        }
    </style>
</head>
<body>
    <div class="admin-page">
        <header class="admin-header">
            <div class="container">
                <h2>Dashboard Member</h2>
                <div class="admin-header-right">
                    {{-- Nama user di navbar sudah di-hide/hapus sesuai request awal --}}
                    {{-- <span>{{ $user->name }}</span> --}}
                    
                    <a href="{{ route('member.edit') }}" class="btn-edit-profile">Edit Profil</a>
                    
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn-logout">Logout</button>
                    </form>
                </div>
            </div>
        </header>

        <main class="admin-main">
            <div class="container" style="max-width:900px;margin:0 auto;width:100%;box-sizing:border-box;">
                @if(session('success'))
                    <div class="alert-success">{{ session('success') }}</div>
                @endif

                <div class="responsive-grid" style="display:grid;grid-template-columns:1fr 1fr;gap:32px;align-items:start;">

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
                                    
                                    <span style="font-size:11px; font-weight:600; padding:3px 10px; border-radius:50px; 
                                        background: {{ $p->status === 'confirmed' ? '#ecfdf5' : ($p->status === 'rejected' ? '#fef2f2' : '#fffbeb') }}; 
                                        color: {{ $p->status === 'confirmed' ? '#166534' : ($p->status === 'rejected' ? '#dc2626' : '#b45309') }};">
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