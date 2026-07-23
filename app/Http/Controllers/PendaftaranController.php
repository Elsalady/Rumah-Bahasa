<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\Layanan;
use Illuminate\Http\Request;

class PendaftaranController extends Controller
{
    public function index()
    {
        if (auth()->user()->status !== 'approved') {
            return redirect()->route('member.dashboard')->with('error', 'Akun kamu belum diverifikasi. Silakan tunggu konfirmasi dari staff.');
        }

        return redirect()->route('member.program');
    }

    public function store(Request $request)
    {
        if (auth()->user()->status !== 'approved') {
            return redirect()->route('member.dashboard')->with('error', 'Akun kamu belum diverifikasi. Silakan tunggu konfirmasi dari staff.');
        }

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
