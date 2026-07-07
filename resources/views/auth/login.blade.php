<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin — Rumah Belajar Surabaya</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .login-header { text-align: center; margin-bottom: 32px; }
        .login-logo { display: inline-flex; align-items: center; gap: 10px; font-size: 20px; font-weight: 800; margin-bottom: 16px; }
        .login-logo .brand-teal { color: var(--teal-700); }
        .login-logo .brand-light { color: var(--gray-400); font-weight: 300; }
        .login-back { text-align: center; margin-top: 20px; }
        .login-back a { color: var(--gray-500); font-size: 13px; transition: color 0.2s; }
        .login-back a:hover { color: var(--teal-700); }
    </style>
</head>
<body>
    <div class="login-page">
        <div class="login-card">
            <div class="login-header">
                <div class="login-logo">
                    <svg width="24" height="24" viewBox="0 0 28 28" fill="none">
                        <rect width="28" height="28" rx="6" fill="#005f73"/>
                        <path d="M14 7v14M7 10h14M7 18h14" stroke="white" stroke-width="2.5" stroke-linecap="round"/>
                        <circle cx="14" cy="14" r="4" fill="none" stroke="white" stroke-width="1.5"/>
                    </svg>
                    <span class="brand-teal">Rumah Belajar</span>
                    <span class="brand-light">Surabaya</span>
                </div>
                <h1>Login Admin</h1>
                <p>Masuk untuk mengelola konten website</p>
            </div>

            @if(session('error'))
                <div class="alert-error">{{ session('error') }}</div>
            @endif

            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Masukkan username" required autofocus>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan password" required>
                </div>
                <button type="submit" class="btn-submit">Masuk</button>
            </form>

            <div class="login-back">
                <a href="{{ route('home') }}">← Kembali ke Beranda</a>
            </div>
        </div>
    </div>
</body>
</html>
