<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Rumah Belajar Surabaya</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .auth-wrapper { min-height: 100vh; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, var(--teal-900), var(--teal-700)); padding: 24px; }
        .auth-card { background: var(--white); border-radius: 20px; padding: 48px 40px; width: 100%; max-width: 420px; box-shadow: 0 24px 48px rgba(0,0,0,0.15); }
        .auth-header { text-align: center; margin-bottom: 32px; }
        .auth-logo { display: inline-flex; align-items: center; gap: 10px; font-size: 20px; font-weight: 800; margin-bottom: 16px; }
        .auth-logo .brand-teal { color: var(--teal-700); }
        .auth-logo .brand-light { color: var(--gray-400); font-weight: 300; }
        .auth-header h1 { font-size: 28px; font-weight: 700; color: var(--gray-900); margin-bottom: 4px; }
        .auth-header p { color: var(--gray-500); font-size: 14px; }
        .auth-footer { text-align: center; margin-top: 24px; }
        .auth-footer a { color: var(--gray-500); font-size: 13px; transition: color 0.2s; }
        .auth-footer a:hover { color: var(--teal-700); }
    </style>
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            <div class="auth-header">
                <div class="auth-logo">
                    <svg width="24" height="24" viewBox="0 0 28 28" fill="none">
                        <rect width="28" height="28" rx="6" fill="#005f73"/>
                        <path d="M14 7v14M7 10h14M7 18h14" stroke="white" stroke-width="2.5" stroke-linecap="round"/>
                        <circle cx="14" cy="14" r="4" fill="none" stroke="white" stroke-width="1.5"/>
                    </svg>
                    <span class="brand-teal">Rumah Belajar</span>
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
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email" required autofocus>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan password" required>
                </div>
                <button type="submit" class="btn-submit">Masuk</button>
            </form>

            <div class="auth-footer">
                Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
            </div>
        </div>
    </div>
</body>
</html>
