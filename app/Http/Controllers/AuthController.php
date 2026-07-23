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
            'ktp' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'surat_domisili' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'ktm' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'kk' => 'required|image|mimes:jpeg,png,jpg|max:2048',
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

        // Upload dokumen
        $dokumenFields = ['foto_profile', 'ktp', 'surat_domisili', 'ktm', 'kk'];
        foreach ($dokumenFields as $field) {
            if ($request->hasFile($field)) {
                $data[$field] = $request->file($field)->store('member-dokumen', 'public');
            }
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
