<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'no_member',
        'nik',
        'tempat_lahir',
        'tanggal_lahir',
        'umur',
        'rentang_usia',
        'jenis_pekerjaan',
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'foto_profile',
        'foto_profile_data',
        'ktp',
        'ktp_data',
        'surat_domisili',
        'surat_domisili_data',
        'ktm',
        'ktm_data',
        'kk',
        'kk_data',
        'status',
        'catatan_member',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'tanggal_lahir' => 'date',
            'password' => 'hashed',
            'status' => 'string',
        ];
    }

    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class);
    }

    /**
     * Kategori rentang usia member (dipakai untuk pendataan/rekap Pemkab).
     * 1-18 th = remaja, 19-36 th = dewasa, 37+ th = orang_tua.
     */
    public const UMUR_MAP = [
        'remaja' => 'Remaja (1-18 th)',
        'dewasa' => 'Dewasa (19-36 th)',
        'orang_tua' => 'Orang Tua (37+ th)',
    ];

    /**
     * Tentukan kategori rentang usia dari tanggal lahir.
     */
    public static function kategoriUsia($tanggalLahir): ?string
    {
        if (!$tanggalLahir) {
            return null;
        }
        $umur = \Carbon\Carbon::parse($tanggalLahir)->age;
        if ($umur <= 18) {
            return 'remaja';
        }
        if ($umur <= 36) {
            return 'dewasa';
        }
        return 'orang_tua';
    }

    /**
     * Label rentang usia untuk keperluan tampilan.
     */
    public function getRentangUsiaLabelAttribute(): ?string
    {
        return self::UMUR_MAP[$this->rentang_usia] ?? $this->rentang_usia;
    }

    /**
     * Tampilan usia untuk admin: "18 (Remaja)" / "25 (Dewasa)" / "40 (Orang Tua)".
     */
    public function getUsiaLabelAttribute(): ?string
    {
        if ($this->umur === null) {
            return null;
        }
        $kategori = self::UMUR_MAP[$this->rentang_usia] ?? $this->rentang_usia;
        return $kategori ? $this->umur . ' (' . $kategori . ')' : (string) $this->umur;
    }

    /**
     * Kolom path upload (storage) yang punya pasangan kolom *_data (base64 di DB).
     * Dipakai untuk menyimpan & membaca file member secara konsisten.
     */
    public const DOKUMEN_MAP = [
        'foto_profile' => 'foto_profile_data',
        'ktp' => 'ktp_data',
        'surat_domisili' => 'surat_domisili_data',
        'ktm' => 'ktm_data',
        'kk' => 'kk_data',
    ];

    /**
     * Ubah UploadedFile menjadi data URI base64 siap simpan di kolom *_data.
     */
    public static function fileToDataUri(\Illuminate\Http\UploadedFile $file): string
    {
        $mime = $file->getMimeType() ?: 'application/octet-stream';
        return 'data:' . $mime . ';base64,' . base64_encode($file->get());
    }

    /**
     * Sumber gambar/berkas yang siap dipakai di <img src> / <a href>:
     * prioritaskan data base64 di DB (permanen), fallback ke path storage.
     */
    public function fileSource(string $field): ?string
    {
        $dataField = self::DOKUMEN_MAP[$field] ?? null;
        if ($dataField && !empty($this->$dataField)) {
            return $this->$dataField;
        }
        return $this->$field ? asset('storage/' . $this->$field) : null;
    }
}
