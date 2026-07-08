<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\Layanan;
use Illuminate\Http\Request;

class PendaftaranController extends Controller
{
    public function index()
    {
        $programs = Layanan::where('is_active', true)->orderBy('urutan')->get();
        return view('pendaftaran.index', compact('programs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'program' => 'required|string|max:255',
        ]);

        Pendaftaran::create([
            'user_id' => auth()->id(),
            'program' => $validated['program'],
            'status' => 'pending',
        ]);

        return redirect()->route('member.dashboard')->with('success', 'Pendaftaran berhasil dikirim. Mohon tunggu konfirmasi.');
    }
}
