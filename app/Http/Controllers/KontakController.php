<?php

namespace App\Http\Controllers;

use App\Models\Kontak;
use Illuminate\Http\Request;

class KontakController extends Controller
{
    public function index()
    {
        return view('kontak.index');
    }

    public function kirim(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|max:255',
            'email' => 'required|email|max:255',
            'subjek' => 'nullable|max:255',
            'pesan' => 'required',
        ]);

        Kontak::create($validated);

        return back()->with('success', 'Pesan berhasil dikirim. Kami akan menghubungi Anda segera.');
    }
}
