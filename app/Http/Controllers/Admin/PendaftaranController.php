<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class PendaftaranController extends Controller
{
    public function index()
    {
        $daftar = Pendaftaran::with('user')->orderBy('created_at', 'desc')->get();
        return view('admin.pendaftaran.index', compact('daftar'));
    }

    public function update(Request $request, $id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        $request->validate(['status' => 'required|in:pending,confirmed,rejected']);
        $pendaftaran->update(['status' => $request->status, 'catatan' => $request->catatan]);
        return redirect()->route('admin.pendaftaran.index')->with('success', 'Status pendaftaran berhasil diperbarui.');
    }

    public function export()
    {
        $daftar = Pendaftaran::with('user')->orderBy('created_at', 'desc')->get();

        $filename = 'pendaftaran-' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($daftar) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['No', 'Nama', 'Email', 'Telepon', 'Program', 'Status', 'Tanggal Daftar']);
            foreach ($daftar as $i => $p) {
                fputcsv($handle, [
                    $i + 1,
                    $p->user->name,
                    $p->user->email,
                    $p->user->phone ?? '-',
                    $p->program,
                    ucfirst($p->status),
                    $p->created_at->locale('id')->isoFormat('D MMM YYYY, HH:mm'),
                ]);
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
