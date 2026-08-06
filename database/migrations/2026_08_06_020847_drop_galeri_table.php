<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('galeri');
    }

    public function down(): void
    {
        Schema::create('galeri', function ($table) {
            $table->id();
            $table->string('judul');
            $table->string('gambar');
            $table->text('deskripsi')->nullable();
            $table->enum('kategori', ['foto', 'video'])->default('foto');
            $table->date('tanggal')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }
};
