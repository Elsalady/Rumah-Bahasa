<?php

namespace App\Http\Controllers;

class BeritaController extends Controller
{
    public function index()
    {
        return view('berita.index');
    }

    public function show($slug)
    {
        return view('berita.show', compact('slug'));
    }
}
