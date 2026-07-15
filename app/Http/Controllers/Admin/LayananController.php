<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
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
}
