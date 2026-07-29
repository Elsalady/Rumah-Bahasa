<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use App\Models\JadwalKelas;
use Illuminate\Http\Request;

class LayananController extends Controller
{
    public function index()
    {
        $layanan = Layanan::orderBy('urutan')->get();
        $editItem = null;
        if (request()->has('edit')) {
            $editItem = Layanan::find(request()->edit);
        }
        return view('admin.layanan.index', compact('layanan', 'editItem'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:255',
            'deskripsi' => 'required',
            'link_wa' => 'nullable|max:500',
            'urutan' => 'integer|min:0',
        ]);

        Layanan::create($request->all());
        return redirect()->route('admin.layanan.index')->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $layanan = Layanan::findOrFail($id);
        $request->validate([
            'nama' => 'required|max:255',
            'deskripsi' => 'required',
            'link_wa' => 'nullable|max:500',
            'urutan' => 'integer|min:0',
        ]);

        $layanan->update($request->all());
        return redirect()->route('admin.layanan.index')->with('success', 'Layanan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Layanan::findOrFail($id)->delete();
        return redirect()->route('admin.layanan.index')->with('success', 'Layanan berhasil dihapus.');
    }

    public function kelola()
    {
        $layanan = Layanan::orderBy('urutan')->get();
        $allJadwal = JadwalKelas::orderByRaw("CASE hari WHEN 'Senin' THEN 1 WHEN 'Selasa' THEN 2 WHEN 'Rabu' THEN 3 WHEN 'Kamis' THEN 4 WHEN 'Jumat' THEN 5 WHEN 'Sabtu' THEN 6 WHEN 'Minggu' THEN 7 END")
            ->orderBy('jam_mulai')
            ->get()
            ->groupBy('nama_kelas');
        return view('admin.layanan-jadwal.index', compact('layanan', 'allJadwal'));
    }
}
