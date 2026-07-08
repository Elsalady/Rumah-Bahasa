<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        $pendaftaran = Pendaftaran::where('user_id', $user->id)->latest()->get();
        return view('member.dashboard', compact('user', 'pendaftaran'));
    }

    public function edit()
    {
        $user = auth()->user();
        return view('member.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|max:255',
            'phone' => 'nullable|max:20',
            'address' => 'nullable|max:500',
            'password' => 'nullable|min:6|confirmed',
        ]);

        $data = $request->only(['name', 'phone', 'address']);
        if ($request->filled('password')) {
            $data['password'] = $request->password; // biar di-hash otomatis sama cast 'hashed' di model
        }

        $user->update($data);
        return redirect()->route('member.edit')->with('success', '✅ Profil berhasil diperbarui.');
    }
}
