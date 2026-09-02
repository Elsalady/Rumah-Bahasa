<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalKelas;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class PendaftaranController extends Controller
{
    public function index()
    {
        $daftar = Pendaftaran::with('user')->orderBy('created_at', 'desc')->get();
        $jadwals = JadwalKelas::where('is_active', true)->orderBy('nama_kelas')->get();

        // Kelompokkan pendaftar berdasarkan jenis → mode → kelas
        $grup = [
            'tematik' => ['online' => [], 'offline' => []],
            'tentative' => ['online' => [], 'offline' => []],
        ];

        $daftarByJadwal = $daftar->whereNotNull('jadwal_id')->groupBy('jadwal_id');
        $daftarTanpaJadwal = $daftar->whereNull('jadwal_id');
        $daftarByProgram = $daftarTanpaJadwal->groupBy('program');

        foreach ($jadwals as $j) {
            // Anggota via jadwal_id (data baru)
            $anggota = $daftarByJadwal->get($j->id, collect());

            // Fallback: pendaftar lama tanpa jadwal_id, cocokkan via keyword program
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

            $grup[$j->jenis][$j->mode][] = [
                'kelas' => $j->nama_kelas,
                'hari' => $j->hari,
                'jam_mulai' => $j->jam_mulai,
                'jam_selesai' => $j->jam_selesai,
                'pengajar' => $j->pengajar,
                'kuota' => $j->kuota,
                'anggota' => $anggota,
            ];
        }

        return view('admin.pendaftaran.index', compact('daftar', 'grup'));
    }

    public function export()
    {
        $daftar = Pendaftaran::with('user')->orderBy('created_at', 'desc')->get();

        $filename = 'pendaftaran-' . date('Y-m-d') . '.xls';
        $headers = [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($daftar) {
            echo '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
            echo '<head><meta charset="UTF-8"><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>Pendaftaran</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]-->';
            echo '<style>';
            echo 'table{border-collapse:collapse;width:100%;font-family:Calibri,Arial,sans-serif;font-size:11pt;}';
            echo 'th{background:#005f73;color:#fff;padding:10px 8px;font-weight:600;border:1px solid #004d5e;}';
            echo 'td{padding:8px;border:1px solid #d1d5db;vertical-align:middle;}';
            echo 'tr:nth-child(even){background:#f0fdfa;}';
            echo '</style></head><body>';
            echo '<table>';
            echo '<tr><th>No</th><th>Nomor Member</th><th>Nama</th><th>Email</th><th style="text-align:center;">Telepon</th><th style="text-align:center;">Program</th><th style="text-align:center;">Status</th><th>Tanggal Daftar</th></tr>';
            foreach ($daftar as $i => $p) {
                $warna = match($p->status) {
                    'pending' => '#b45309',
                    'confirmed' => '#059669',
                    'rejected' => '#dc2626',
                    default => '#000',
                };
                echo '<tr>';
                echo '<td>' . ($i + 1) . '</td>';
                echo '<td>' . htmlspecialchars($p->user->no_member ?? '-') . '</td>';
                echo '<td>' . htmlspecialchars($p->user->name) . '</td>';
                echo '<td>' . htmlspecialchars($p->user->email) . '</td>';
                echo '<td style="text-align:center;">' . htmlspecialchars($p->user->phone ?? '-') . '</td>';
                echo '<td style="text-align:center;">' . htmlspecialchars($p->program) . '</td>';
                echo '<td style="text-align:center;color:' . $warna . ';font-weight:600;">' . ucfirst($p->status) . '</td>';
                echo '<td>' . $p->created_at->timezone('Asia/Jakarta')->locale('id')->isoFormat('D MMM YYYY, HH:mm') . '</td>';
                echo '</tr>';
            }
            echo '</table></body></html>';
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Reset semua data pendaftar program (tabel pendaftaran).
     * Hanya menghapus pendaftaran program — akun member TIDAK dihapus.
     */
    public function resetPendaftar()
    {
        Pendaftaran::query()->delete();

        return redirect()->route('admin.member.kelola', ['tab' => 'pendaftar'])
            ->with('success', 'Semua pendaftar program berhasil dihapus. Member tetap tersimpan.');
    }
}
