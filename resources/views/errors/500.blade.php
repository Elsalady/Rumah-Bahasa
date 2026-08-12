<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 — Terjadi Kesalahan | Rumah Bahasa Surabaya</title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #f0f7fa 0%, #e3f0fa 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            color: var(--gray-900, #1e293b);
        }
        .error-card {
            background: #fff;
            border: 1px solid var(--gray-100, #f1f5f9);
            border-radius: 24px;
            box-shadow: 0 12px 40px rgba(2, 132, 199, 0.12);
            padding: 56px 40px;
            text-align: center;
            max-width: 520px;
            width: 100%;
        }
        .error-code {
            font-size: 96px;
            font-weight: 800;
            line-height: 1;
            background: linear-gradient(135deg, #0882c4, #327dc9);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            color: transparent;
            letter-spacing: -2px;
        }
        .error-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fef3c7;
            border-radius: 50%;
            color: #b45309;
        }
        h1 {
            font-size: 22px;
            font-weight: 700;
            color: var(--gray-900, #1e293b);
            margin: 16px 0 10px;
        }
        p {
            font-size: 14px;
            color: var(--gray-500, #515f73);
            line-height: 1.7;
            margin-bottom: 28px;
        }
        .btn-home {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #0882c4;
            color: #fff;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
            padding: 13px 32px;
            border-radius: 10px;
            transition: background 0.2s, transform 0.2s;
            box-shadow: 0 4px 14px rgba(8, 130, 196, 0.3);
        }
        .btn-home:hover {
            background: #0167a2;
            transform: translateY(-1px);
        }
        .btn-home svg { width: 16px; height: 16px; }
        .back-link {
            display: inline-block;
            margin-top: 18px;
            font-size: 13px;
            color: var(--gray-400, #aab9ce);
            text-decoration: none;
        }
        .back-link:hover { color: #0882c4; }
        @media (max-width: 480px) {
            .error-card { padding: 40px 24px; }
            .error-code { font-size: 72px; }
        }
    </style>
</head>
<body>
    <div class="error-card">
        <div class="error-icon">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
            </svg>
        </div>
        <div class="error-code">500</div>
        <h1>Terjadi Kesalahan</h1>
        <p>Maaf, terjadi kendala pada server kami. Silakan coba lagi beberapa saat. Jika masalah berlanjut, hubungi kami melalui halaman kontak.</p>
        <a href="{{ url('/') }}" class="btn-home">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            Kembali ke Beranda
        </a>
        <br>
        <a href="{{ route('kontak') }}" class="back-link">Hubungi kami →</a>
    </div>
</body>
</html>
