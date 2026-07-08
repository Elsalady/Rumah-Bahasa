<?php

namespace App\Http\Controllers;

use App\Models\Profil;

class ProfilController extends Controller
{
    public function index()
    {
        $profil = Profil::where('is_active', true)->orderBy('kategori')->get()->groupBy('kategori');
        return view('profil.index', compact('profil'));
    }
}
