<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Layanan extends Model
{
    use HasFactory;

    protected $table = 'layanan';

    protected $fillable = [
        'nama', 'deskripsi', 'ikon', 'gambar', 'link_wa', 'urutan', 'is_active',
    ];

    public function jadwal()
    {
        // jadwal_kelas tidak punya kolom layanan_id; cocokkan nama_kelas dengan nama program (substring)
        $keyword = strtolower(trim(str_replace('Kelas ', '', $this->nama)));

        return JadwalKelas::query()->whereRaw('LOWER(nama_kelas) LIKE ?', ["%{$keyword}%"]);
    }
}
