<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalKelas;
use App\Models\Notifikasi;
use App\Models\User;
use Illuminate\Http\Request;

class JadwalKelasController extends Controller
{
    public function index()
    {
        $jadwalKelas = JadwalKelas::orderByRaw("CASE hari WHEN 'Senin' THEN 1 WHEN 'Selasa' THEN 2 WHEN 'Rabu' THEN 3 WHEN 'Kamis' THEN 4 WHEN 'Jumat' THEN 5 WHEN 'Sabtu' THEN 6 WHEN 'Minggu' THEN 7 END")->orderBy('jam_mulai')->get();
        $editItem = null;
        if (request()->has('edit')) {
            $editItem = JadwalKelas::find(request()->edit);
        }
        return view('admin.jadwal-kelas.index', compact('jadwalKelas', 'editItem'));
    }

    private function buatNotifikasiSemuaMember($judul, $pesan, $link = null)
    {
        $members = User::where('role', 'member')->where('status', 'approved')->get();
        foreach ($members as $member) {
            Notifikasi::create([
                'user_id' => $member->id,
                'judul' => $judul,
                'pesan' => $pesan,
                'link' => $link,
            ]);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|max:255',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'pengajar' => 'nullable|max:255',
            'jenis' => 'required|in:tematik,tentative',
            'mode' => 'required|in:online,offline',
            'ruangan_link' => 'nullable|max:255',
            'kuota' => 'integer|min:0',
        ]);

        JadwalKelas::create($request->all());

        $this->buatNotifikasiSemuaMember(
            '📢 Jadwal Kelas Baru',
            "Kelas {$request->nama_kelas} ({$request->jenis}, {$request->mode}) telah ditambahkan — {$request->hari}, {$request->jam_mulai} - {$request->jam_selesai}.",
            route('member.jadwal')
        );

        return redirect()->route('admin.jadwal-kelas.index')->with('success', 'Jadwal kelas berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $jadwal = JadwalKelas::findOrFail($id);
        $request->validate([
            'nama_kelas' => 'required|max:255',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'pengajar' => 'nullable|max:255',
            'jenis' => 'required|in:tematik,tentative',
            'mode' => 'required|in:online,offline',
            'ruangan_link' => 'nullable|max:255',
            'kuota' => 'integer|min:0',
        ]);

        $jadwal->update($request->all());

        $this->buatNotifikasiSemuaMember(
            '✏️ Jadwal Kelas Diperbarui',
            "Kelas {$jadwal->nama_kelas} telah diperbarui — {$jadwal->hari}, {$jadwal->jam_mulai} - {$jadwal->jam_selesai} ({$jadwal->jenis}, {$jadwal->mode}). Silakan cek jadwal terbaru.",
            route('member.jadwal')
        );

        return redirect()->route('admin.jadwal-kelas.index')->with('success', 'Jadwal kelas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jadwal = JadwalKelas::findOrFail($id);
        $nama = $jadwal->nama_kelas;
        $jadwal->delete();

        $this->buatNotifikasiSemuaMember(
            '🗑️ Jadwal Kelas Dihapus',
            "Kelas {$nama} telah dihapus dari jadwal.",
            route('member.jadwal')
        );

        return redirect()->route('admin.jadwal-kelas.index')->with('success', 'Jadwal kelas berhasil dihapus.');
    }
}
