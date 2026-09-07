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
            'nik' => 'required|digits_between:16,16|unique:users,nik',
            'tempat_lahir' => 'required|max:255',
            'tanggal_lahir' => 'required|date|before:today',
            'jenis_pekerjaan' => 'required|max:255',
            'foto_profile' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'ktp' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'jenis_dokumen' => 'nullable|in:surat_domisili,ktm,kk',
            'dokumen' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'email.unique' => 'Email ini sudah terdaftar. Silakan gunakan email lain atau login dengan akun yang sudah ada.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'name.required' => 'Nama lengkap wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'nik.required' => 'Nomor NIK wajib diisi.',
            'nik.digits_between' => 'NIK harus terdiri dari 16 digit angka.',
            'nik.unique' => 'NIK ini sudah terdaftar. Silakan gunakan akun yang sudah ada.',
            'tempat_lahir.required' => 'Tempat lahir wajib diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.before' => 'Tanggal lahir harus sebelum hari ini.',
            'jenis_pekerjaan.required' => 'Jenis pekerjaan wajib diisi.',
            'foto_profile.required' => 'Foto profil wajib diunggah.',
            'ktp.required' => 'Scan/foto KTP wajib diunggah.',
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'nik' => $validated['nik'],
            'tempat_lahir' => $validated['tempat_lahir'],
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'umur' => \Carbon\Carbon::parse($validated['tanggal_lahir'])->age,
            'rentang_usia' => User::kategoriUsia($validated['tanggal_lahir']),
            'jenis_pekerjaan' => $validated['jenis_pekerjaan'],
            'role' => 'member',
            'status' => 'pending',
        ];

        // Nomor member diberikan setelah akun disetujui admin (lihat Admin\MemberController::update),
        // jadi tidak digenerate di sini untuk menghindari bentrok nomor saat banyak pendaftar.

        // Upload foto profil — simpan path (storage) + data base64 (DB permanen)
        $foto = $request->file('foto_profile');
        $data['foto_profile'] = $foto->store('member-dokumen', 'public');
        $data['foto_profile_data'] = User::fileToDataUri($foto);

        // Upload KTP — WAJIB untuk semua pendaftar, kolom tersendiri
        $ktp = $request->file('ktp');
        $data['ktp'] = $ktp->store('member-dokumen', 'public');
        $data['ktp_data'] = User::fileToDataUri($ktp);

        // Upload dokumen pendukung LAINNYA (opsional) — hanya jika jenis dipilih
        if ($request->filled('jenis_dokumen')) {
            $fieldTarget = $request->jenis_dokumen;
            $dok = $request->file('dokumen');
            $data[$fieldTarget] = $dok->store('member-dokumen', 'public');
            $data[User::DOKUMEN_MAP[$fieldTarget]] = User::fileToDataUri($dok);
        }

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
