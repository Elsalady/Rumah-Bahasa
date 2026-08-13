<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Rumah Bahasa Surabaya</title>
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
            border-radius: 16px; 
            padding: 40px 32px; 
            width: 100%; 
            max-width: 400px; 
            box-shadow: 0 20px 40px rgba(0,0,0,0.12); 
            box-sizing: border-box;
        }
        
        /* ===== STYLE TOMBOL KEMBALI STUCK/FIXED ===== */
        .back-to-home { 
            display: inline-flex; 
            align-items: center; 
            gap: 8px; 
            color: rgba(255, 255, 255, 0.9); 
            text-decoration: none; 
            font-size: 14px; 
            font-weight: 500; 
            margin-bottom: 20px; 
            align-self: center; /* Menjaga posisi di tengah layar desktop sebelum card */
            transition: all 0.2s ease-in-out; 
        }
        .back-to-home:hover { 
            color: #5eb7ea; /* Warna mint green neon biar estetik pas hover di desktop */
            transform: translateX(-3px); 
        }

        .auth-header { 
            text-align: center; 
            margin-bottom: 28px; 
        }
        .auth-logo { 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            gap: 6px; 
            font-size: 20px; 
            font-weight: 700; 
            margin-bottom: 12px; 
            line-height: 1.2;
        }
        .auth-logo .brand-teal { color: var(--teal-700); font-weight: 800; }
        .auth-logo .brand-light { color: var(--gray-400); font-weight: 400; }
        
        .auth-header h1 { 
            font-size: 24px; 
            font-weight: 700; 
            color: var(--gray-900); 
            margin: 0 0 6px 0; 
        }
        .auth-header p { 
            color: var(--gray-500); 
            font-size: 14px; 
            margin: 0;
        }
        
        .auth-footer { text-align: center; margin-top: 24px; }
        .auth-footer a { color: var(--teal-700); font-size: 13px; font-weight: 600; text-decoration: none; transition: color 0.2s; }
        .auth-footer a:hover { text-decoration: underline; }

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

        /* ===== BREAKPOINT MOBILE RESPONSIVE ===== */
        @media (max-width: 768px) {
            .back-to-home {
                position: fixed; /* Kunci melayang di atas layar HP */
                top: 0;
                left: 0;
                width: 100%;
                background: #ffffff; /* Background solid biar teks form pas di-scroll ke bawah gak tabrakan */
                color: var(--teal-900) !important; /* Ubah warna teks jadi gelap biar kontras dengan bg putih */
                padding: 16px 24px; 
                margin-bottom: 0;
                box-shadow: 0 2px 10px rgba(0,0,0,0.08); /* Efek shadow tipis elegan */
                z-index: 9999; 
                box-sizing: border-box;
                justify-content: flex-start;
            }
            .back-to-home:hover {
                color: var(--teal-700) !important;
                transform: none;
            }
            .auth-wrapper {
                padding-top: 80px; /* Jarak aman dari top bar biar card gak ketutupan */
            }
            .auth-card {
                padding: 32px 20px; /* Responsif padding di HP kecil */
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
                    <span class="brand-teal">Rumah Bahasa</span>
                    <span class="brand-light">Surabaya</span>
                </div>
                <h1>Login</h1>
                <p>Masuk ke akun Anda</p>
            </div>

            @if ($errors->any())
                <div class="alert-error">{{ $errors->first() }}</div>
            @endif

            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="contoh@email.com" required autofocus
                        style="{{ $errors->has('email') ? 'border-color:#dc2626;background:#fef2f2;' : '' }}">
                    @error('email')
                        <span style="color:#dc2626;font-size:12px;margin-top:4px;display:block;">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="password-wrapper">
                        <input type="password" id="password" name="password" placeholder="Masukkan password" required
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
                <button type="submit" class="btn-submit">Masuk</button>
            </form>

            <div class="auth-footer">
                Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
            </div>
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
</body>
</html>