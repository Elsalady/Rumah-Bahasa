<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Rumah Bahasa Surabaya</title>
</head>
<body style="margin:0;padding:0;background:#f0fdfa;font-family:Arial,Helvetica,sans-serif;">
    <div style="max-width:520px;margin:0 auto;padding:32px 20px;">
        <div style="background:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 10px 30px rgba(0,0,0,0.08);">
            <div style="background:linear-gradient(135deg,#0c4e91,#0167a2);padding:28px 32px;text-align:center;">
                <h1 style="margin:0;color:#ffffff;font-size:20px;">Rumah Bahasa Surabaya</h1>
            </div>
            <div style="padding:32px;">
                <h2 style="margin:0 0 12px;color:#111827;font-size:18px;">Reset Password</h2>
                <p style="margin:0 0 20px;color:#4b5563;font-size:14px;line-height:1.6;">
                    Anda menerima email ini karena kami menerima permintaan reset password untuk akun Anda.
                </p>
                <a href="{{ $url }}" style="display:inline-block;background:#0167a2;color:#ffffff;text-decoration:none;font-weight:700;font-size:14px;padding:12px 28px;border-radius:8px;">Reset Password</a>
                <p style="margin:20px 0 0;color:#6b7280;font-size:13px;line-height:1.6;">
                    Tautan ini hanya berlaku <strong>60 menit</strong>. Jika Anda tidak meminta reset password, abaikan email ini.
                </p>
            </div>
            <div style="padding:16px 32px;background:#f8fafc;text-align:center;color:#9ca3af;font-size:12px;">
                &copy; {{ date('Y') }} Dinas Perpustakaan dan Kearsipan Kota Surabaya
            </div>
        </div>
    </div>
</body>
</html>
