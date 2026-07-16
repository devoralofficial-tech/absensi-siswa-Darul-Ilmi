<?php

namespace App\Repositories;

use App\Models\Attendance;
use App\Models\Student;
use App\Repositories\Contracts\AttendanceRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class AttendanceRepository implements AttendanceRepositoryInterface
{
    public function todayStats(): array
    {
        $berangkat   = Attendance::whereDate('attendance_date', today())->where('status', 'Berangkat')->count();
        $pulang      = Attendance::whereDate('attendance_date', today())->where('status', 'Pulang')->count();
        $totalSiswa  = Student::count();
        $belumPulang = $berangkat - $pulang;
        $terlambat   = Attendance::whereDate('attendance_date', today())->where('status', 'Berangkat')->where('is_late', true)->count();

        return compact('berangkat', 'pulang', 'belumPulang', 'terlambat', 'totalSiswa');
    }

    public function todayList(): Collection
    {
        return Attendance::with('student')
            ->whereDate('attendance_date', today())
            ->orderByDesc('created_at')
            ->get();
    }

    public function filter(array $filters): LengthAwarePaginator
    {
        $query = Attendance::with('student')->orderByDesc('attendance_date')->orderByDesc('attendance_time');

        if (! empty($filters['tanggal'])) {
            $query->whereDate('attendance_date', $filters['tanggal']);
        }

        if (! empty($filters['status']) && in_array($filters['status'], ['Berangkat', 'Pulang'])) {
            $query->where('status', $filters['status']);
        }

        if (! empty($filters['nama'])) {
            $query->whereHas('student', fn ($q) => $q->where('nama', 'like', '%' . $filters['nama'] . '%'));
        }

        return $query->paginate(20)->withQueryString();
    }
}
