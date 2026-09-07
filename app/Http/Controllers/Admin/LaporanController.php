<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanController extends Controller
{
    /**
     * Hitung batas periode dari query string (minggu / bulan / semua).
     * Minggu dihitung Senin–Minggu (ISO week), bulan dari tgl 1 s/d akhir bulan.
     *
     * @return [string, Carbon|null, Carbon|null, string]  [periode, mulai, akhir, label]
     */
    private function periode(Request $request): array
    {
        $periode = in_array($request->get('periode'), ['minggu', 'bulan', 'semua'])
            ? $request->get('periode')
            : 'minggu';
        $mulai = null;
        $akhir = null;

        if ($periode === 'minggu') {
            $minggu = $request->get('minggu', Carbon::now()->format('o-\WW'));
            if (preg_match('/^(\d{4})-W(\d{1,2})$/i', $minggu, $m)) {
                $mulai = Carbon::now()->setISODate((int) $m[1], (int) $m[2], 1)->startOfDay();
                $akhir = $mulai->copy()->addDays(6)->endOfDay();
            }
            $label = $mulai
                ? $mulai->isoFormat('D MMM YYYY') . ' – ' . $akhir->isoFormat('D MMM YYYY')
                : 'Minggu tidak valid';
        } elseif ($periode === 'bulan') {
            $bulan = $request->get('bulan', Carbon::now()->format('Y-m'));
            if (preg_match('/^(\d{4})-(\d{2})$/', $bulan, $m)) {
                $mulai = Carbon::create((int) $m[1], (int) $m[2], 1)->startOfDay();
                $akhir = $mulai->copy()->endOfMonth()->endOfDay();
            }
            $label = $mulai ? $mulai->translatedFormat('F Y') : 'Bulan tidak valid';
        } else {
            $periode = 'semua';
            $label = 'Semua Data';
        }

        return [$periode, $mulai, $akhir, $label];
    }

    /**
     * Nama kelas / program dari 1 baris pendaftaran (pakai jadwal kalau ada).
     */
    private function namaKelas($p): string
    {
        if ($p->jadwal) {
            return trim($p->jadwal->nama_kelas);
        }
        return trim($p->program ?: 'Tanpa kelas');
    }

    /**
     * Ambil daftar pendaftar confirmed + ringkasannya untuk periode yang dipilih.
     *
     * @return [string, Carbon|null, Carbon|null, string, Collection, array]
     */
    private function dataLaporan(Request $request): array
    {
        [$periode, $mulai, $akhir, $label] = $this->periode($request);

        $query = Pendaftaran::with(['user', 'jadwal'])
            ->where('status', 'confirmed');

        if ($mulai && $akhir) {
            $query->whereBetween('created_at', [$mulai, $akhir]);
        }

        $daftar = $query->orderBy('created_at', 'desc')->get();

        $ringkasan = [
            'total_pendaftar' => $daftar->count(),
            'total_member' => $daftar->pluck('user_id')->unique()->count(),
            'member_approved' => $daftar
                ->filter(fn ($p) => $p->user && $p->user->status === 'approved')
                ->pluck('user_id')->unique()->count(),
            'per_kelas' => $daftar->groupBy(fn ($p) => $this->namaKelas($p))->map->count()->sortDesc(),
            'per_jenis' => $daftar->groupBy('jenis')->map->count()->sortDesc(),
            'per_mode' => $daftar->groupBy('mode')->map->count()->sortDesc(),
        ];

        return [$periode, $mulai, $akhir, $label, $daftar, $ringkasan];
    }

    public function index(Request $request)
    {
        [$periode, $mulai, $akhir, $label, $daftar, $ringkasan] = $this->dataLaporan($request);

        return view('admin.laporan.index', compact('periode', 'mulai', 'akhir', 'label', 'daftar', 'ringkasan'));
    }

    public function export(Request $request)
    {
        [$periode, $mulai, $akhir, $label, $daftar, $ringkasan] = $this->dataLaporan($request);

        if ($periode === 'minggu') {
            $slug = 'mingguan-' . ($mulai ? $mulai->format('Y-\WW') : date('Y-\WW'));
        } elseif ($periode === 'bulan') {
            $slug = 'bulanan-' . ($mulai ? $mulai->format('Y-m') : date('Y-m'));
        } else {
            $slug = 'semua';
        }

        $filename = 'laporan-' . $slug . '-' . date('Ymd-Hi') . '.xls';
        $headers = [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($daftar, $ringkasan, $label, $periode) {
            echo '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
            echo '<head><meta charset="UTF-8"><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>Laporan</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]-->';
            echo '<style>';
            echo 'body{font-family:Calibri,Arial,sans-serif;font-size:11pt;color:#111827;}';
            echo 'h2{color:#005f73;margin:0 0 4px;}';
            echo '.meta{color:#374151;margin-bottom:14px;}';
            echo 'table{border-collapse:collapse;width:100%;page-break-inside:auto;}';
            echo 'th{background:#005f73;color:#fff;padding:8px 6px;font-weight:600;border:1px solid #004d5e;text-align:left;}';
            echo 'td{padding:6px;border:1px solid #d1d5db;}';
            echo 'tr:nth-child(even){background:#f0fdfa;}';
            echo '.sum th{background:#e2e8f0;color:#0f172a;}';
            echo '.jumlah{text-align:center;font-weight:700;}';
            echo '</style></head><body>';

            // Judul & periode
            echo '<h2>Laporan Pendaftar Rumah Bahasa Surabaya</h2>';
            echo '<div class="meta">Periode: <strong>' . htmlspecialchars($label) . '</strong> | Data pendaftaran yang statusnya <strong>Terdaftar (confirmed)</strong></div>';

            // Ringkasan
            echo '<table class="sum"><tr><th>Pendaftar (confirmed)</th><th>Member Unik</th><th>Member Disetujui</th></tr>';
            echo '<tr><td class="jumlah">' . $ringkasan['total_pendaftar'] . '</td><td class="jumlah">' . $ringkasan['total_member'] . '</td><td class="jumlah">' . $ringkasan['member_approved'] . '</td></tr>';
            echo '</table>';
            echo '<br>';

            // Breakdown per kelas
            echo '<table class="sum"><tr><th>Program / Kelas</th><th>Jumlah Pendaftar</th></tr>';
            if ($ringkasan['per_kelas']->count()) {
                foreach ($ringkasan['per_kelas'] as $kelas => $jumlah) {
                    echo '<tr><td>' . htmlspecialchars($kelas) . '</td><td class="jumlah">' . $jumlah . '</td></tr>';
                }
            } else {
                echo '<tr><td colspan="2">Tidak ada data pada periode ini.</td></tr>';
            }
            echo '</table>';
            echo '<br>';

            // Detail pendaftar
            echo '<table>';
            echo '<tr><th>No</th><th>Tanggal Daftar</th><th>No Member</th><th>Nama</th><th>NIK</th><th>Usia</th><th>Pekerjaan</th><th>Email</th><th>No. HP</th><th>Jenis</th><th>Mode</th><th>Program / Kelas</th><th>Status Anggota</th></tr>';
            if ($daftar->count()) {
                foreach ($daftar as $i => $p) {
                    $u = $p->user;
                    echo '<tr>';
                    echo '<td>' . ($i + 1) . '</td>';
                    echo '<td>' . $p->created_at->timezone('Asia/Jakarta')->locale('id')->isoFormat('D MMM YYYY, HH:mm') . '</td>';
                    echo '<td>' . htmlspecialchars($u && $u->no_member ? $u->no_member : '-') . '</td>';
                    echo '<td>' . htmlspecialchars($u ? $u->name : '-') . '</td>';
                    echo '<td>' . htmlspecialchars($u && $u->nik ? $u->nik : '-') . '</td>';
                    echo '<td>' . htmlspecialchars($u && $u->usia_label ? $u->usia_label : '-') . '</td>';
                    echo '<td>' . htmlspecialchars($u && $u->jenis_pekerjaan ? $u->jenis_pekerjaan : '-') . '</td>';
                    echo '<td>' . htmlspecialchars($u ? $u->email : '-') . '</td>';
                    echo '<td>' . htmlspecialchars($u && $u->phone ? $u->phone : '-') . '</td>';
                    echo '<td>' . htmlspecialchars($p->jenis ?: '-') . '</td>';
                    echo '<td>' . htmlspecialchars($p->mode ?: '-') . '</td>';
                    echo '<td>' . htmlspecialchars($this->namaKelas($p)) . '</td>';
                    echo '<td>' . ($u ? ucfirst($u->status) : '-') . '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="13" style="text-align:center;">Tidak ada pendaftar pada periode ini.</td></tr>';
            }
            echo '</table></body></html>';
        };

        return response()->stream($callback, 200, $headers);
    }
}