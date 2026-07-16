<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    protected $fillable = [
        'student_id',
        'attendance_date',
        'attendance_time',
        'status',
        'is_late',
        'late_minutes',
    ];

    protected $casts = [
        'attendance_date' => 'date',
        'is_late'         => 'boolean',
        'late_minutes'    => 'integer',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
