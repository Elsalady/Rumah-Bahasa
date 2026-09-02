<?php

namespace App\Support;

use App\Models\User;
use Illuminate\Support\Carbon;

class MemberCode
{
    /**
     * Buat kode member format RB-DDMMYY-NNN.
     * NNN adalah nomor urut global (terus berlanjut antar hari, tidak reset ke 001 setiap hari).
     */
    public static function generate(?Carbon $date = null): string
    {
        $tanggal = $date ?: Carbon::now();
        $prefix = 'RB-' . $tanggal->format('dmy') . '-';

        // Nomor urut global: dihitung dari jumlah kode member yang SUDAH dikeluarkan.
        // Mulai dari 001 dan terus berlanjut (002, 003, dst) tanpa reset saat ganti tanggal.
        $urutan = User::whereNotNull('member_code')->count() + 1;

        do {
            $kode = $prefix . str_pad((string) $urutan, 3, '0', STR_PAD_LEFT);
            $urutan++;
        } while (User::where('member_code', $kode)->exists());

        return $kode;
    }
}
