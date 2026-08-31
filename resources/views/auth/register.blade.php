<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Member — Rumah Bahasa Surabaya</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .auth-wrapper { 
            min-height: 100vh; 
            display: flex; 
            flex-direction: column;
            align-items: center; 
            justify-content: center; 
            background: linear-gradient(135deg, var(--teal-900), var(--teal-700)); 
            padding: 24px; 
            box-sizing: border-box;
        }
        .auth-card { 
            background: var(--white); 
            border-radius: 20px; 
            padding: 48px 40px; 
            width: 100%; 
            max-width: 480px; 
            box-shadow: 0 24px 48px rgba(0,0,0,0.15); 
            box-sizing: border-box;
        }
        
        /* ===== STYLE TOMBOL KEMBALI STUCK/FIXED ===== */
        .back-to-home { 
            display: inline-flex; 
            align-items: center; 
            gap: 8px; 
            color: rgba(255, 255, 255, 0.8); 
            text-decoration: none; 
            font-size: 14px; 
            font-weight: 500; 
            margin-bottom: 20px; 
            align-self: center; /* Menjaga posisi di tengah layar desktop sebelum card */
            transition: all 0.2s ease-in-out; 
        }
        .back-to-home:hover { 
            color: #5eead4; /* Warna mint green neon biar estetik pas hover di desktop */
            transform: translateX(-3px); 
        }

        .required-star { color: #e74c3c; }

        /* ===== STYLE FILE INPUT ===== */
        .file-input-wrapper input[type="file"] {
            width: 100%;
            padding: 10px 12px;
            border: 1.5px dashed var(--teal-300);
            border-radius: 10px;
            background: var(--teal-50);
            font-size: 14px;
            color: var(--gray-700);
            cursor: pointer;
            box-sizing: border-box;
            transition: border-color 0.2s, background 0.2s;
        }
        .file-input-wrapper input[type="file"]:hover {
            border-color: var(--teal-500);
            background: #e0f5f0;
        }
        .file-input-wrapper input[type="file"]::file-selector-button {
            padding: 6px 14px;
            border: none;
            border-radius: 6px;
            background: var(--teal-600);
            color: #fff;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            margin-right: 10px;
            transition: background 0.2s;
        }
        .file-input-wrapper input[type="file"]::file-selector-button:hover {
            background: var(--teal-700);
        }

        .auth-header { text-align: center; margin-bottom: 32px; }
        .auth-logo { display: inline-flex; align-items: center; gap: 10px; font-size: 20px; font-weight: 800; margin-bottom: 16px; }
        .auth-logo .brand-teal { color: var(--teal-700); }
        .auth-logo .brand-light { color: var(--gray-400); font-weight: 300; }
        .auth-header h1 { font-size: 28px; font-weight: 700; color: var(--gray-900); margin-bottom: 4px; }
        .auth-header p { color: var(--gray-500); font-size: 14px; }
        .auth-footer { text-align: center; margin-top: 24px; }
        .auth-footer a { color: var(--gray-500); font-size: 13px; transition: color 0.2s; }
        .auth-footer a:hover { color: var(--teal-700); }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }

        /* ===== MODAL CONTOH SURAT ===== */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.55);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 10000;
            padding: 20px;
            box-sizing: border-box;
        }
        .modal-overlay.open { display: flex; }
        .modal-box {
            background: #fff;
            border-radius: 16px;
            width: 100%;
            max-width: 780px;
            max-height: 90vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            box-shadow: 0 24px 48px rgba(0, 0, 0, 0.25);
        }
        .modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 20px;
            border-bottom: 1px solid var(--gray-200);
            flex-shrink: 0;
        }
        .modal-header strong { font-size: 15px; color: var(--gray-900); }
        .modal-close {
            background: var(--gray-100);
            border: none;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            cursor: pointer;
            font-size: 15px;
            color: var(--gray-700);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s;
        }
        .modal-close:hover { background: var(--gray-200); }
        .modal-box iframe {
            width: 100%;
            flex: 1;
            min-height: 0;
            border: none;
        }

        /* ===== PASSWORD TOGGLE ===== */
        .password-wrapper { position: relative; }
        .password-wrapper input { padding-right: 44px !important; }
        .password-toggle {
            position: absolute; right: 10px; top: 50%; transform: translateY(-50%);
            background: none; border: none; cursor: pointer;
            color: var(--gray-400); padding: 6px; display: flex;
            transition: color 0.2s; line-height: 1;
        }
        .password-toggle:hover { color: var(--teal-700); }

        /* ===== BREAKPOINT TABLET & MOBILE ===== */
        @media (max-width: 768px) {
            .form-row { 
                grid-template-columns: 1fr; 
            }
            .back-to-home {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                background: #ffffff;
                color: var(--teal-900) !important;
                padding: 16px 24px; 
                margin-bottom: 0;
                box-shadow: 0 2px 10px rgba(0,0,0,0.08);
                z-index: 9999; 
                box-sizing: border-box;
                justify-content: flex-start;
            }
            .back-to-home:hover {
                color: var(--teal-700) !important;
                transform: none;
            }
            .auth-wrapper {
                padding: 80px 16px 24px;
            }
            .auth-card {
                padding: 32px 24px;
            }
        }

        /* ===== BREAKPOINT HP KECIL (480px ke bawah) ===== */
        @media (max-width: 480px) {
            .auth-wrapper {
                padding: 76px 12px 20px;
            }
            .auth-card {
                padding: 24px 16px;
                border-radius: 16px;
            }
            .auth-header h1 {
                font-size: 22px;
            }
            .auth-header p {
                font-size: 13px;
            }
            .auth-logo {
                font-size: 17px;
            }
            .form-group {
                margin-bottom: 14px;
            }
            .form-group label {
                font-size: 12px;
            }
            .form-group input,
            .form-group textarea {
                padding: 10px 12px;
                font-size: 14px;
            }
            .file-input-wrapper input[type="file"] {
                padding: 8px 10px;
                font-size: 13px;
            }
            .file-input-wrapper input[type="file"]::file-selector-button {
                padding: 4px 10px;
                font-size: 12px;
            }
            .btn-submit {
                padding: 12px;
                font-size: 14px;
            }
            .auth-footer {
                margin-top: 16px;
            }
            .auth-footer a {
                font-size: 12px;
            }
            .alert-error {
                padding: 10px 14px;
                font-size: 12px;
            }
            .back-to-home {
                padding: 12px 16px;
                font-size: 13px;
            }
            hr {
                margin: 14px 0 !important;
            }
            h3 {
                font-size: 14px !important;
                margin-bottom: 12px !important;
            }
            p {
                font-size: 12px !important;
                margin-bottom: 12px !important;
            }
        }
    </style>
</head>
<body>
    <div class="auth-wrapper">

        {{-- TOMBOL KEMBALI (Di luar card biar bebas diposisikan fixed pas mobile) --}}
        <a href="{{ route('home') }}" class="back-to-home">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Kembali ke Beranda
        </a>

        <div class="auth-card">
            <div class="auth-header">
                <div class="auth-logo">
                    <svg width="24" height="24" viewBox="0 0 28 28" fill="none">
                        <path d="M14 7v14M7 10h14M7 18h14" stroke="white" stroke-width="2.5" stroke-linecap="round"/>
                        <circle cx="14" cy="14" r="4" fill="none" stroke="white" stroke-width="1.5"/>
                    </svg>
                </div>
                <h1>Daftar Member</h1>
                <p>Buat akun untuk mendaftar program</p>
            </div>

            @if ($errors->any())
                <div class="alert-error">
                    <ul style="margin:0;padding-left:16px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register.post') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Contoh: Budi Santoso" required autofocus
                        style="{{ $errors->has('name') ? 'border-color:#dc2626;background:#fef2f2;' : '' }}">
                    @error('name')
                        <span style="color:#dc2626;font-size:12px;margin-top:4px;display:block;">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="contoh@email.com" required
                        style="{{ $errors->has('email') ? 'border-color:#dc2626;background:#fef2f2;' : '' }}">
                    @error('email')
                        <span style="color:#dc2626;font-size:12px;margin-top:4px;display:block;">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="password-wrapper">
                            <input type="password" id="password" name="password" placeholder="Min. 6 karakter" required
                                style="{{ $errors->has('password') ? 'border-color:#dc2626;background:#fef2f2;' : '' }}">
                            <button type="button" class="password-toggle" onclick="togglePassword('password', this)" tabindex="-1" aria-label="Tampilkan/sembunyikan password">
                                <svg class="eye-open" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                <svg class="eye-closed" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                            </button>
                        </div>
                        @error('password')
                            <span style="color:#dc2626;font-size:12px;margin-top:4px;display:block;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <div class="password-wrapper">
                            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password" required
                                style="{{ $errors->has('password_confirmation') ? 'border-color:#dc2626;background:#fef2f2;' : '' }}">
                            <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation', this)" tabindex="-1" aria-label="Tampilkan/sembunyikan password">
                                <svg class="eye-open" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                <svg class="eye-closed" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                            </button>
                        </div>
                        @error('password_confirmation')
                            <span style="color:#dc2626;font-size:12px;margin-top:4px;display:block;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="phone">No. Telepon</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx" required
                        style="{{ $errors->has('phone') ? 'border-color:#dc2626;background:#fef2f2;' : '' }}">
                    @error('phone')
                        <span style="color:#dc2626;font-size:12px;margin-top:4px;display:block;">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="address">Alamat</label>
                    <textarea id="address" name="address" rows="2" placeholder="Contoh: Jl. Ahmad Yani No. 1, Surabaya" required style="{{ $errors->has('address') ? 'border-color:#dc2626;background:#fef2f2;' : '' }}">{{ old('address') }}</textarea>
                    @error('address')
                        <span style="color:#dc2626;font-size:12px;margin-top:4px;display:block;">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Dokumen Wajib --}}
                <hr style="border:none;border-top:2px solid var(--teal-100);margin:20px 0;">
                <h3 style="font-size:16px;font-weight:700;color:var(--gray-900);margin-bottom:8px;">Upload Dokumen</h3>
                <p style="font-size:13px;color:var(--gray-500);margin-bottom:16px;">Tanda <span class="required-star">*</span> wajib diisi. Format: JPG/JPEG/PNG, maks. 2MB per file.</p>

                <div class="form-group">
                    <label for="foto_profile">Foto Profil <span class="required-star">*</span></label>
                    <div class="file-input-wrapper">
                        <input type="file" id="foto_profile" name="foto_profile" accept="image/jpeg,image/png,image/jpg" required>
                    </div>
                    @error('foto_profile')
                        <span style="color:#dc2626;font-size:12px;margin-top:4px;display:block;">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Pilih jenis & upload dokumen pendukung — 1 upload saja --}}
                <div class="form-group">
                    <label for="jenis_dokumen">
                        Dokumen Pendukung <span class="required-star">*</span>
                    </label>
                    <p style="font-size:12px;color:var(--gray-400);margin-bottom:6px;">
                        Pilih salah satu jenis dokumen yang kamu miliki, lalu upload filenya.
                        <button type="button" id="lihatContohSurat" style="background:none;border:none;padding:0;color:var(--teal-600);font-weight:500;cursor:pointer;font-size:inherit;text-decoration:underline;">Lihat contoh surat →</button>
                    </p>
                    <select id="jenis_dokumen" name="jenis_dokumen" required
                        style="width:100%;padding:12px 16px;border:1.5px solid {{ $errors->has('jenis_dokumen') ? '#dc2626' : 'var(--gray-200)' }};border-radius:10px;font-size:15px;outline:none;color:var(--gray-900);background:var(--gray-50);margin-bottom:12px;box-sizing:border-box;transition:border-color 0.2s;">
                        <option value="">— Pilih jenis dokumen —</option>
                        <option value="ktp" {{ old('jenis_dokumen') === 'ktp' ? 'selected' : '' }}>KTP</option>
                        <option value="surat_domisili" {{ old('jenis_dokumen') === 'surat_domisili' ? 'selected' : '' }}>Surat Domisili / Surat Keterangan Bekerja di Surabaya</option>
                        <option value="ktm" {{ old('jenis_dokumen') === 'ktm' ? 'selected' : '' }}>KTM / Kartu Pelajar / Identitas Lembaga Pendidikan</option>
                        <option value="kk" {{ old('jenis_dokumen') === 'kk' ? 'selected' : '' }}>Kartu Keluarga (KK)</option>
                    </select>
                    <div class="file-input-wrapper">
                        <input type="file" id="dokumen" name="dokumen" accept="image/jpeg,image/png,image/jpg" required>
                    </div>
                    @error('jenis_dokumen')
                        <span style="color:#dc2626;font-size:12px;margin-top:4px;display:block;">{{ $message }}</span>
                    @enderror
                    @error('dokumen')
                        <span style="color:#dc2626;font-size:12px;margin-top:4px;display:block;">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn-submit">Daftar</button>
            </form>

            <div class="auth-footer">
                Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
            </div>
        </div>

    </div>

    {{-- MODAL CONTOH SURAT (dibuka di atas halaman ini, jadi data form tidak pernah hilang) --}}
    <div class="modal-overlay" id="contohSuratModal" aria-hidden="true">
        <div class="modal-box" role="dialog" aria-modal="true" aria-label="Contoh Surat Keterangan Domisili">
            <div class="modal-header">
                <strong>Contoh Surat Keterangan Domisili</strong>
                <button type="button" class="modal-close" onclick="closeContohSurat()" aria-label="Tutup">✕</button>
            </div>
            <iframe id="contohSuratFrame" title="Contoh Surat Keterangan Domisili"></iframe>
        </div>
    </div>

    <script>
        function togglePassword(id, btn) {
            var input = document.getElementById(id);
            var open = btn.querySelector('.eye-open');
            var closed = btn.querySelector('.eye-closed');
            if (input.type === 'password') {
                input.type = 'text';
                open.style.display = 'none';
                closed.style.display = 'block';
            } else {
                input.type = 'password';
                open.style.display = 'block';
                closed.style.display = 'none';
            }
        }
    </script>

    <script>
        // ===== SIMPAN & PULIHKAN DATA FORM (biar tidak hilang saat buka contoh surat / refresh) =====
        (function () {
            const STORAGE_KEY = 'register_form_state';
            const form = document.querySelector('form');

            function saveFormState() {
                if (!form) return;
                const data = {};
                form.querySelectorAll('input[type="text"], input[type="email"], input[type="password"], textarea, select').forEach(function (field) {
                    if (field.name) data[field.name] = field.value;
                });
                try { sessionStorage.setItem(STORAGE_KEY, JSON.stringify(data)); } catch (e) { /* storage penuh / tidak tersedia */ }
            }

            function restoreFormState() {
                if (!form) return;
                let raw = null;
                try { raw = sessionStorage.getItem(STORAGE_KEY); } catch (e) { return; }
                if (!raw) return;
                try {
                    const data = JSON.parse(raw);
                    Object.keys(data).forEach(function (name) {
                        const field = form.querySelector('[name="' + name + '"]');
                        if (field && 'value' in field) field.value = data[name];
                    });
                } catch (e) { /* abaikan data yang rusak */ }
            }

            // Simpan otomatis setiap kali user mengetik/mengubah isi form
            if (form) {
                form.addEventListener('input', saveFormState);
                form.addEventListener('change', saveFormState);
            }

            // Jaring pengaman: simpan sebelum halaman ditutup/direfresh karena alasan apapun
            window.addEventListener('beforeunload', saveFormState);

            // Pulihkan data saat halaman dimuat (refresh / balik dari halaman lain)
            restoreFormState();

            // Hapus state begitu form dikirim (kalau validasi gagal, Laravel tetap balikin lewat old())
            if (form) {
                form.addEventListener('submit', function () {
                    try { sessionStorage.removeItem(STORAGE_KEY); } catch (e) {}
                });
            }
        })();

        // ===== MODAL CONTOH SURAT (buka tanpa pindah halaman, data form tetap aman) =====
        (function () {
            var modal = document.getElementById('contohSuratModal');
            var frame = document.getElementById('contohSuratFrame');
            var link = document.getElementById('lihatContohSurat');
            if (!modal || !frame || !link) return;

            window.openContohSurat = function () {
                if (!frame.getAttribute('src')) {
                    frame.setAttribute('src', '{{ route('contoh.surat.domisili') }}');
                }
                modal.classList.add('open');
                modal.setAttribute('aria-hidden', 'false');
                document.body.style.overflow = 'hidden';
            };

            window.closeContohSurat = function () {
                modal.classList.remove('open');
                modal.setAttribute('aria-hidden', 'true');
                document.body.style.overflow = '';
            };

            link.addEventListener('click', window.openContohSurat);

            // Klik area gelap di luar modal = tutup
            modal.addEventListener('click', function (e) {
                if (e.target === modal) window.closeContohSurat();
            });

            // Tekan ESC = tutup
            window.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') window.closeContohSurat();
            });

            // Jika di dalam iframe contoh surat ditekan "Tutup"
            window.addEventListener('message', function (e) {
                if (e.data === 'close-contoh-surat') window.closeContohSurat();
            });
        })();
    </script>
</body>
</html>