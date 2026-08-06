<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Pendaftaran;
use App\Models\Kontak;
use App\Models\User;
use App\Models\Profil;
use App\Models\JadwalKelas;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'berita' => Berita::count(),
            'pendaftar' => Pendaftaran::count(),
            'pending' => Pendaftaran::where('status', 'pending')->count(),
            'confirmed' => User::where('role', 'member')->where('status', 'approved')->count(),
            'pending_member' => User::where('role', 'member')->where('status', 'pending')->count(),
            'pesan_baru' => Kontak::where('sudah_dibaca', false)->count(),
            'member' => User::where('role', 'member')->count(),
            'profil' => Profil::count(),
            'jadwal_kelas' => JadwalKelas::count(),
        ];
        $recentPendaftar = Pendaftaran::with('user')->latest()->limit(5)->get();
        $recentPesan = Kontak::latest()->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'recentPendaftar', 'recentPesan'));
    }
}
