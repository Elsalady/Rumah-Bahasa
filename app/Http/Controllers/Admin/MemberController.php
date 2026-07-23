<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $members = User::where('role', 'member')->orderBy('created_at', 'desc')->get();
        return view('admin.member.index', compact('members'));
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
            'catatan_member' => 'nullable|max:1000',
        ]);

        $member->update([
            'status' => $request->status,
            'catatan_member' => $request->catatan_member,
        ]);

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
                echo '<td>' . $m->created_at->locale('id')->isoFormat('D MMM YYYY, HH:mm') . '</td>';
                echo '</tr>';
            }
            echo '</table></body></html>';
        };

        return response()->stream($callback, 200, $headers);
    }
}
