<?php

namespace App\Repositories\Contracts;

use App\Models\Attendance;
use Illuminate\Pagination\LengthAwarePaginator;

interface AttendanceRepositoryInterface
{
    public function todayStats(): array;
    public function todayList(): \Illuminate\Database\Eloquent\Collection;
    public function filter(array $filters): LengthAwarePaginator;
}
