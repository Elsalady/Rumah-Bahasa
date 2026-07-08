<?php

namespace App\Http\Controllers;

use App\Models\Galeri;

class GaleriController extends Controller
{
    public function index()
    {
        $galeri = Galeri::where('is_active', true)->orderBy('tanggal', 'desc')->get();
        return view('galeri.index', compact('galeri'));
    }
}
