<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Absensi extends Model
{
    protected $fillable = [
        'nama',
        'instansi',
        'bidang_id',
        'latitude',
        'longitude',
        'alamat_lokasi',
        'foto',
        'tanggal',
        'jam',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function bidang(): BelongsTo
    {
        return $this->belongsTo(Bidang::class);
    }
}