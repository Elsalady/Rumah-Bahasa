<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Konversi format no_member lama (RB-0001) menjadi format baru:
     * RB-YYMMDD-NNNN = tahun, bulan, tanggal gabung (WIB) + urutan harian.
     */
    public function up(): void
    {
        $members = DB::table('users')->where('role', 'member')->orderBy('created_at')->get();
        $counter = []; // tanggal (ymd) => jumlah member di tanggal itu

        foreach ($members as $member) {
            $tgl = \Carbon\Carbon::parse($member->created_at)->timezone('Asia/Jakarta');
            $key = $tgl->format('ymd');
            $counter[$key] = ($counter[$key] ?? 0) + 1;

            DB::table('users')->where('id', $member->id)->update([
                'no_member' => 'RB-' . $key . '-' . str_pad((string) $counter[$key], 4, '0', STR_PAD_LEFT),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan ke format RB-0001 (urutan global sederhana)
        $members = DB::table('users')->where('role', 'member')->orderBy('created_at')->get();
        foreach ($members as $i => $member) {
            DB::table('users')->where('id', $member->id)->update([
                'no_member' => 'RB-' . str_pad((string) ($i + 1), 4, '0', STR_PAD_LEFT),
            ]);
        }
    }
};
