<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_kelas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kelas');
            $table->enum('hari', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']);
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->string('pengajar')->nullable();
            $table->enum('jenis', ['tematik', 'tentative'])->default('tematik');
            $table->enum('mode', ['online', 'offline'])->default('offline');
            $table->string('ruangan_link')->nullable();
            $table->integer('kuota')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_kelas');
    }
};
