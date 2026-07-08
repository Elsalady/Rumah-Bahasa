<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pendaftaran extends Model
{
    protected $table = 'pendaftaran';

    protected $fillable = [
        'user_id', 'program', 'status', 'catatan',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
