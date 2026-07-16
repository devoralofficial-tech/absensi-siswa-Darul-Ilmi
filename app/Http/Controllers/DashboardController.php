<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\AttendanceRepositoryInterface;

class DashboardController extends Controller
{
    public function __construct(
        private AttendanceRepositoryInterface $attendanceRepo
    ) {}

    public function index()
    {
        $stats   = $this->attendanceRepo->todayStats();
        $today   = $this->attendanceRepo->todayList();

        return view('dashboard.index', compact('stats', 'today'));
    }
}
