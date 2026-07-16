<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\Setting;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class AttendanceService
{
    public function validateDuplicate(Student $student, string $status): void
    {
        $exists = Attendance::where('student_id', $student->id)
            ->whereDate('attendance_date', today())
            ->where('status', $status)
            ->exists();

        if ($exists) {
            throw ValidationException::withMessages([
                'status' => "Absensi {$status} sudah dilakukan hari ini.",
            ]);
        }
    }

    public function calculateLate(Carbon $time): array
    {
        $arrivalTime = Setting::getValue('arrival_time', '08:00:00');
        $limit       = Carbon::today()->setTimeFromTimeString($arrivalTime);

        $isLate      = $time->gt($limit);
        $lateMinutes = $isLate ? (int) $limit->diffInMinutes($time) : 0;

        return ['is_late' => $isLate, 'late_minutes' => $lateMinutes];
    }

    public function record(Student $student, string $status): Attendance
    {
        $now = Carbon::now();

        $this->validateDuplicate($student, $status);

        $lateInfo = ($status === 'Berangkat')
            ? $this->calculateLate($now)
            : ['is_late' => false, 'late_minutes' => 0];

        return Attendance::create([
            'student_id'      => $student->id,
            'attendance_date' => $now->toDateString(),
            'attendance_time' => $now->toTimeString(),
            'status'          => $status,
            'is_late'         => $lateInfo['is_late'],
            'late_minutes'    => $lateInfo['late_minutes'],
        ]);
    }
}
