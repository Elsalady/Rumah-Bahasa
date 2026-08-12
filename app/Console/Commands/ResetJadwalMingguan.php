<?php

namespace App\Console\Commands;

use App\Models\JadwalKelas;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class ResetJadwalMingguan extends Command
{
    protected $signature = 'jadwal:reset-mingguan';
    protected $description = 'Hapus semua jadwal kelas setiap minggu';

    public function handle()
    {
        $total = JadwalKelas::whereDate('tanggal', '<', Carbon::now()->startOfWeek()->format('Y-m-d'))->count();
        JadwalKelas::whereDate('tanggal', '<', Carbon::now()->startOfWeek()->format('Y-m-d'))->delete();

        $this->info("✅ Berhasil menghapus {$total} jadwal kelas yang sudah lewat.");
    }
}
