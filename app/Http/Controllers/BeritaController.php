<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function index()
    {
        $berita = Berita::where('is_active', true)
                        ->orderBy('tanggal', 'desc')
                        ->get();
        return view('home.index', compact('berita'));
    }

    // ===== ADMIN CRUD =====

    public function dashboard()
    {
        $berita = Berita::orderBy('tanggal', 'desc')->get();
        return view('admin.dashboard', compact('berita'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|max:255',
            'ringkasan' => 'nullable',
            'isi' => 'required',
            'penulis' => 'nullable|max:255',
            'tanggal' => 'required|date',
        ]);

        Berita::create([
            'judul' => $request->judul,
            'ringkasan' => $request->ringkasan,
            'isi' => $request->isi,
            'penulis' => $request->penulis ?: 'Admin',
            'tanggal' => $request->tanggal,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Berita berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $berita = Berita::findOrFail($id);

        $request->validate([
            'judul' => 'required|max:255',
            'ringkasan' => 'nullable',
            'isi' => 'required',
            'penulis' => 'nullable|max:255',
            'tanggal' => 'required|date',
        ]);

        $berita->update([
            'judul' => $request->judul,
            'ringkasan' => $request->ringkasan,
            'isi' => $request->isi,
            'penulis' => $request->penulis ?: 'Admin',
            'tanggal' => $request->tanggal,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $berita = Berita::findOrFail($id);
        $berita->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Berita berhasil dihapus.');
    }
}
