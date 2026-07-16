<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\Student;

class WhatsAppLinkService
{
    public function normalizePhone(string $phone): string
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);

        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }

        return $phone;
    }

    public function buildMessage(Student $student, Attendance $attendance): string
    {
        $schoolName  = config('attendance.school_name', 'Sekolah');
        $tanggal     = $attendance->attendance_date->locale('id')->isoFormat('dddd, D MMMM Y');
        $jam         = \Carbon\Carbon::parse($attendance->attendance_time)->format('H:i');
        $isBerangkat = $attendance->status === 'Berangkat';
        $statusLabel = $isBerangkat ? 'BERANGKAT ke sekolah' : 'PULANG dari sekolah';

        $lateLine = '';
        if ($isBerangkat && $attendance->is_late) {
            $lateLine = "*Keterangan :* Terlambat {$attendance->late_minutes} menit\n";
        } elseif ($isBerangkat) {
            $lateLine = "*Keterangan :* Tepat waktu\n";
        }

        return implode("\n", [
            "Assalamu'alaikum Wr. Wb.",
            "",
            "Yth. Bapak/Ibu Wali Murid,",
            "Dengan izin Allah Ta'ala, kami menginformasikan bahwa kehadiran putra/putri Anda:",
            "",
            "━━━━━━━━━━━━━━━━━━",
            "*ABSENSI {$attendance->status}*",
            "━━━━━━━━━━━━━━━━━━",
            "",
            "*Nama Siswa :* {$student->nama}",
            "*Tanggal    :* {$tanggal}",
            "*Jam        :* {$jam} WIB",
            $lateLine,
            "Siswa telah *{$statusLabel}*.",
            "",
            "Semoga Allah Ta'ala senantiasa menjaga Ananda, memudahkan langkahnya dalam menuntut ilmu, serta menjadikannya anak yang saleh/salehah dan berakhlak mulia.",
            "",
            "Wassalamu'alaikum Wr. Wb.",
            "_{$schoolName}_",
        ]);
    }

    public function generateLink(Student $student, Attendance $attendance): string
    {
        $phone = $this->normalizePhone($student->nomor_wa);
        $message = $this->buildMessage($student, $attendance);

        return 'https://wa.me/' . $phone . '?text=' . rawurlencode($message);
    }
}
