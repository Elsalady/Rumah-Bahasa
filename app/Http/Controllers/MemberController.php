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
     * Hapus pendaftaran kelas TENTATIVE yang sudah lewat pertemuannya.
     * Tentative = 1 pertemuan membahas 1 materi (misal 1 lembar/topik);
     * begitu masuk minggu baru / pertemuan berikutnya, pendaftaran lama hangus
     * dan member harus daftar lagi untuk pertemuan/materi berikutnya.
     * Tematik = 1 tema/buku dibahas dalam beberapa pertemuan, anggota tetap
     * terdaftar sampai tema selesai — tidak dihapus.
     */
    private function bersihkanPendaftaranTentative($userId)
    {
        $awalMinggu = \Carbon\Carbon::now()->startOfWeek();

        Pendaftaran::where('user_id', $userId)
            ->where('jenis', 'tentative')
            ->where('status', 'confirmed')
            ->where('created_at', '<', $awalMinggu)
            ->delete();
    }

    public function dashboard()
    {
        $user = auth()->user();
        $this->bersihkanPendaftaranTentative($user->id);
        $pendaftaran = Pendaftaran::where('user_id', $user->id)->latest()->get();
        $notifikasi = $user->notifikasi()->latest()->limit(5)->get();
        $notifUnread = $user->notifikasi()->where('is_read', false)->count();

        // Jadwal mingguan: kelas confirmed yang jadwalnya masih tersedia (belum lewat), urut per hari & jam
        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        $jadwalMingguan = Pendaftaran::where('user_id', $user->id)
            ->where('status', 'confirmed')
            ->whereNotNull('jadwal_id')
            ->with('jadwal')
            ->get()
            ->map(function ($p) {
                return $p->jadwal;
            })
            ->filter(function ($j) {
                return $j && (!$j->tanggal || $j->tanggal->gte(\Carbon\Carbon::today()));
            })
            ->sortBy(function ($j) {
                return array_search($j->hari, ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']);
            })
            ->values()
            ->groupBy('hari');

        return view('member.dashboard', compact('user', 'pendaftaran', 'notifikasi', 'notifUnread', 'jadwalMingguan', 'hariList'));
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
        return redirect()->route('member.dashboard')->with('success', '✅ Profil berhasil diperbarui.');
    }

    public function program()
    {
        $this->bersihkanPendaftaranTentative(auth()->id());

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
        $this->bersihkanPendaftaranTentative(auth()->id());

        $program = Layanan::where('is_active', true)->where('nama', $nama)->firstOrFail();

        // Jenis kelas yang sudah didaftar member di program ini (confirmed)
        $jenisTerdaftar = Pendaftaran::where('user_id', auth()->id())
            ->where('program', $program->nama)
            ->where('status', 'confirmed')
            ->pluck('jenis')
            ->unique()
            ->values()
            ->toArray();

        $baruDaftar = session('baru_daftar_program') === $program->nama;

        // Jadwal untuk program ini (hanya yang belum lewat tanggalnya)
        $jadwalProgram = $program->jadwal()
            ->where('is_active', true)
            ->orderByRaw("CASE hari WHEN 'Senin' THEN 1 WHEN 'Selasa' THEN 2 WHEN 'Rabu' THEN 3 WHEN 'Kamis' THEN 4 WHEN 'Jumat' THEN 5 WHEN 'Sabtu' THEN 6 WHEN 'Minggu' THEN 7 END")
            ->orderBy('jam_mulai')
            ->get()
            ->filter(function ($j) {
                return !$j->tanggal || $j->tanggal->gte(\Carbon\Carbon::today());
            })
            ->values();

        // Jenis kelas yang tersedia di jadwal program ini (tematik / tentative)
        $jenisTersedia = $jadwalProgram->pluck('jenis')->unique()->values()->toArray();

        // Sudah terdaftar di SEMUA jenis yang tersedia?
        $semuaTerdaftar = !empty($jenisTersedia) && empty(array_diff($jenisTersedia, $jenisTerdaftar));

        return view('member.program-detail', compact('program', 'jenisTerdaftar', 'baruDaftar', 'jadwalProgram', 'jenisTersedia', 'semuaTerdaftar'));
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
