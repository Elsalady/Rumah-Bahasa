<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambah kolom data kependudukan member:
     * - nik: nomor induk kependudukan (untuk cek duplikat/bentrok daftar kelas)
     * - tempat_lahir & tanggal_lahir: data TTL
     * - rentang_usia: kategori usia dari tanggal_lahir — remaja (1-18 th),
     *   dewasa (19-36 th), orang_tua (37+ th). Dipakai untuk rekap ke Pemkab.
     * - jenis_pekerjaan: pekerjaan member (teks bebas).
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nik', 20)->nullable()->unique()->after('no_member');
            $table->string('tempat_lahir')->nullable()->after('nik');
            $table->date('tanggal_lahir')->nullable()->after('tempat_lahir');
            $table->string('rentang_usia')->nullable()->after('tanggal_lahir');
            $table->string('jenis_pekerjaan')->nullable()->after('rentang_usia');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nik', 'tempat_lahir', 'tanggal_lahir', 'rentang_usia', 'jenis_pekerjaan']);
        });
    }
};
