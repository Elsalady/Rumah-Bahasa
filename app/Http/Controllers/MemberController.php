<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Pendaftaran;
use App\Models\JadwalKelas;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        $pendaftaran = Pendaftaran::where('user_id', $user->id)->latest()->get();
        $notifikasi = $user->notifikasi()->latest()->limit(5)->get();
        $notifUnread = $user->notifikasi()->where('is_read', false)->count();
        return view('member.dashboard', compact('user', 'pendaftaran', 'notifikasi', 'notifUnread'));
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
            'foto_profile' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'ktp' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'surat_domisili' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'ktm' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'kk' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['name', 'phone', 'address']);
        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        $dokumenFields = ['foto_profile', 'ktp', 'surat_domisili', 'ktm', 'kk'];
        foreach ($dokumenFields as $field) {
            if ($request->hasFile($field)) {
                if ($user->$field) {
                    Storage::disk('public')->delete($user->$field);
                }
                $data[$field] = $request->file($field)->store('member-dokumen', 'public');
            }
        }

        $user->update($data);
        return redirect()->route('member.edit')->with('success', '✅ Profil berhasil diperbarui.');
    }

    public function program()
    {
        $programs = Layanan::where('is_active', true)->orderBy('urutan')->get();
        $jadwal = JadwalKelas::where('is_active', true)
            ->orderByRaw("CASE hari WHEN 'Senin' THEN 1 WHEN 'Selasa' THEN 2 WHEN 'Rabu' THEN 3 WHEN 'Kamis' THEN 4 WHEN 'Jumat' THEN 5 WHEN 'Sabtu' THEN 6 WHEN 'Minggu' THEN 7 END")
            ->orderBy('jam_mulai')
            ->get()
            ->groupBy('hari');
        return view('member.program', compact('programs', 'jadwal'));
    }

    public function jadwal()
    {
        $jadwal = JadwalKelas::where('is_active', true)
            ->orderByRaw("CASE hari WHEN 'Senin' THEN 1 WHEN 'Selasa' THEN 2 WHEN 'Rabu' THEN 3 WHEN 'Kamis' THEN 4 WHEN 'Jumat' THEN 5 WHEN 'Sabtu' THEN 6 WHEN 'Minggu' THEN 7 END")
            ->orderBy('jam_mulai')
            ->get()
            ->groupBy('hari');

        return view('member.jadwal', compact('jadwal'));
    }

    public function notifikasiIndex()
    {
        $user = auth()->user();
        $notifikasi = $user->notifikasi()->latest()->get();
        return view('member.notifikasi', compact('notifikasi'));
    }

    public function notifikasiBaca($id)
    {
        $notif = Notifikasi::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $notif->update(['is_read' => true]);
        if ($notif->link) {
            return redirect($notif->link);
        }
        return redirect()->back();
    }

    public function notifikasiBacaSemua()
    {
        auth()->user()->notifikasi()->where('is_read', false)->update(['is_read' => true]);
        return redirect()->route('member.notifikasi')->with('success', 'Semua notifikasi ditandai sudah dibaca.');
    }
}
