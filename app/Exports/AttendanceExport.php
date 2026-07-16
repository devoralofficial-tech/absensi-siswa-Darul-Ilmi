<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AttendanceExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    private int $no = 0;

    public function __construct(private array $filters = []) {}

    public function query()
    {
        $query = Attendance::with('student')->orderBy('attendance_date')->orderBy('attendance_time');

        if (! empty($this->filters['bulan']) && ! empty($this->filters['tahun'])) {
            $query->whereMonth('attendance_date', $this->filters['bulan'])
                  ->whereYear('attendance_date', $this->filters['tahun']);
        } elseif (! empty($this->filters['tahun'])) {
            $query->whereYear('attendance_date', $this->filters['tahun']);
        }

        if (! empty($this->filters['status']) && in_array($this->filters['status'], ['Berangkat', 'Pulang'])) {
            $query->where('status', $this->filters['status']);
        }

        return $query;
    }

    public function headings(): array
    {
        return ['No', 'Nama', 'Tanggal', 'Status', 'Jam'];
    }

    public function map($attendance): array
    {
        return [
            ++$this->no,
            $attendance->student->nama ?? '-',
            $attendance->attendance_date->format('d/m/Y'),
            $attendance->status,
            \Carbon\Carbon::parse($attendance->attendance_time)->format('H:i'),
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
