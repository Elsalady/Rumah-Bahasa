<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JadwalKelas extends Model
{
    use HasFactory;

    protected $table = 'jadwal_kelas';

    protected $fillable = [
        'layanan_id', 'tanggal', 'nama_kelas', 'hari', 'jam_mulai', 'jam_selesai',
        'pengajar', 'jenis', 'mode', 'ruangan_link', 'kuota', 'is_active',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function layanan(): BelongsTo
    {
        return $this->belongsTo(Layanan::class);
    }
}
