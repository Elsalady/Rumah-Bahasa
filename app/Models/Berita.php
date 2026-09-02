<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'berita';

    protected $fillable = [
        'judul', 'slug', 'ringkasan', 'isi', 'gambar', 'gambar_data', 'penulis', 'tanggal', 'is_active',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($berita) {
            if (empty($berita->slug)) {
                $berita->slug = Str::slug($berita->judul);
            }
        });
    }

    /**
     * URL/sumber gambar berita.
     * - gambar_data (data URI base64 hasil upload admin) diprioritaskan —
     *   tersimpan di database sehingga persist di Railway.
     * - gambar (nama file statis) dinormalisasi prefix "berita/" lama lalu
     *   diarahkan ke public/images/berita/{nama}.
     */
    public function getGambarUrlAttribute(): ?string
    {
        // 1. Upload dari admin tersimpan sebagai data URI base64 di gambar_data
        if (!empty($this->gambar_data)) {
            return $this->gambar_data;
        }

        // 2. Gambar statis/nama file
        if (empty($this->gambar)) {
            return null;
        }

        // Data URI base64 yang (mungkin) tersimpan di kolom gambar lama
        if (str_starts_with($this->gambar, 'data:')) {
            return $this->gambar;
        }

        $nama = $this->gambar;

        // Bersihkan prefix "berita/" berulang (data lama dari storage)
        while (str_starts_with($nama, 'berita/')) {
            $nama = substr($nama, strlen('berita/'));
        }

        return asset('images/berita/' . $nama);
    }
}
