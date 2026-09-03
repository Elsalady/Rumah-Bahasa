<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ===== LOGIN =====
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->intended(route('admin.dashboard'));
            }
            return redirect()->intended(route('member.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // ===== REGISTER =====
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'phone' => 'nullable|max:20',
            'address' => 'nullable|max:500',
            'foto_profile' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'jenis_dokumen' => 'required|in:ktp,surat_domisili,ktm,kk',
            'dokumen' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'email.unique' => 'Email ini sudah terdaftar. Silakan gunakan email lain atau login dengan akun yang sudah ada.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'name.required' => 'Nama lengkap wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'foto_profile.required' => 'Foto profil wajib diunggah.',
            'jenis_dokumen.required' => 'Pilih jenis dokumen pendukung terlebih dahulu.',
            'dokumen.required' => 'Dokumen pendukung wajib diunggah.',
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'role' => 'member',
            'status' => 'pending',
        ];

        // Nomor member diberikan setelah akun disetujui admin (lihat Admin\MemberController::update),
        // jadi tidak digenerate di sini untuk menghindari bentrok nomor saat banyak pendaftar.

        // Upload foto profil — simpan path (storage) + data base64 (DB permanen)
        $foto = $request->file('foto_profile');
        $data['foto_profile'] = $foto->store('member-dokumen', 'public');
        $data['foto_profile_data'] = User::fileToDataUri($foto);

        // Upload dokumen pendukung — simpan ke kolom sesuai jenis yang dipilih
        $fieldTarget = $validated['jenis_dokumen'];
        $dok = $request->file('dokumen');
        $data[$fieldTarget] = $dok->store('member-dokumen', 'public');
        $data[User::DOKUMEN_MAP[$fieldTarget]] = User::fileToDataUri($dok);

        $user = User::create($data);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('member.dashboard');
    }

    // ===== LOGOUT =====
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}
