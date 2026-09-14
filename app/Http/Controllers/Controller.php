<?php

namespace App\Http\Controllers;

abstract class Controller
{
    /**
     * Verifikasi kredensial admin sebelum aksi sensitif (reset data, dll).
     * Lempar ValidationException otomatis redirect kembali ke form jika salah.
     */
    protected function verifikasiKredensialAdmin(\Illuminate\Http\Request $request): void
    {
        $user = auth()->user();

        $request->validate([
            'nama_admin' => 'required|string',
            'password'   => 'required|string',
        ], [
            'nama_admin.required' => 'Nama admin wajib diisi.',
            'password.required'   => 'Password admin wajib diisi.',
        ]);

        $namaInput = mb_strtolower(trim($request->nama_admin));
        $namaAdmin = mb_strtolower(trim($user->name));

        if ($namaInput !== $namaAdmin || !\Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'password' => 'Nama atau password admin tidak valid. Data tidak direset.',
            ]);
        }
    }
}
