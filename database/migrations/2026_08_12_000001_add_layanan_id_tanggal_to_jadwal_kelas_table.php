<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jadwal_kelas', function (Blueprint $table) {
            $table->foreignId('layanan_id')->nullable()->after('id')->constrained('layanan')->nullOnDelete();
            $table->date('tanggal')->nullable()->after('nama_kelas');
        });
    }

    public function down(): void
    {
        Schema::table('jadwal_kelas', function (Blueprint $table) {
            $table->dropConstrainedForeignId('layanan_id');
            $table->dropColumn('tanggal');
        });
    }
};
