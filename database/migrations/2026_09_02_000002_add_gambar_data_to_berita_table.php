<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambah kolom gambar_data (TEXT) untuk menyimpan upload foto berita
     * sebagai data URI base64. Kolom gambar lama tetap dipakai untuk path
     * gambar statis. Dengan ini upload admin persist di database (Railway).
     */
    public function up(): void
    {
        Schema::table('berita', function (Blueprint $table) {
            $table->text('gambar_data')->nullable()->after('gambar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('berita', function (Blueprint $table) {
            $table->dropColumn('gambar_data');
        });
    }
};
