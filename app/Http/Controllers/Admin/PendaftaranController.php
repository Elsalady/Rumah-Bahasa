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
            echo '<tr><th>No</th><th>Nama</th><th>Email</th><th style="text-align:center;">Telepon</th><th style="text-align:center;">Program</th><th style="text-align:center;">Status</th><th>Tanggal Daftar</th></tr>';
            foreach ($daftar as $i => $p) {
                $warna = match($p->status) {
                    'pending' => '#b45309',
                    'confirmed' => '#059669',
                    'rejected' => '#dc2626',
                    default => '#000',
                };
                echo '<tr>';
                echo '<td>' . ($i + 1) . '</td>';
                echo '<td>' . htmlspecialchars($p->user->name) . '</td>';
                echo '<td>' . htmlspecialchars($p->user->email) . '</td>';
                echo '<td style="text-align:center;">' . htmlspecialchars($p->user->phone ?? '-') . '</td>';
                echo '<td style="text-align:center;">' . htmlspecialchars($p->program) . '</td>';
                echo '<td style="text-align:center;color:' . $warna . ';font-weight:600;">' . ucfirst($p->status) . '</td>';
                echo '<td>' . $p->created_at->locale('id')->isoFormat('D MMM YYYY, HH:mm') . '</td>';
                echo '</tr>';
            }
            echo '</table></body></html>';
        };

        return response()->stream($callback, 200, $headers);
    }
}
