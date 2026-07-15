<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Pendaftaran;
use App\Models\Kontak;
use App\Models\User;
use App\Models\Profil;
use App\Models\Galeri;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'berita' => Berita::count(),
            'pendaftar' => Pendaftaran::count(),
            'pending' => Pendaftaran::where('status', 'pending')->count(),
            'pesan_baru' => Kontak::where('sudah_dibaca', false)->count(),
            'member' => User::where('role', 'member')->count(),
            'profil' => Profil::count(),
            'galeri' => Galeri::count(),
        ];
        $recentPendaftar = Pendaftaran::with('user')->latest()->limit(5)->get();
        $recentPesan = Kontak::where('sudah_dibaca', false)->latest()->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'recentPendaftar', 'recentPesan'));
    }
}
