<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profil;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|max:255',
            'deskripsi' => 'required',
            'kategori' => 'required|in:sejarah,visi_misi,tugas_fungsi,struktur,volunteer,gambaran_umum,sasaran',
        ]);

        Profil::create($request->all());
        return redirect()->route('admin.konten.index')->with('success', 'Konten profil berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $profil = Profil::findOrFail($id);
        $request->validate([
            'judul' => 'required|max:255',
            'deskripsi' => 'required',
            'kategori' => 'required|in:sejarah,visi_misi,tugas_fungsi,struktur,volunteer,gambaran_umum,sasaran',
        ]);

        $profil->update($request->all());
        return redirect()->route('admin.konten.index')->with('success', 'Konten profil berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Profil::findOrFail($id)->delete();
        return redirect()->route('admin.konten.index')->with('success', 'Konten profil berhasil dihapus.');
    }
}
