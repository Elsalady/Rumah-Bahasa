<?php

namespace App\Http\Controllers;

use App\Models\Berita;

class DashboardController extends Controller
{
    public function admin()
    {
        $berita = Berita::orderBy('tanggal', 'desc')->get();
        return view('admin.dashboard', compact('berita'));
    }

    public function member()
    {
        $user = auth()->user();
        return view('member.dashboard', compact('user'));
    }
}
