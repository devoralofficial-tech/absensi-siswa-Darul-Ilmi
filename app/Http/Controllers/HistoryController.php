<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\AttendanceRepositoryInterface;

class HistoryController extends Controller
{
    public function __construct(
        private AttendanceRepositoryInterface $attendanceRepo
    ) {}

    public function index()
    {
        $filters     = request()->only(['tanggal', 'status', 'nama']);
        $attendances = $this->attendanceRepo->filter($filters);

        return view('history.index', compact('attendances', 'filters'));
    }
}
