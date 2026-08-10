<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Layanan;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function index()
    {
        $berita = Berita::where('is_active', true)
                        ->orderBy('tanggal', 'desc')
                        ->limit(3)
                        ->get();

        $pelatihan = Layanan::where('is_active', true)
                            ->orderBy('urutan')
                            ->limit(3)
                            ->get();

        $totalProgram = Layanan::where('is_active', true)->count();

        return view('home.index', compact('berita', 'pelatihan', 'totalProgram'));
    }

    public function list(Request $request)
    {
        $keyword = $request->input('q');

        $berita = Berita::where('is_active', true)
                        ->when($keyword, function ($query) use ($keyword) {
                            $query->where(function ($q) use ($keyword) {
                                $q->where('judul', 'like', '%' . $keyword . '%')
                                  ->orWhere('ringkasan', 'like', '%' . $keyword . '%')
                                  ->orWhere('isi', 'like', '%' . $keyword . '%');
                            });
                        })
                        ->orderBy('tanggal', 'desc')
                        ->paginate(9)
                        ->withQueryString();

        return view('berita.index', compact('berita', 'keyword'))->with('hideFooter', true);
    }

    public function show($slug)
    {
        $item = Berita::where('slug', $slug)->where('is_active', true)->firstOrFail();
        return view('berita.show', compact('item'))->with('hideFooter', true);
    }

    // ===== ADMIN CRUD =====

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
        return redirect()->route('admin.konten.index')->with('success', 'Berita berhasil ditambahkan.');
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
        return redirect()->route('admin.konten.index')->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $berita = Berita::findOrFail($id);
        $berita->delete();
        return redirect()->route('admin.konten.index')->with('success', 'Berita berhasil dihapus.');
    }
}