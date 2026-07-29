<?php

use Illuminate\Support\Facades\Schedule;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Reset jadwal kelas setiap hari Minggu jam 00:00
Schedule::command('jadwal:reset-mingguan')->weeklyOn(0, '00:00');
