<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TataCaraController extends Controller
{
    public function index($jenis = 'ktp-surabaya')
    {
        $varian = $jenis === 'ktp-non-surabaya' ? 'ktp-non-surabaya' : 'ktp-surabaya';

        $konten = [
            'ktp-surabaya' => [
                'judul' => 'Tata Cara Pendaftaran (KTP Surabaya)',
                'deskripsi' => 'Berikut langkah-langkah untuk mendaftar sebagai peserta Rumah Bahasa Surabaya (bagi yang memiliki KTP Surabaya):',
                'langkah' => [
                    'Minimal berusia 17 tahun atau sedang menempuh pendidikan di kelas 1 SMA/SMK/MA.',
                    'Mengisi formulir pendaftaran di halaman <a href="' . route('register') . '">Registrasi</a>.',
                    'Melakukan konfirmasi pendaftaran melalui direct message Instagram <a href="https://www.instagram.com/rumahbahasasby/" target="_blank" rel="noopener">@rumahbahasasby</a> atau email <a href="mailto:rumah.bahasa.surabaya@gmail.com">rumah.bahasa.surabaya@gmail.com</a>.',
                ],
            ],
            'ktp-non-surabaya' => [
                'judul' => 'Tata Cara Pendaftaran (KTP Non-Surabaya)',
                'deskripsi' => 'Berikut langkah-langkah untuk mendaftar sebagai peserta Rumah Bahasa Surabaya (bagi yang memiliki KTP luar kota/warga negara asing):',
                'langkah' => [
                    'Minimal berusia 17 tahun atau sedang menempuh pendidikan di kelas 1 SMA/SMK/MA.',
                    'Sedang bekerja, bersekolah, atau kuliah di Surabaya, dibuktikan dengan mengunggah lampiran fotokopi Kartu Pelajar (bagi Siswa) / Kartu Tanda Mahasiswa (bagi Mahasiswa) / Surat Keterangan Kerja (bagi Pekerja) / Surat Domisili / Paspor (bagi warga asing) pada saat mendaftar.',
                    'Mengisi formulir pendaftaran di halaman <a href="' . route('register') . '">Registrasi</a>.',
                    'Melakukan konfirmasi pendaftaran melalui direct message Instagram <a href="https://www.instagram.com/rumahbahasasby/" target="_blank" rel="noopener">@rumahbahasasby</a> atau email <a href="mailto:rumah.bahasa.surabaya@gmail.com">rumah.bahasa.surabaya@gmail.com</a>.',
                ],
            ],
        ];

        $data = $konten[$varian];

        return view('tata-cara.index', compact('data', 'varian'));
    }
}
