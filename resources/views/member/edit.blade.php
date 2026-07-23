<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil — Rumah Bahasa Surabaya</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        * { box-sizing: border-box; }

        .admin-header .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .header-title-wrapper {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn-back-header {
            display: inline-flex;
            align-items: center;
            color: var(--white);
            text-decoration: none;
        }
        .btn-back-header:hover { transform: translateX(-3px); }

        .admin-header-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

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
        .btn-logout:hover { background: #f1f5f9; }

        @media (max-width: 768px) {
            .admin-header { padding: 12px 0; }
            .admin-header h2 { font-size: 16px; }
            .admin-header-right span { display: none; }
            .btn-logout { padding: 8px 14px; font-size: 13px; }
            .admin-main { padding: 16px; }
            .dashboard-card { padding: 20px 16px; }
        }
    </style>
</head>
<body>
    <div class="admin-page">
        <header class="admin-header">
            <div class="container">
                <div class="header-title-wrapper">
                    <a href="{{ route('member.dashboard') }}" class="btn-back-header" title="Kembali">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="19" y1="12" x2="5" y2="12"></line>
                            <polyline points="12 19 5 12 12 5"></polyline>
                        </svg>
                    </a>
                    <h2>Edit Profil</h2>
                </div>
                <div class="admin-header-right">
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn-logout">Logout</button>
                    </form>
                </div>
            </div>
        </header>

        <main class="admin-main">
            <div class="container" style="max-width:520px;margin:0 auto;width:100%;box-sizing:border-box;">
                @if(session('success'))
                    <div class="alert-success">{{ session('success') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert-error">
                        <ul style="margin:0;padding-left:16px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="dashboard-card">
                    <h3>Update Data Diri</h3>
                    <form action="{{ route('member.update') }}" method="POST" class="dashboard-form" enctype="multipart/form-data">
                        @csrf @method('PUT')
                        <div class="form-group">
                            <label for="name">Nama Lengkap</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" value="{{ $user->email }}" disabled style="width:100%;padding:12px 16px;border:1.5px solid var(--gray-200);border-radius:10px;font-size:15px;background:var(--gray-100);color:var(--gray-400);box-sizing:border-box;">
                            <p style="font-size:12px;color:var(--gray-400);margin-top:4px;">Email tidak dapat diubah.</p>
                        </div>
                        <div class="form-group">
                            <label for="phone">No. Telepon</label>
                            <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                        </div>
                        <div class="form-group">
                            <label for="address">Alamat</label>
                            <textarea id="address" name="address" rows="2">{{ old('address', $user->address) }}</textarea>
                        </div>
                        <hr style="border:none;border-top:1px solid var(--gray-100);margin:20px 0;">
                        <div class="form-group">
                            <label for="password">Password Baru (kosongkan jika tidak ingin ganti)</label>
                            <input type="password" id="password" name="password" placeholder="Min. 6 karakter">
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Konfirmasi Password Baru</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password">
                        </div>

                        {{-- Dokumen Member --}}
                        <hr style="border:none;border-top:2px solid var(--teal-100);margin:20px 0;">
                        <h3 style="font-size:16px;font-weight:700;color:var(--gray-900);margin-bottom:4px;">Dokumen Member</h3>
                        <p style="font-size:13px;color:var(--gray-500);margin-bottom:16px;">Upload ulang hanya jika ingin mengganti dokumen. Format: JPG/JPEG/PNG, maks. 2MB.</p>

                        @php
                            $dokumenList = [
                                'foto_profile' => 'Foto Profil',
                                'ktp' => 'KTP',
                                'surat_domisili' => 'Surat Keterangan Domisili / Bekerja di Surabaya',
                                'ktm' => 'KTM / Kartu Pelajar / Identitas Lembaga Pendidikan',
                                'kk' => 'Kartu Keluarga (KK)',
                            ];
                            $opsionalFields = ['ktm'];
                        @endphp

                        @foreach($dokumenList as $field => $label)
                            <div class="form-group">
                                <label for="{{ $field }}">{{ $label }}</label>
                                @if(in_array($field, $opsionalFields))
                                    <p style="font-size:12px;color:var(--gray-400);margin-bottom:4px;">Kosongkan jika tidak ada.</p>
                                @endif
                                @if($user->$field)
                                    <div style="margin-bottom:6px;">
                                        <a href="{{ asset('storage/' . $user->$field) }}" target="_blank" style="font-size:13px;color:var(--teal-600);">
                                            📄 Lihat dokumen saat ini
                                        </a>
                                    </div>
                                @else
                                    <p style="font-size:12px;color:var(--gray-400);margin-bottom:6px;">Belum diupload</p>
                                @endif
                                <input type="file" id="{{ $field }}" name="{{ $field }}" accept="image/jpeg,image/png,image/jpg">
                            </div>
                        @endforeach

                        <button type="submit" class="btn-submit">Simpan Perubahan</button>
                    </form>
                    <p style="text-align:center;margin-top:16px;">
                        <a href="{{ route('member.dashboard') }}" style="color:var(--gray-400);font-size:13px;">← Kembali ke Dashboard</a>
                    </p>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
