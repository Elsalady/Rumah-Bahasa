<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contoh Surat Keterangan Domisili — Rumah Bahasa Surabaya</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        * { box-sizing: border-box; }

        body {
            background: linear-gradient(135deg, var(--teal-900), var(--teal-700));
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 40px 24px;
        }

        .contoh-card {
            background: #fff;
            border-radius: 20px;
            padding: 48px 40px;
            max-width: 700px;
            width: 100%;
            box-shadow: 0 24px 48px rgba(0,0,0,0.15);
        }

        .contoh-card h1 {
            font-size: 24px;
            font-weight: 700;
            color: var(--gray-900);
            text-align: center;
            margin-bottom: 8px;
        }

        .contoh-card .subtitle {
            text-align: center;
            color: var(--gray-500);
            font-size: 14px;
            margin-bottom: 32px;
        }

        .surat-container {
            border: 2px solid var(--gray-200);
            border-radius: 12px;
            padding: 32px;
            background: #fafafa;
            font-family: 'Times New Roman', Times, serif;
            line-height: 1.8;
        }

        .surat-container .kop-surat {
            text-align: center;
            border-bottom: 3px double var(--gray-700);
            padding-bottom: 12px;
            margin-bottom: 20px;
        }

        .surat-container .kop-surat h2 {
            font-size: 18px;
            font-weight: 700;
            margin: 0 0 2px;
            text-transform: uppercase;
        }

        .surat-container .kop-surat p {
            font-size: 13px;
            margin: 0;
            color: var(--gray-600);
        }

        .surat-container .nomor-surat {
            text-align: center;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 16px;
        }

        .surat-container .isi-surat p {
            text-align: justify;
            font-size: 14px;
            margin-bottom: 10px;
            text-indent: 36px;
        }

        .surat-container .isi-surat .bold {
            font-weight: 700;
        }

        .surat-container .tanda-tangan {
            margin-top: 32px;
            text-align: right;
            font-size: 14px;
        }

        .surat-container .tanda-tangan .garis {
            margin-top: 60px;
            margin-bottom: 4px;
        }

        .surat-container .tanda-tangan .nama-terang {
            font-weight: 700;
        }

        .keterangan {
            margin-top: 24px;
            padding: 16px;
            background: #eefbf5;
            border-radius: 10px;
            border-left: 4px solid var(--teal-600);
        }

        .keterangan h3 {
            font-size: 14px;
            font-weight: 700;
            color: var(--teal-800);
            margin-bottom: 8px;
        }

        .keterangan ul {
            margin: 0;
            padding-left: 18px;
            font-size: 13px;
            color: var(--gray-700);
        }

        .keterangan ul li { margin-bottom: 4px; }

        .btn-kembali {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: rgba(255,255,255,0.85);
            text-decoration: none;
            font-size: 14px;
            margin-bottom: 20px;
            align-self: flex-start;
            transition: color 0.2s;
        }
        .btn-kembali:hover { color: #5eead4; }

        @media (max-width: 768px) {
            .contoh-card { padding: 24px 16px; }
            .surat-container { padding: 20px 16px; }
        }
    </style>
</head>
<body>

    <a href="{{ route('register') }}" class="btn-kembali">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <line x1="19" y1="12" x2="5" y2="12"></line>
            <polyline points="12 19 5 12 12 5"></polyline>
        </svg>
        Kembali ke Pendaftaran
    </a>

    <div class="contoh-card">
        <h1>Contoh Surat Keterangan Domisili</h1>
        <p class="subtitle">Gunakan contoh di bawah sebagai referensi surat yang akan diupload. Surat harus ditandatangani dan distempel oleh pihak kelurahan/desa setempat atau instansi terkait.</p>

        <div style="margin-bottom:24px;border:2px dashed var(--teal-300);border-radius:12px;padding:16px;text-align:center;background:#f0fdfa;">
            <p style="font-size:14px;font-weight:600;color:var(--teal-700);margin-bottom:8px;">📷 Contoh Surat</p>
            <img src="{{ asset('img/contoh-surat-domisili.jpg') }}" alt="Contoh Surat Keterangan Domisili" style="max-width:100%;border-radius:8px;box-shadow:0 4px 12px rgba(0,0,0,0.1);" onerror="this.style.display='none'">
            <p style="font-size:12px;color:var(--gray-400);margin-top:8px;">Jika gambar tidak muncul, kamu bisa melihat format teks di bawah.</p>
        </div>

        <div class="surat-container">
            <div class="kop-surat">
                <h2>PEMERINTAH KOTA SURABAYA</h2>
                <p>KECAMATAN ... KELURAHAN ...</p>
                <p>Jl. Contoh No. 123, Surabaya, Telp. (031) 1234567</p>
            </div>

            <div class="nomor-surat">
                SURAT KETERANGAN DOMISILI<br>
                Nomor: 470/XXX/2026
            </div>

            <div class="isi-surat">
                <p>Yang bertanda tangan di bawah ini:</p>
                <table style="width:100%;font-size:14px;margin-bottom:10px;">
                    <tr>
                        <td style="width:160px;vertical-align:top;">Nama</td>
                        <td style="width:10px;">:</td>
                        <td>Drs. ... (Nama Lurah/Camat)</td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top;">Jabatan</td>
                        <td>:</td>
                        <td>Lurah ... / Camat ...</td>
                    </tr>
                </table>

                <p>Dengan ini menerangkan bahwa:</p>
                <table style="width:100%;font-size:14px;margin-bottom:10px;">
                    <tr>
                        <td style="width:160px;vertical-align:top;">Nama</td>
                        <td style="width:10px;">:</td>
                        <td class="bold">[Nama Lengkap]</td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top;">Tempat, Tgl Lahir</td>
                        <td>:</td>
                        <td>[Tempat, Tanggal Lahir]</td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top;">Jenis Kelamin</td>
                        <td>:</td>
                        <td>[Laki-laki / Perempuan]</td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top;">Kewarganegaraan</td>
                        <td>:</td>
                        <td>Indonesia</td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top;">Pekerjaan</td>
                        <td>:</td>
                        <td>[Pekerjaan]</td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top;">Alamat</td>
                        <td>:</td>
                        <td>[Alamat Lengkap di Surabaya]</td>
                    </tr>
                </table>

                <p>Benar bahwa orang tersebut di atas berdomisili di alamat tersebut dan tercatat sebagai penduduk di wilayah kami.</p>
                <p>Surat keterangan ini dibuat untuk digunakan sebagai <span class="bold">persyaratan pendaftaran program di Rumah Bahasa Surabaya</span>.</p>
                <p>Demikian surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.</p>
            </div>

            <div class="tanda-tangan">
                <p>Surabaya, .................... 2026</p>
                <p>Lurah/Camat ...,</p>
                <div class="garis">
                    <p style="margin-top:40px;margin-bottom:4px;"><strong>(......................................................)</strong></p>
                    <p style="font-size:12px;">NIP. ........................................</p>
                </div>
            </div>
        </div>

        <div class="keterangan">
            <h3>Ketentuan Dokumen:</h3>
            <ul>
                <li>Surat harus dikeluarkan oleh Kelurahan/Desa setempat atau instansi resmi.</li>
                <li>Jika kamu bekerja di Surabaya tapi domisili di luar Surabaya, bisa upload <strong>Surat Keterangan Bekerja di Surabaya</strong> dari HRD/perusahaan tempat kerja sebagai pengganti surat domisili.</li>
                <li>Surat harus jelas terbaca (foto/scan dengan kualitas baik).</li>
                <li>Format file: JPG, JPEG, atau PNG. Maksimal 2MB.</li>
            </ul>
        </div>
    </div>

</body>
</html>
