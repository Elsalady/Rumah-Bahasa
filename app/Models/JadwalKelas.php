<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JadwalKelas extends Model
{
    use HasFactory;

    protected $table = 'jadwal_kelas';

    protected $fillable = [
        'nama_kelas', 'hari', 'jam_mulai', 'jam_selesai',
        'pengajar', 'jenis', 'mode', 'ruangan_link', 'kuota', 'is_active',
    ];
}
