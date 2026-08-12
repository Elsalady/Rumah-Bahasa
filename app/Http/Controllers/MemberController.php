<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Pendaftaran;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    /**
     * Hapus pendaftaran kelas TEMATIK yang sudah lewat minggunya.
     * Tematik = daftar per minggu; begitu masuk minggu baru, pendaftaran minggu lalu hangus.
     * Tentative = anggota tetap 1 semester, tidak dihapus.
     */
    private function bersihkanPendaftaranTematik($userId)
    {
        $awalMinggu = \Carbon\Carbon::now()->startOfWeek();

        Pendaftaran::where('user_id', $userId)
            ->where('jenis', 'tematik')
            ->where('status', 'confirmed')
            ->where('created_at', '<', $awalMinggu)
            ->delete();
    }

    public function dashboard()
    {
        $user = auth()->user();
        $this->bersihkanPendaftaranTematik($user->id);
        $pendaftaran = Pendaftaran::where('user_id', $user->id)->latest()->get();
        $notifikasi = $user->notifikasi()->latest()->limit(5)->get();
        $notifUnread = $user->notifikasi()->where('is_read', false)->count();

        return view('member.dashboard', compact('user', 'pendaftaran', 'notifikasi', 'notifUnread'));
    }

    public function edit()
    {
        $user = auth()->user();
        return view('member.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|max:255',
            'phone' => 'nullable|max:20',
            'address' => 'nullable|max:500',
            'password' => 'nullable|min:6|confirmed',
            'foto_profile' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'jenis_dokumen' => 'nullable|in:ktp,surat_domisili,ktm,kk',
            'dokumen' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['name', 'phone', 'address']);
        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        // Upload foto profil
        if ($request->hasFile('foto_profile')) {
            if ($user->foto_profile) {
                Storage::disk('public')->delete($user->foto_profile);
            }
            $data['foto_profile'] = $request->file('foto_profile')->store('member-dokumen', 'public');
        }

        // Upload dokumen pendukung — simpan ke kolom sesuai jenis yang dipilih
        if ($request->hasFile('dokumen') && $request->filled('jenis_dokumen')) {
            $fieldTarget = $request->jenis_dokumen;
            if ($user->$fieldTarget) {
                Storage::disk('public')->delete($user->$fieldTarget);
            }
            $data[$fieldTarget] = $request->file('dokumen')->store('member-dokumen', 'public');
        }

        $user->update($data);
        return redirect()->route('member.edit')->with('success', '✅ Profil berhasil diperbarui.');
    }

    public function program()
    {
        $this->bersihkanPendaftaranTematik(auth()->id());

        $programs = Layanan::where('is_active', true)->orderBy('urutan')->get();
        $programTerdaftar = Pendaftaran::where('user_id', auth()->id())
            ->whereIn('status', ['pending', 'confirmed'])
            ->pluck('program')
            ->toArray();

        // Program yang punya jadwal aktif (cocokkan nama_kelas dengan nama program)
        $namaKelasAktif = \App\Models\JadwalKelas::where('is_active', true)
            ->pluck('nama_kelas')
            ->map(fn($n) => trim(str_replace('Kelas ', '', $n)))
            ->toArray();

        $jadwalIds = $programs->filter(function ($p) use ($namaKelasAktif) {
            $keyword = trim(str_replace('Kelas ', '', $p->nama));
            return in_array($keyword, $namaKelasAktif);
        })->pluck('id')->toArray();

        return view('member.program', compact('programs', 'programTerdaftar', 'jadwalIds'));
    }

    public function detailProgram($nama)
    {
        $this->bersihkanPendaftaranTematik(auth()->id());

        $program = Layanan::where('is_active', true)->where('nama', $nama)->firstOrFail();

        $sudahTerdaftar = Pendaftaran::where('user_id', auth()->id())
            ->where('program', $program->nama)
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        $baruDaftar = session('baru_daftar_program') === $program->nama;

        // Jadwal untuk program ini
        $jadwalProgram = $program->jadwal()
            ->where('is_active', true)
            ->orderByRaw("CASE hari WHEN 'Senin' THEN 1 WHEN 'Selasa' THEN 2 WHEN 'Rabu' THEN 3 WHEN 'Kamis' THEN 4 WHEN 'Jumat' THEN 5 WHEN 'Sabtu' THEN 6 WHEN 'Minggu' THEN 7 END")
            ->orderBy('jam_mulai')
            ->get();

        return view('member.program-detail', compact('program', 'sudahTerdaftar', 'baruDaftar', 'jadwalProgram'));
    }

    public function jadwal()
    {
        // Jadwal dikelompokkan per hari
        $jadwal = \App\Models\JadwalKelas::where('is_active', true)
            ->with('layanan')
            ->orderByRaw("CASE hari WHEN 'Senin' THEN 1 WHEN 'Selasa' THEN 2 WHEN 'Rabu' THEN 3 WHEN 'Kamis' THEN 4 WHEN 'Jumat' THEN 5 WHEN 'Sabtu' THEN 6 WHEN 'Minggu' THEN 7 END")
            ->orderBy('jam_mulai')
            ->get()
            ->groupBy('hari');

        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

        return view('member.jadwal', compact('jadwal', 'hariList'));
    }

    public function notifikasiIndex()
    {
        $user = auth()->user();
        $notifikasi = $user->notifikasi()->latest()->get();
        return view('member.notifikasi', compact('notifikasi'));
    }

    public function notifikasiBaca($id)
    {
        $notif = Notifikasi::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $notif->update(['is_read' => true]);
        if ($notif->link) {
            return redirect($notif->link);
        }
        return redirect()->back();
    }

    public function notifikasiBacaSemua()
    {
        auth()->user()->notifikasi()->where('is_read', false)->update(['is_read' => true]);
        return redirect()->route('member.notifikasi')->with('success', 'Semua notifikasi ditandai sudah dibaca.');
    }
}
