<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAttendanceRequest;
use App\Repositories\Contracts\StudentRepositoryInterface;
use App\Services\AttendanceService;
use App\Services\WhatsAppLinkService;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class AttendanceController extends Controller
{
    public function __construct(
        private StudentRepositoryInterface $studentRepo,
        private AttendanceService $attendanceService,
        private WhatsAppLinkService $waService,
    ) {}

    public function scan()
    {
        return view('scan.index');
    }

    public function lookup(string $token)
    {
        $student = $this->studentRepo->findByToken($token);

        if (! $student) {
            return response()->json(['error' => 'QR tidak terdaftar.'], 404);
        }

        $now      = Carbon::now();
        $setting  = \App\Models\Setting::first();
        $arrTime  = $setting?->arrival_time ?? '08:00:00';
        $limit    = Carbon::today()->setTimeFromTimeString($arrTime);
        $isLate   = $now->gt($limit);
        $lateMins = $isLate ? (int) $limit->diffInMinutes($now) : 0;

        // Check today's attendance status
        $todayBer = $student->todayAttendances()->where('status', 'Berangkat')->exists();
        $todayPul = $student->todayAttendances()->where('status', 'Pulang')->exists();

        return response()->json([
            'student'       => [
                'id'       => $student->id,
                'nama'     => $student->nama,
                'nomor_wa' => $student->nomor_wa,
            ],
            'server_time'   => $now->toIso8601String(),
            'is_late'       => $isLate,
            'late_minutes'  => $lateMins,
            'already_ber'   => $todayBer,
            'already_pul'   => $todayPul,
        ]);
    }

    public function confirm(string $token)
    {
        $student = $this->studentRepo->findByToken($token);

        if (! $student) {
            return redirect()->route('scan')->with('error', 'QR tidak terdaftar.');
        }

        $now     = Carbon::now();
        $setting = \App\Models\Setting::first();
        $arrTime = $setting?->arrival_time ?? '08:00:00';
        $limit   = Carbon::today()->setTimeFromTimeString($arrTime);
        $isLate  = $now->gt($limit);

        $todayBer = $student->todayAttendances()->where('status', 'Berangkat')->exists();
        $todayPul = $student->todayAttendances()->where('status', 'Pulang')->exists();

        return view('attendance.confirm', compact('student', 'now', 'isLate', 'todayBer', 'todayPul'));
    }

    public function store(StoreAttendanceRequest $request)
    {
        $student = $this->studentRepo->findByToken($request->validated('token'));

        if (! $student) {
            return response()->json(['error' => 'QR tidak terdaftar.'], 404);
        }

        try {
            $attendance = $this->attendanceService->record($student, $request->validated('status'));
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()['status'][0] ?? 'Validasi gagal.'], 422);
        }

        $waLink = $this->waService->generateLink($student, $attendance);

        return response()->json([
            'success'  => true,
            'message'  => 'Absensi berhasil disimpan.',
            'wa_link'  => $waLink,
            'is_late'  => $attendance->is_late,
            'late_min' => $attendance->late_minutes,
        ]);
    }
}
