<?php

namespace App\Http\Controllers;

use App\Models\JadwalKelas;
use Illuminate\Http\Request;

class JadwalKelasController extends Controller
{
    public function index()
    {
        $awalMinggu = \Carbon\Carbon::now()->startOfWeek();
        $akhirMinggu = \Carbon\Carbon::now()->endOfWeek();

        $jadwal = JadwalKelas::where('is_active', true)
            ->whereBetween('tanggal', [$awalMinggu->format('Y-m-d'), $akhirMinggu->format('Y-m-d')])
            ->orderByRaw("CASE hari WHEN 'Senin' THEN 1 WHEN 'Selasa' THEN 2 WHEN 'Rabu' THEN 3 WHEN 'Kamis' THEN 4 WHEN 'Jumat' THEN 5 WHEN 'Sabtu' THEN 6 WHEN 'Minggu' THEN 7 END")
            ->orderBy('jam_mulai')
            ->get()
            ->groupBy('hari');

        return view('jadwal.index', compact('jadwal'));
    }
}
