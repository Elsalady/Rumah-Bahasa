<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Profil;
use Illuminate\Http\Request;

class KontenController extends Controller
{
    public function index()
    {
        $profil = Profil::orderBy('kategori')->get();
        $berita = Berita::orderBy('tanggal', 'desc')->get();

        $editProfil = null;
        if (request()->has('edit_profil')) {
            $editProfil = Profil::find(request()->edit_profil);
        }

        $editBerita = null;
        if (request()->has('edit_berita')) {
            $editBerita = Berita::find(request()->edit_berita);
        }

        return view('admin.konten.index', compact('profil', 'berita', 'editProfil', 'editBerita'));
    }
}
