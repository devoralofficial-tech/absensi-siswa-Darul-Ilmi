<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\StudentRepositoryInterface;
use App\Services\QrCodeService;
use Illuminate\Http\Request;

class QrController extends Controller
{
    public function __construct(
        private StudentRepositoryInterface $studentRepo,
        private QrCodeService $qrService,
    ) {}

    public function index()
    {
        $students = $this->studentRepo->all();
        return view('qr.index', compact('students'));
    }

    public function download(int $id)
    {
        $student = \App\Models\Student::findOrFail($id);
        
        $url = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode($student->qr_token);
        $content = file_get_contents($url);

        return response($content)
            ->header('Content-Type', 'image/png')
            ->header('Content-Disposition', 'attachment; filename="' . $student->nama . '_QR.png"');
    }

    public function downloadAll()
    {
        $students = $this->studentRepo->all();
        $zipPath  = $this->qrService->getZip($students);

        return response()->download($zipPath, 'QR_Siswa_Semua.zip')->deleteFileAfterSend(true);
    }

    public function printView()
    {
        $students = $this->studentRepo->all();
        return view('qr.print', compact('students'));
    }
}
