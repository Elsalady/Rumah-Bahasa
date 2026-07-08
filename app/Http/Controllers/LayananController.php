<?php

namespace App\Http\Controllers;

use App\Models\Layanan;

class LayananController extends Controller
{
    public function index()
    {
        $layanan = Layanan::where('is_active', true)->orderBy('urutan')->get();
        return view('layanan.index', compact('layanan'));
    }
}
