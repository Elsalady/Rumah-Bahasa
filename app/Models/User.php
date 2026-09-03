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
            'password' => 'hashed',
            'status' => 'string',
        ];
    }

    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class);
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
