<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambah kolom umur (angka tahun) untuk tampilan admin:
     * '18 (Remaja)' dst. rentang_usia tetap disimpan untuk filter/rekap.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedTinyInteger('umur')->nullable()->after('tanggal_lahir');
        });

        // Backfill umur & rentang_usia dari tanggal_lahir untuk member lama
        $users = DB::table('users')->whereNotNull('tanggal_lahir')->get(['id', 'tanggal_lahir']);
        foreach ($users as $u) {
            $umur = \Carbon\Carbon::parse($u->tanggal_lahir)->age;
            DB::table('users')->where('id', $u->id)->update([
                'umur' => $umur,
                'rentang_usia' => $umur <= 18 ? 'remaja' : ($umur <= 36 ? 'dewasa' : 'orang_tua'),
            ]);
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('umur');
        });
    }
};
