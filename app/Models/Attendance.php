<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'check_in_time',
        'check_out_time',
        'status',
        'notes',
        'photo_path',
        'location_latitude',
        'location_longitude',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    /**
     * Get the user that owns the attendance record.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if attendance is late based on deadline
     */
    public static function isLate($checkInTime, $deadline = '08:00:00')
    {
        return $checkInTime > $deadline;
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeColor()
    {
        return match($this->status) {
            'present' => 'bg-green-500',
            'late' => 'bg-yellow-500',
            'absent' => 'bg-red-500',
            default => 'bg-gray-500',
        };
    }
}
