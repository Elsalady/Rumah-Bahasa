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
}
