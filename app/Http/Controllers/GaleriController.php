<?php

namespace App\Http\Controllers;

use App\Models\Galeri;

class GaleriController extends Controller
{
    public function index()
    {
        $galeri = Galeri::where('is_active', true)
                        ->orderBy('tanggal', 'desc')
                        ->orderBy('id', 'desc')
                        ->paginate(12);

        return view('galeri.index', compact('galeri'));
    }
}
