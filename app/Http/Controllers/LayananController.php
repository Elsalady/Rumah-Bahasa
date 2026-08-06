<?php

namespace App\Http\Controllers;

use App\Models\Layanan;

class LayananController extends Controller
{
    public function index()
    {
        $programs = Layanan::where('is_active', true)->orderBy('urutan')->get();

        return view('layanan.index', compact('programs'));
    }

    public function show($nama)
    {
        $program = Layanan::where('is_active', true)->where('nama', $nama)->firstOrFail();

        return view('layanan.show', compact('program'));
    }
}
