<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Baru dari {{ $kontak->nama }}</title>
</head>
<body style="margin:0;padding:0;background:#f0f7fa;font-family:Arial,Helvetica,sans-serif;">
    <div style="max-width:520px;margin:0 auto;padding:32px 20px;">
        <div style="background:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 10px 30px rgba(0,0,0,0.08);">
            <div style="background:linear-gradient(135deg,#0c4e91,#0167a2);padding:28px 32px;text-align:center;">
                <h1 style="margin:0;color:#ffffff;font-size:20px;">Rumah Bahasa Surabaya</h1>
                <p style="margin:6px 0 0;color:rgba(255,255,255,0.8);font-size:13px;">Notifikasi Pesan Baru</p>
            </div>
            <div style="padding:32px;">
                <h2 style="margin:0 0 16px;color:#111827;font-size:18px;">📩 Ada pesan baru masuk</h2>

                <table style="width:100%;border-collapse:collapse;font-size:14px;color:#374151;">
                    <tr>
                        <td style="padding:8px 0;color:#6b7280;width:100px;">Nama</td>
                        <td style="padding:8px 0;font-weight:600;">{{ $kontak->nama }}</td>
                    </tr>
                    <tr>
                        <td style="padding:8px 0;color:#6b7280;">Email</td>
                        <td style="padding:8px 0;font-weight:600;">{{ $kontak->email }}</td>
                    </tr>
                    @if($kontak->subjek)
                    <tr>
                        <td style="padding:8px 0;color:#6b7280;">Subjek</td>
                        <td style="padding:8px 0;font-weight:600;">{{ $kontak->subjek }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td style="padding:8px 0;color:#6b7280;">Waktu</td>
                        <td style="padding:8px 0;font-weight:600;">
                            {{ $kontak->created_at ? $kontak->created_at->timezone('Asia/Jakarta')->locale('id')->isoFormat('D MMM YYYY, HH:mm') . ' WIB' : '-' }}
                        </td>
                    </tr>
                </table>

                <div style="margin:16px 0 0;padding:16px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;">
                    <p style="margin:0 0 6px;color:#6b7280;font-size:12px;font-weight:600;text-transform:uppercase;letter-spacing:0.5px;">Isi Pesan</p>
                    <p style="margin:0;color:#374151;font-size:14px;line-height:1.7;white-space:pre-line;">{{ $kontak->pesan }}</p>
                </div>

                <a href="{{ route('admin.kontak.index') }}" style="display:inline-block;margin-top:24px;background:#0167a2;color:#ffffff;text-decoration:none;font-weight:700;font-size:14px;padding:12px 28px;border-radius:8px;">Lihat di Admin Panel</a>
            </div>
            <div style="padding:16px 32px;background:#f8fafc;text-align:center;color:#9ca3af;font-size:12px;">
                &copy; {{ date('Y') }} Dinas Perpustakaan dan Kearsipan Kota Surabaya
            </div>
        </div>
    </div>
</body>
</html>
