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

    public function show($id)
    {
        $item = Profil::where('is_active', true)->findOrFail($id);
        $recent = Profil::where('is_active', true)->where('id', '!=', $id)->limit(3)->get();
        return view('profil.show', compact('item', 'recent'));
    }
}
