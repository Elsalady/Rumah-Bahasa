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
                        'no_member' => $p->user->no_member,
                        'nik' => $p->user->nik,
                        'usia_label' => $p->user->usia_label,
                        'jenis_pekerjaan' => $p->user->jenis_pekerjaan,
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

    /**
     * Streaming file dokumen/foto member (base64 di DB atau path storage).
     * Dipakai supaya gambar bisa dibuka di tab baru — browser memblokir buka data: URI langsung.
     */
    public function showDokumen($id, $kolom)
    {
        if (!array_key_exists($kolom, User::DOKUMEN_MAP)) {
            abort(404);
        }

        $member = User::where('role', 'member')->findOrFail($id);
        $src = $member->fileSource($kolom);

        if (!$src) {
            abort(404);
        }

        if (preg_match('#^data:(?<mime>[a-zA-Z0-9.+/\\-]+);base64,(?<b64>.*)$#s', $src, $m)) {
            $bytes = base64_decode($m['b64'], true);
            if ($bytes === false) {
                abort(404);
            }
            $mime = $m['mime'];
            $ext = match (true) {
                str_contains($mime, 'png') => 'png',
                str_contains($mime, 'webp') => 'webp',
                str_contains($mime, 'gif') => 'gif',
                default => 'jpg',
            };
            return response($bytes, 200, [
                'Content-Type' => $mime,
                'Content-Disposition' => 'inline; filename="' . $kolom . '.' . $ext . '"',
                'Cache-Control' => 'private, max-age=3600',
            ]);
        }

        $path = storage_path('app/public/' . ltrim($src, '/'));
        if (!file_exists($path)) {
            abort(404);
        }
        return response()->file($path);
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

        $updateData = [
            'status' => $request->status,
            'catatan_member' => $request->catatan_member,
        ];

        // Nomor member diberikan saat akun disetujui (approved) pertama kali.
        // Format: RB-YYMMDD-NNNN (tanggal persetujuan WIB + urutan GLOBAL yang terus berlanjut,
        // TIDAK reset per hari — misal hari ini sampai 0003, besok lanjut 0004).
        if ($request->status === 'approved' && empty($member->no_member)) {
            $tgl = \Carbon\Carbon::now()->timezone('Asia/Jakarta')->format('ymd');
            // Urutan global tertinggi yang pernah dipakai (semua tanggal), dihitung di PHP
            // biar kompatibel dengan semua database (SQLite lokal & PostgreSQL di Railway).
            $lastSeq = User::where('role', 'member')
                ->whereNotNull('no_member')
                ->get()
                ->map(fn($u) => (int) substr($u->no_member, -4))
                ->max() ?? 0;
            $updateData['no_member'] = 'RB-' . $tgl . '-' . str_pad((string) ($lastSeq + 1), 4, '0', STR_PAD_LEFT);
        }

        $member->update($updateData);

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
            echo '<tr><th>No</th><th>Nomor Member</th><th>Nama</th><th>NIK</th><th style="text-align:center;">Tempat Lahir</th><th style="text-align:center;">Tanggal Lahir</th><th style="text-align:center;">Usia</th><th style="text-align:center;">Jenis Pekerjaan</th><th>Email</th><th style="text-align:center;">Telepon</th><th>Status</th><th>Tanggal Daftar</th></tr>';
            foreach ($members as $i => $m) {
                $warna = match($m->status) {
                    'pending' => '#b45309',
                    'approved' => '#059669',
                    'rejected' => '#dc2626',
                    default => '#000',
                };
                echo '<tr>';
                echo '<td>' . ($i + 1) . '</td>';
                echo '<td>' . htmlspecialchars($m->no_member ?? '-') . '</td>';
                echo '<td>' . htmlspecialchars($m->name) . '</td>';
                echo '<td>' . htmlspecialchars($m->nik ?? '-') . '</td>';
                echo '<td style="text-align:center;">' . htmlspecialchars($m->tempat_lahir ?? '-') . '</td>';
                echo '<td style="text-align:center;">' . ($m->tanggal_lahir ? $m->tanggal_lahir->timezone('Asia/Jakarta')->locale('id')->isoFormat('D MMM YYYY') : '-') . '</td>';
                echo '<td style="text-align:center;">' . htmlspecialchars($m->usia_label ?? '-') . '</td>';
                echo '<td style="text-align:center;">' . htmlspecialchars($m->jenis_pekerjaan ?? '-') . '</td>';
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

    /**
     * Reset semua data member (untuk persiapan user review / demo).
     * Hapus member, pendaftaran program, notifikasi member, dan file dokumen upload.
     * Admin dan konten lain (berita, program, jadwal) TIDAK terhapus.
     */
    public function resetMember()
    {
        $memberIds = User::where('role', 'member')->pluck('id');

        Pendaftaran::whereIn('user_id', $memberIds)->delete();
        \App\Models\Notifikasi::whereIn('user_id', $memberIds)->delete();

        // Hapus file dokumen member di storage/public
        $files = \Illuminate\Support\Facades\Storage::disk('public')->files('member-dokumen');
        foreach ($files as $file) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($file);
        }

        User::where('role', 'member')->delete();

        return redirect()->route('admin.member.kelola')->with('success', 'Semua data member berhasil direset. Sistem siap untuk pendaftaran baru.');
    }
}
