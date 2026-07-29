<?php

namespace App\Console\Commands;

use App\Models\JadwalKelas;
use Illuminate\Console\Command;

class ResetJadwalMingguan extends Command
{
    protected $signature = 'jadwal:reset-mingguan';
    protected $description = 'Hapus semua jadwal kelas setiap minggu';

    public function handle()
    {
        $total = JadwalKelas::count();
        JadwalKelas::truncate();

        $this->info("✅ Berhasil menghapus {$total} jadwal kelas.");
    }
}
