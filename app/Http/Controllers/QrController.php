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
        
        $options = new \chillerlan\QRCode\QROptions([
            'outputInterface'  => \chillerlan\QRCode\Output\QRMarkupSVG::class,
            'outputBase64'     => false, // Return raw SVG string for download
            'scale'            => 10,
        ]);
        $content = (new \chillerlan\QRCode\QRCode($options))->render($student->qr_token);

        // Remove base64 PNG decoding since we're generating raw SVG

        return response($content)
            ->header('Content-Type', 'image/svg+xml')
            ->header('Content-Disposition', 'attachment; filename="' . $student->nama . '_QR.svg"');
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
