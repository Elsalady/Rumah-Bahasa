<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kontak;
use Illuminate\Http\Request;

class KontakController extends Controller
{
    public function index()
    {
        $pesan = Kontak::orderBy('created_at', 'desc')->get();
        return view('admin.kontak.index', compact('pesan'));
    }

    public function markRead($id)
    {
        $kontak = Kontak::findOrFail($id);
        $kontak->update(['sudah_dibaca' => true]);
        return redirect()->route('admin.kontak.index')->with('success', 'Pesan ditandai sudah dibaca.');
    }

    public function destroy($id)
    {
        Kontak::findOrFail($id)->delete();
        return redirect()->route('admin.kontak.index')->with('success', 'Pesan berhasil dihapus.');
    }
}
