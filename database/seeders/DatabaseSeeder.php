<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin default — password ambil dari env ADMIN_PASSWORD (fallback: acak & tampil di log)
        $adminPassword = env('ADMIN_PASSWORD', Str::password(16));
        User::firstOrCreate(
            ['email' => 'admin@rumahbahasa.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt($adminPassword),
                'role' => 'admin',
                'status' => 'approved',
            ]
        );

        // Member contoh
        User::firstOrCreate(
            ['email' => 'member@example.com'],
            [
                'name' => 'Member User',
                'password' => bcrypt('member123'),
                'role' => 'member',
                'phone' => '08123456789',
                'address' => 'Jl. Contoh No.1, Surabaya',
            ]
        );

        // Profil
        \App\Models\Profil::insert([
            ['judul' => 'Sejarah Rumah Bahasa', 'deskripsi' => 'Rumah Bahasa Surabaya didirikan untuk meningkatkan literasi dan kompetensi bahasa masyarakat Surabaya dalam menghadapi era global.', 'kategori' => 'sejarah', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['judul' => 'Visi', 'deskripsi' => 'Terwujudnya masyarakat Surabaya yang literat, kompeten, dan cinta bahasa.', 'kategori' => 'visi_misi', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['judul' => 'Misi', 'deskripsi' => 'Meningkatkan minat baca dan literasi masyarakat. Melestarikan bahasa daerah. Menyediakan akses literasi yang inklusif.', 'kategori' => 'visi_misi', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['judul' => 'Tugas dan Fungsi', 'deskripsi' => 'Menyelenggarakan program literasi kebahasaan, mengelola pojok baca, menyelenggarakan kelas bahasa dan pelatihan.', 'kategori' => 'tugas_fungsi', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['judul' => 'Gambaran Umum', 'deskripsi' => 'Rumah Bahasa Surabaya merupakan salah satu bentuk pelayanan publik dari Pemerintah Kota Surabaya yang bertujuan mempersiapkan masyarakat dalam menghadapi persaingan di bidang ekonomi sebagai imbas dari berlakunya Masyarakat Ekonomi ASEAN (MEA).\n\nDiresmikan oleh Walikota Surabaya pada 4 Februari 2014, Rumah Bahasa menyediakan pelatihan bahasa (Jepang, Korea, Arab, Mandarin, Thailand, Tagalog, Inggris, Prancis, Jerman, Belanda, Spanyol, Rusia) dan kelas komputer Broadband Learning Center (BLC) hasil kerja sama dengan Diskominfo Surabaya.\n\nPeserta tidak hanya warga ber-KTP Surabaya, tetapi juga berasal dari daerah lain asalkan membawa bukti sedang bekerja atau menempuh pendidikan di Surabaya.', 'kategori' => 'gambaran_umum', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['judul' => 'Sasaran Kegiatan Pembelajaran', 'deskripsi' => 'Sebagai bentuk pelayanan publik yang diperuntukkan bagi masyarakat, Rumah Bahasa Surabaya menyasar seluruh golongan masyarakat Surabaya. Di antaranya:\n\nWirausaha atau pelaku UKM, perawat, sopir transportasi umum, penjaga parkir, karyawan (hotel, kantor, perusahaan, dan lain-lain), TNI/POLRI, pelajar SMA/SMK/MA dan mahasiswa, serta masyarakat umum, baik perorangan maupun kelompok.', 'kategori' => 'sasaran', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Layanan — mengikuti daftar bahasa di website asli Rumah Bahasa
        // Ikon sengaja tidak dipakai (null) supaya tampilan kartu bersih tanpa ikon.

        $layanan = [
            ['nama' => 'Kelas Bahasa Jepang', 'deskripsi' => 'Pelajari bahasa Jepang bersama native speaker yang berpengalaman.', 'ikon' => null, 'urutan' => 1],
            ['nama' => 'Kelas Bahasa Korea', 'deskripsi' => 'Kelas bahasa Korea untuk komunikasi sehari-hari dan budaya pop.', 'ikon' => null, 'urutan' => 2],
            ['nama' => 'Kelas Bahasa Arab', 'deskripsi' => 'Kelas bahasa Arab untuk pemula hingga mahir.', 'ikon' => null, 'urutan' => 3],
            ['nama' => 'Kelas Bahasa Mandarin', 'deskripsi' => 'Kelas bahasa Mandarin untuk komunikasi bisnis dan sehari-hari.', 'ikon' => null, 'urutan' => 4],
            ['nama' => 'Kelas Bahasa Thailand', 'deskripsi' => 'Kelas bahasa Thailand bersama pengajar berpengalaman.', 'ikon' => null, 'urutan' => 5],
            ['nama' => 'Kelas Bahasa Tagalog', 'deskripsi' => 'Kelas bahasa Tagalog untuk mengenal budaya Filipina.', 'ikon' => null, 'urutan' => 6],
            ['nama' => 'Kelas Bahasa Inggris', 'deskripsi' => 'Kelas bahasa Inggris untuk pemula hingga mahir dengan pengajar ahli bahasa asing.', 'ikon' => null, 'urutan' => 7],
            ['nama' => 'Kelas Bahasa Prancis', 'deskripsi' => 'Kelas bahasa Prancis untuk komunikasi dan budaya.', 'ikon' => null, 'urutan' => 8],
            ['nama' => 'Kelas Bahasa Jerman', 'deskripsi' => 'Kelas bahasa Jerman untuk persiapan studi dan kerja.', 'ikon' => null, 'urutan' => 9],
            ['nama' => 'Kelas Bahasa Belanda', 'deskripsi' => 'Kelas bahasa Belanda untuk komunikasi dan budaya.', 'ikon' => null, 'urutan' => 10],
            ['nama' => 'Kelas Bahasa Spanyol', 'deskripsi' => 'Kelas bahasa Spanyol untuk komunikasi internasional.', 'ikon' => null, 'urutan' => 11],
            ['nama' => 'Kelas Bahasa Rusia', 'deskripsi' => 'Kelas bahasa Rusia bersama pengajar berpengalaman.', 'ikon' => null, 'urutan' => 12],
            ['nama' => 'Kelas Bahasa Indonesia', 'deskripsi' => 'Kelas bahasa Indonesia untuk warga negara asing.', 'ikon' => null, 'urutan' => 13],
            ['nama' => 'Kelas Bahasa Jawa', 'deskripsi' => 'Kelas bahasa Jawa untuk warga negara asing yang ingin mengenal budaya dan bahasa daerah Surabaya.', 'ikon' => null, 'urutan' => 14],
            ['nama' => 'Kelas Komputer (BLC)', 'deskripsi' => 'Pelatihan komputer Broadband Learning Center (BLC): program Ms. Word, Excel, PowerPoint, desain grafis (Corel Draw, Photoshop), dan internet.', 'ikon' => null, 'urutan' => 15],
        ];

        foreach ($layanan as $l) {
            \App\Models\Layanan::firstOrCreate(
                ['nama' => $l['nama']],
                $l + ['is_active' => true, 'created_at' => now(), 'updated_at' => now()]
            );
        }

    }
}
