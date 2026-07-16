<?php

namespace App\Http\Controllers;

use App\Exports\AttendanceExport;
use App\Models\Attendance;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index()
    {
        $filters = request()->only(['bulan', 'tahun', 'status']);
        $months  = collect(range(1, 12))->mapWithKeys(fn ($m) => [
            $m => \Carbon\Carbon::create()->month($m)->locale('id')->isoFormat('MMMM'),
        ]);

        return view('report.index', compact('filters', 'months'));
    }

    public function export()
    {
        $filters  = request()->only(['bulan', 'tahun', 'status']);
        $filename = 'laporan_absensi_' . ($filters['bulan'] ?? 'semua') . '_' . ($filters['tahun'] ?? date('Y')) . '.xlsx';

        return Excel::download(new AttendanceExport($filters), $filename);
    }
}
