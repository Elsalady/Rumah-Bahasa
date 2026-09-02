<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Perbaiki path gambar berita di database.
     * Sebelumnya gambar disimpan sebagai "berita/berita_1.jpg" (storage Laravel),
     * sekarang disimpan di public/images/berita sehingga path-nya cukup "berita_1.jpg".
     * Migration ini menormalisasi data lama agar tampil di Railway.
     */
    public function up(): void
    {
        $berita = DB::table('berita')->whereNotNull('gambar')->get();

        foreach ($berita as $item) {
            $gambar = $item->gambar;

            // Kasus 1: "berita/berita_1.jpg" -> "berita_1.jpg"
            if (str_starts_with($gambar, 'berita/')) {
                $gambar = substr($gambar, strlen('berita/'));
            }

            // Kasus 2: "berita/berita_1.jpg" yang tersimpan ganda jadi "berita/berita/berita_1.jpg"
            while (str_starts_with($gambar, 'berita/')) {
                $gambar = substr($gambar, strlen('berita/'));
            }

            DB::table('berita')->where('id', $item->id)->update(['gambar' => $gambar]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Tidak ada operasi balik yang aman — biarkan apa adanya.
    }
};
