<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Galeri;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function index()
    {
        $berita = Berita::where('is_active', true)
                        ->orderBy('tanggal', 'desc')
                        ->limit(3)
                        ->get();
        $galeri = Galeri::where('is_active', true)
                        ->orderBy('tanggal', 'desc')
                        ->limit(6)
                        ->get();
        return view('home.index', compact('berita', 'galeri'));
    }

    public function list()
    {
        $berita = Berita::where('is_active', true)
                        ->orderBy('tanggal', 'desc')
                        ->paginate(9);
        return view('berita.index', compact('berita'));
    }

    public function show($slug)
    {
        $item = Berita::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $recent = Berita::where('is_active', true)->where('id', '!=', $item->id)->latest('tanggal')->limit(3)->get();
        return view('berita.show', compact('item', 'recent'));
    }

    // ===== ADMIN CRUD =====

    public function dashboard()
    {
        $berita = Berita::orderBy('tanggal', 'desc')->get();
        return view('admin.dashboard', compact('berita'));
    }

    public function adminIndex()
    {
        $berita = Berita::orderBy('tanggal', 'desc')->get();
        $editItem = null;
        if (request()->has('edit')) {
            $editItem = Berita::find(request()->edit);
        }
        return view('admin.berita.index', compact('berita', 'editItem'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|max:255',
            'ringkasan' => 'nullable',
            'isi' => 'required',
            'penulis' => 'nullable|max:255',
            'tanggal' => 'required|date',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = [
            'judul' => $request->judul,
            'ringkasan' => $request->ringkasan,
            'isi' => $request->isi,
            'penulis' => $request->penulis ?: 'Admin',
            'tanggal' => $request->tanggal,
        ];

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        Berita::create($data);
        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil ditambahkan.');
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
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = [
            'judul' => $request->judul,
            'ringkasan' => $request->ringkasan,
            'isi' => $request->isi,
            'penulis' => $request->penulis ?: 'Admin',
            'tanggal' => $request->tanggal,
        ];

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        $berita->update($data);
        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $berita = Berita::findOrFail($id);
        $berita->delete();
        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dihapus.');
    }
}
