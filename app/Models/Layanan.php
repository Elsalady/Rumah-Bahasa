<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Layanan extends Model
{
    use HasFactory;

    protected $table = 'layanan';

    protected $fillable = [
        'nama', 'deskripsi', 'ikon', 'gambar', 'link_wa', 'urutan', 'is_active',
    ];

    public function jadwal(): HasMany
    {
        return $this->hasMany(JadwalKelas::class, 'layanan_id');
    }
}
