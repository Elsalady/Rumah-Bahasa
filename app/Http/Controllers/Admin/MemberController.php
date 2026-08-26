<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Pendaftaran;
use App\Models\JadwalKelas;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Kelompokkan pendaftar program menjadi folder: jenis → mode → kelas.
     */
    private function grupPendaftar($daftar)
    {
        $jadwals = JadwalKelas::where('is_active', true)->orderBy('nama_kelas')->get();

        $grup = [
            'tematik' => ['online' => [], 'offline' => []],
            'tentative' => ['online' => [], 'offline' => []],
        ];

        $daftarByJadwal = $daftar->whereNotNull('jadwal_id')->groupBy('jadwal_id');
        $daftarTanpaJadwal = $daftar->whereNull('jadwal_id');
        $daftarByProgram = $daftarTanpaJadwal->groupBy('program');

        foreach ($jadwals as $j) {
            $anggota = $daftarByJadwal->get($j->id, collect());

            if ($anggota->isEmpty()) {
                $keyword = strtolower(trim(str_replace('Kelas ', '', $j->nama_kelas)));
                foreach ($daftarByProgram as $program => $items) {
                    $programKecil = strtolower(trim(str_replace('Kelas ', '', $program)));
                    if (str_contains($programKecil, $keyword) || str_contains($keyword, $programKecil)) {
                        $anggota = $anggota->merge($items);
                    }
                }
            }

            $anggota = $anggota->sortByDesc('created_at')->values();
            if ($anggota->count() === 0) {
                continue;
            }

            // Format data untuk JSON (tanggal WIB & jam rapi)
            $anggota = $anggota->map(function ($p) {
                return [
                    'id' => $p->id,
                    'user' => $p->user ? [
                        'name' => $p->user->name,
                        'email' => $p->user->email,
                        'phone' => $p->user->phone,
                    ] : null,
                    'status' => $p->status,
                    'created_at' => $p->created_at
                        ? $p->created_at->timezone('Asia/Jakarta')->locale('id')->isoFormat('D MMM YYYY, HH:mm')
                        : '-',
                ];
            })->values();

            $grup[$j->jenis][$j->mode][] = [
                'kelas' => $j->nama_kelas,
                'hari' => $j->hari,
                'jam_mulai' => \Carbon\Carbon::parse($j->jam_mulai)->format('H:i'),
                'jam_selesai' => \Carbon\Carbon::parse($j->jam_selesai)->format('H:i'),
                'pengajar' => $j->pengajar,
                'kuota' => $j->kuota,
                'anggota' => $anggota,
            ];
        }

        return $grup;
    }

    public function kelola()
    {
        $members = User::where('role', 'member')->orderBy('created_at', 'desc')->get();
        $daftar = Pendaftaran::with('user')->orderBy('created_at', 'desc')->get();
        $grup = $this->grupPendaftar($daftar);
        return view('admin.member.kelola', compact('members', 'daftar', 'grup'));
    }

    public function show($id)
    {
        $member = User::where('role', 'member')->findOrFail($id);
        return view('admin.member.show', compact('member'));
    }

    public function update(Request $request, $id)
    {
        $member = User::where('role', 'member')->findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'catatan_member' => $request->status === 'rejected' ? 'required|max:1000' : 'nullable|max:1000',
        ], [
            'catatan_member.required' => 'Catatan wajib diisi saat status ditolak (rejected).',
        ]);

        $member->update([
            'status' => $request->status,
            'catatan_member' => $request->catatan_member,
        ]);

        // Kirim notifikasi ke member saat status berubah (approved/rejected)
        if (in_array($request->status, ['approved', 'rejected'])) {
            \App\Models\Notifikasi::create([
                'user_id' => $member->id,
                'judul' => $request->status === 'approved' ? '✅ Akun Kamu Disetujui' : '❌ Akun Kamu Ditolak',
                'pesan' => $request->status === 'approved'
                    ? 'Selamat! Akun kamu telah disetujui. Kamu sekarang bisa mendaftar program kelas.' . ($request->catatan_member ? ' Catatan admin: ' . $request->catatan_member : '')
                    : 'Akun kamu ditolak. ' . ($request->catatan_member ? 'Catatan admin: ' . $request->catatan_member : 'Silakan hubungi admin untuk info lebih lanjut.'),
                'link' => route('member.dashboard'),
            ]);
        }

        return redirect()->route('admin.member.show', $id)->with('success', 'Status member berhasil diperbarui.');
    }

    public function export()
    {
        $members = User::where('role', 'member')->orderBy('created_at', 'desc')->get();

        $filename = 'data-member-' . date('Y-m-d') . '.xls';
        $headers = [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($members) {
            echo '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
            echo '<head><meta charset="UTF-8"><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>Data Member</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]-->';
            echo '<style>';
            echo 'table{border-collapse:collapse;width:100%;font-family:Calibri,Arial,sans-serif;font-size:11pt;}';
            echo 'th{background:#005f73;color:#fff;padding:10px 8px;font-weight:600;border:1px solid #004d5e;}';
            echo 'td{padding:8px;border:1px solid #d1d5db;vertical-align:middle;}';
            echo 'tr:nth-child(even){background:#f0fdfa;}';
            echo '</style></head><body>';
            echo '<table>';
            echo '<tr><th>No</th><th>Nama</th><th>Email</th><th style="text-align:center;">Telepon</th><th>Status</th><th>Tanggal Daftar</th></tr>';
            foreach ($members as $i => $m) {
                $warna = match($m->status) {
                    'pending' => '#b45309',
                    'approved' => '#059669',
                    'rejected' => '#dc2626',
                    default => '#000',
                };
                echo '<tr>';
                echo '<td>' . ($i + 1) . '</td>';
                echo '<td>' . htmlspecialchars($m->name) . '</td>';
                echo '<td>' . htmlspecialchars($m->email) . '</td>';
                echo '<td style="text-align:center;">' . htmlspecialchars($m->phone ?? '-') . '</td>';
                echo '<td style="text-align:center;color:' . $warna . ';font-weight:600;">' . ucfirst($m->status) . '</td>';
                echo '<td>' . $m->created_at->timezone('Asia/Jakarta')->locale('id')->isoFormat('D MMM YYYY, HH:mm') . '</td>';
                echo '</tr>';
            }
            echo '</table></body></html>';
        };

        return response()->stream($callback, 200, $headers);
    }
}
