<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Berita extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul', 'slug', 'ringkasan', 'isi', 'gambar', 'penulis', 'tanggal', 'is_active',
    ];
}
