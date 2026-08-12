<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalKelas;
use App\Models\Layanan;
use App\Models\Notifikasi;
use App\Models\Pendaftaran;
use App\Models\User;
use Illuminate\Http\Request;

class JadwalKelasController extends Controller
{
    private function buatNotifikasiPendaftarProgram($namaKelas, $judul, $pesan, $link = null)
    {
        // Cari program (Layanan) yang relevan dengan kelas ini
        $program = Layanan::where('is_active', true)->get()->first(function ($p) use ($namaKelas) {
            $keyword = str_replace('Kelas ', '', $p->nama);
            return stripos($namaKelas, $keyword) !== false;
        });

        if (!$program) {
            // Fallback: kirim ke semua member approved jika program tidak ditemukan
            $members = User::where('role', 'member')->where('status', 'approved')->get();
        } else {
            // Kirim hanya ke member yang terdaftar di program ini
            $memberIds = Pendaftaran::where('program', $program->nama)
                ->whereIn('status', ['pending', 'confirmed'])
                ->pluck('user_id');

            $members = User::whereIn('id', $memberIds)->where('status', 'approved')->get();
        }

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

        $jadwal = JadwalKelas::create($request->all());

        $this->buatNotifikasiPendaftarProgram(
            $request->nama_kelas,
            '📢 Jadwal Kelas Baru',
            "Kelas {$request->nama_kelas} ({$request->jenis}, {$request->mode}) telah ditambahkan — {$request->hari}, {$request->jam_mulai} - {$request->jam_selesai}.",
            route('member.jadwal')
        );

        return redirect()->route('admin.program-jadwal.index')->with('success', 'Jadwal kelas berhasil ditambahkan.');
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

        $this->buatNotifikasiPendaftarProgram(
            $jadwal->nama_kelas,
            '✏️ Jadwal Kelas Diperbarui',
            "Kelas {$jadwal->nama_kelas} telah diperbarui — {$jadwal->hari}, {$jadwal->jam_mulai} - {$jadwal->jam_selesai} ({$jadwal->jenis}, {$jadwal->mode}). Silakan cek jadwal terbaru.",
            route('member.jadwal')
        );

        return redirect()->route('admin.program-jadwal.index')->with('success', 'Jadwal kelas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jadwal = JadwalKelas::findOrFail($id);
        $nama = $jadwal->nama_kelas;
        $jadwal->delete();

        $this->buatNotifikasiPendaftarProgram(
            $nama,
            '🗑️ Jadwal Kelas Dihapus',
            "Kelas {$nama} telah dihapus dari jadwal.",
            route('member.jadwal')
        );

        return redirect()->route('admin.program-jadwal.index')->with('success', 'Jadwal kelas berhasil dihapus.');
    }
}
