<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftaran', function (Blueprint $table) {
            $table->string('jenis')->nullable()->after('program');
            $table->string('mode')->nullable()->after('jenis');
            $table->unsignedBigInteger('jadwal_id')->nullable()->after('mode');
        });
    }

    public function down(): void
    {
        Schema::table('pendaftaran', function (Blueprint $table) {
            $table->dropColumn(['jenis', 'mode', 'jadwal_id']);
        });
    }
};
