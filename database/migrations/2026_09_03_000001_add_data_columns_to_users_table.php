<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambah kolom *_data (TEXT) untuk menyimpan upload foto profil & dokumen
     * member sebagai data URI base64. Kolom path lama (foto_profile, ktp, dll.)
     * tetap dipakai & didukung untuk data lama. Dengan penyimpanan di database,
     * upload member persist walau storage hosting ephemeral (Railway/Render/Docker).
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('foto_profile_data')->nullable()->after('foto_profile');
            $table->text('ktp_data')->nullable()->after('ktp');
            $table->text('surat_domisili_data')->nullable()->after('surat_domisili');
            $table->text('ktm_data')->nullable()->after('ktm');
            $table->text('kk_data')->nullable()->after('kk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['foto_profile_data', 'ktp_data', 'surat_domisili_data', 'ktm_data', 'kk_data']);
        });
    }
};
