<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('berita', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->text('ringkasan')->nullable();
            $table->text('isi');
            $table->string('gambar')->nullable();
            $table->string('penulis')->nullable();
            $table->date('tanggal');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Seed default berita
        DB::table('berita')->insert([
            [
                'judul' => 'Rumah Bahasa Surabaya Resmi Dibuka',
                'slug' => 'rumah-bahasa-surabaya-resmi-dibuka',
                'ringkasan' => 'Dinas Perpustakaan dan Kearsipan Kota Surabaya resmi meluncurkan program Rumah Bahasa Surabaya.',
                'isi' => 'Program Rumah Bahasa Surabaya resmi diluncurkan sebagai wadah pembelajaran dan literasi bagi masyarakat Surabaya. Program ini mencakup berbagai kegiatan seperti kelas bahasa, pojok baca, dan pelatihan keterampilan.',
                'penulis' => 'Admin',
                'tanggal' => now()->format('Y-m-d'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Kelas Bahasa Inggris Gratis Dibuka',
                'slug' => 'kelas-bahasa-inggris-gratis-dibuka',
                'ringkasan' => 'Pendaftaran kelas bahasa Inggris gratis untuk masyarakat umum telah dibuka.',
                'isi' => 'Kelas bahasa Inggris gratis untuk pemula dan menengah kini tersedia di Rumah Bahasa Surabaya. Kelas diadakan setiap hari Selasa dan Kamis pukul 09.00 - 11.00 WIB. Pendaftaran dapat dilakukan melalui website resmi.',
                'penulis' => 'Admin',
                'tanggal' => now()->subDays(3)->format('Y-m-d'),
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDays(3),
            ],
            [
                'judul' => 'Lomba Bercerita Bahasa Daerah 2025',
                'slug' => 'lomba-bercerita-bahasa-daerah-2025',
                'ringkasan' => 'Lomba bercerita bahasa daerah dalam rangka pelestarian budaya lokal.',
                'isi' => 'Dalam upaya melestarikan bahasa daerah, Rumah Bahasa Surabaya mengadakan lomba bercerita menggunakan bahasa daerah. Lomba terbuka untuk pelajar SD hingga SMA se-Kota Surabaya. Hadiah menarik menanti para pemenang.',
                'penulis' => 'Admin',
                'tanggal' => now()->subDays(7)->format('Y-m-d'),
                'created_at' => now()->subDays(7),
                'updated_at' => now()->subDays(7),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berita');
    }
};
};
