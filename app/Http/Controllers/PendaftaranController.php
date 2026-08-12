<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\Layanan;
use App\Models\JadwalKelas;
use Illuminate\Http\Request;

class PendaftaranController extends Controller
{
    public function index()
    {
        if (auth()->user()->status !== 'approved') {
            return redirect()->route('member.dashboard')->with('error', 'Akun kamu belum diverifikasi. Silakan tunggu konfirmasi dari staff.');
        }

        return redirect()->route('member.program');
    }

    public function store(Request $request)
    {
        if (auth()->user()->status !== 'approved') {
            return redirect()->route('member.dashboard')->with('error', 'Akun kamu belum diverifikasi. Silakan tunggu konfirmasi dari staff.');
        }

        $validated = $request->validate([
            'program' => 'required|string|max:255',
        ]);

        $program = Layanan::where('is_active', true)->where('nama', $validated['program'])->first();

        if (!$program) {
            return redirect()->route('member.program')->with('error', 'Program tidak ditemukan.');
        }

        // Cek apakah program punya jadwal aktif di minggu berjalan
        $awalMinggu = \Carbon\Carbon::now()->startOfWeek();
        $akhirMinggu = \Carbon\Carbon::now()->endOfWeek();
        $adaJadwal = JadwalKelas::where('layanan_id', $program->id)
            ->where('is_active', true)
            ->whereBetween('tanggal', [$awalMinggu->format('Y-m-d'), $akhirMinggu->format('Y-m-d')])
            ->exists();

        if (!$adaJadwal) {
            return redirect()->route('member.program.detail', $validated['program'])
                ->with('error', 'Jadwal kelas program ini belum tersedia untuk minggu ini. Silakan tunggu admin mengatur jadwalnya.');
        }

        $sudahTerdaftar = Pendaftaran::where('user_id', auth()->id())
            ->where('program', $validated['program'])
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        if ($sudahTerdaftar) {
            return redirect()->route('member.program.detail', $validated['program'])
                ->with('error', 'Kamu sudah terdaftar di program ini.');
        }

        Pendaftaran::create([
            'user_id' => auth()->id(),
            'program' => $validated['program'],
            'status' => 'confirmed',
        ]);

        return redirect()->route('member.program.detail', $validated['program'])
            ->with('success', '✅ Kamu berhasil mendaftar!')
            ->with('baru_daftar_program', $validated['program']);
    }
}
