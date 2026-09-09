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
            'jenis' => 'required|in:tematik,tentative',
            'jadwal_id' => 'required|integer',
        ]);

        $program = Layanan::where('is_active', true)->where('nama', $validated['program'])->first();

        if (!$program) {
            return redirect()->route('member.program')->with('error', 'Program tidak ditemukan.');
        }

        $jadwal = JadwalKelas::where('id', $validated['jadwal_id'])
            ->where('is_active', true)
            ->first();

        if (!$jadwal) {
            return redirect()->route('member.program.detail', $validated['program'])
                ->with('error', 'Jadwal kelas tidak ditemukan. Silakan pilih jadwal yang tersedia.');
        }

        // Tolak jika tanggal jadwal sudah lewat
        if ($jadwal->tanggal && $jadwal->tanggal->lt(\Carbon\Carbon::today())) {
            return redirect()->route('member.program.detail', $validated['program'])
                ->with('error', 'Jadwal kelas ini sudah lewat. Silakan pilih jadwal yang masih tersedia.');
        }

        // Member boleh mendaftar di banyak kelas (tematik/tentative mana pun),
        // TAPI tidak boleh daftar 2x di kelas/jadwal yang sama (pending/confirmed).
        $sudahJadwalIni = Pendaftaran::where('user_id', auth()->id())
            ->where('jadwal_id', $jadwal->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        if ($sudahJadwalIni) {
            return redirect()->route('member.program.detail', $validated['program'])
                ->with('error', 'Kamu sudah terdaftar di kelas/jadwal ini.');
        }

        // ===== CEK BENTROK JAM DENGAN KELAS LAIN =====
        // Member tidak bisa mengikuti 2 kelas pada tanggal & jam yang sama (misal offline vs online).
        // Deteksi via NIK: kalau NIK user sudah terdaftar confirmed di jadwal lain yang waktunya
        // tumpang tindih dengan jadwal yang dipilih, pendaftaran ditolak otomatis.
        $bentrok = Pendaftaran::where('status', 'confirmed')
            ->whereHas('jadwal', function ($q) use ($jadwal) {
                $q->where('is_active', true);
                if ($jadwal->tanggal) {
                    $q->where('tanggal', $jadwal->tanggal->toDateString());
                }
            })
            ->where(function ($q) use ($jadwal) {
                $q->where('user_id', auth()->id())
                    ->orWhereHas('user', function ($qq) {
                        $qq->where('nik', auth()->user()->nik);
                    });
            })
            ->where('jadwal_id', '!=', $jadwal->id)
            ->where(function ($q) use ($jadwal) {
                // Tumpang tindih waktu: mulai < selesai tujuan DAN selesai > mulai tujuan
                $q->whereHas('jadwal', function ($qq) use ($jadwal) {
                    $qq->where('jam_mulai', '<', $jadwal->jam_selesai)
                        ->where('jam_selesai', '>', $jadwal->jam_mulai);
                });
            })
            ->with('jadwal')
            ->first();

        if ($bentrok) {
            return redirect()->route('member.program.detail', $validated['program'])
                ->with('error', 'Kamu tidak bisa mendaftar kelas ini karena waktunya bentrok dengan kelas ' . ($bentrok->jadwal?->nama_kelas ?: 'lain') . ' yang sudah kamu ikuti. Satu orang hanya bisa mengikuti satu kelas di jam yang sama.');
        }

        // ===== CEK KUOTA JADWAL YANG DIPILIH =====
        // Kuota 0 = kelas tidak menerima pendaftaran (admin belum membuka kuota)
        if ($jadwal->kuota <= 0) {
            Pendaftaran::create([
                'user_id' => auth()->id(),
                'program' => $validated['program'],
                'jenis' => $validated['jenis'],
                'mode' => $jadwal->mode,
                'jadwal_id' => $jadwal->id,
                'status' => 'rejected',
                'catatan' => 'Kuota kelas belum dibuka (0).',
            ]);

            return redirect()->route('member.program.detail', $validated['program'])
                ->with('error', 'Maaf, kuota kelas ini belum dibuka. Silakan pilih jadwal lain atau hubungi admin.');
        }

        $terdaftar = Pendaftaran::where('jadwal_id', $jadwal->id)
            ->where('status', 'confirmed')
            ->count();

        if ($terdaftar >= $jadwal->kuota) {
            Pendaftaran::create([
                'user_id' => auth()->id(),
                'program' => $validated['program'],
                'jenis' => $validated['jenis'],
                'mode' => $jadwal->mode,
                'jadwal_id' => $jadwal->id,
                'status' => 'rejected',
                'catatan' => 'Kuota kelas sudah penuh.',
            ]);

            return redirect()->route('member.program.detail', $validated['program'])
                ->with('error', 'Maaf, kuota kelas ini sudah penuh. Silakan pilih jadwal lain atau hubungi admin.');
        }

        Pendaftaran::create([
            'user_id' => auth()->id(),
            'program' => $validated['program'],
            'jenis' => $validated['jenis'],
            'mode' => $jadwal->mode,
            'jadwal_id' => $jadwal->id,
            'status' => 'confirmed',
        ]);

        return redirect()->route('member.program.detail', $validated['program'])
            ->with('success', '✅ Kamu berhasil mendaftar!')
            ->with('baru_daftar_program', $validated['program']);
    }

    public function batal($id)
    {
        $pendaftaran = Pendaftaran::where('id', $id)
            ->where('user_id', auth()->id())
            ->first();

        if (!$pendaftaran) {
            return redirect()->route('member.dashboard')->with('error', 'Pendaftaran tidak ditemukan.');
        }

        if ($pendaftaran->status === 'confirmed') {
            $pendaftaran->delete();
            return redirect()->route('member.dashboard')->with('success', '✅ Kamu berhasil membatalkan pendaftaran program.');
        }

        return redirect()->route('member.dashboard')->with('error', 'Pendaftaran ini tidak bisa dibatalkan.');
    }
}
