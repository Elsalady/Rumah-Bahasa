<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE profil DROP CONSTRAINT IF EXISTS profil_kategori_check");
        DB::statement("ALTER TABLE profil ADD CONSTRAINT profil_kategori_check CHECK (kategori::text = ANY (ARRAY['sejarah', 'visi_misi', 'tugas_fungsi', 'struktur', 'volunteer']::text[]))");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE profil DROP CONSTRAINT IF EXISTS profil_kategori_check");
        DB::statement("ALTER TABLE profil ADD CONSTRAINT profil_kategori_check CHECK (kategori::text = ANY (ARRAY['sejarah', 'visi_misi', 'tugas_fungsi', 'struktur']::text[]))");
    }
};
