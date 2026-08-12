<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Fitur lupa password dihapus — bersihkan tabel sisa
        Schema::dropIfExists('password_reset_tokens');
    }

    public function down(): void
    {
        // Tidak perlu rollback
    }
};
