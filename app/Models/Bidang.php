<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bidang extends Model
{
    protected $fillable = [
        'nama_bidang',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function absensis(): HasMany
    {
        return $this->hasMany(Absensi::class);
    }
}