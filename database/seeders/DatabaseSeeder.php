<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin default
        User::create([
            'name' => 'Admin',
            'email' => 'admin@rumahbahasa.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
        ]);

        // Member contoh
        User::create([
            'name' => 'Member User',
            'email' => 'member@example.com',
            'password' => bcrypt('member123'),
            'role' => 'member',
            'phone' => '08123456789',
            'address' => 'Jl. Contoh No.1, Surabaya',
        ]);

        // Profil
        \App\Models\Profil::insert([
            ['judul' => 'Sejarah Rumah Belajar', 'deskripsi' => 'Rumah Belajar Surabaya didirikan untuk meningkatkan literasi dan kompetensi bahasa masyarakat Surabaya dalam menghadapi era global.', 'kategori' => 'sejarah', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['judul' => 'Visi', 'deskripsi' => 'Terwujudnya masyarakat Surabaya yang literat, kompeten, dan cinta bahasa.', 'kategori' => 'visi_misi', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['judul' => 'Misi', 'deskripsi' => 'Meningkatkan minat baca dan literasi masyarakat. Melestarikan bahasa daerah. Menyediakan akses literasi yang inklusif.', 'kategori' => 'visi_misi', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['judul' => 'Tugas dan Fungsi', 'deskripsi' => 'Menyelenggarakan program literasi kebahasaan, mengelola pojok baca, menyelenggarakan kelas bahasa dan pelatihan.', 'kategori' => 'tugas_fungsi', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Layanan
        \App\Models\Layanan::insert([
            ['nama' => 'Kelas Bahasa Inggris', 'deskripsi' => 'Kelas bahasa Inggris untuk pemula hingga mahir dengan pengajar ahli bahasa asing.', 'urutan' => 1, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Kelas Bahasa Jepang', 'deskripsi' => 'Pelajari bahasa Jepang bersama native speaker yang berpengalaman.', 'urutan' => 2, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Kelas Bahasa Mandarin', 'deskripsi' => 'Kelas bahasa Mandarin untuk komunikasi bisnis dan sehari-hari.', 'urutan' => 3, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Kelas Komputer', 'deskripsi' => 'Pelatihan software dan hardware komputer dasar hingga lanjutan.', 'urutan' => 4, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Pojok Baca', 'deskripsi' => 'Koleksi buku bahasa daerah, nasional, dan internasional yang nyaman untuk dibaca.', 'urutan' => 5, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Kelas Budaya', 'deskripsi' => 'Kelas kebudayaan dari berbagai negara, melukis, membuat kerajinan tradisional, dan banyak lagi.', 'urutan' => 6, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Galeri
        \App\Models\Galeri::insert([
            ['judul' => 'Kelas Bahasa Inggris', 'gambar' => 'placeholder', 'deskripsi' => 'Suasana kelas bahasa Inggris bersama native speaker.', 'kategori' => 'foto', 'tanggal' => now()->subDays(10), 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['judul' => 'Kelas Budaya Rusia', 'gambar' => 'placeholder', 'deskripsi' => 'Kelas membuat boneka Matryoshka.', 'kategori' => 'foto', 'tanggal' => now()->subDays(20), 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['judul' => 'Kunjungan Mahasiswa Asing', 'gambar' => 'placeholder', 'deskripsi' => 'Mahasiswa asing berkunjung ke Rumah Belajar Surabaya.', 'kategori' => 'foto', 'tanggal' => now()->subDays(30), 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
