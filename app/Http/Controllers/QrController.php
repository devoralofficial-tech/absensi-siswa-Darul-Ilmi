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
            'outputInterface'  => \chillerlan\QRCode\Output\QRGdImagePNG::class,
            'scale'            => 10,
            'imageTransparent' => false,
        ]);
        $content = (new \chillerlan\QRCode\QRCode($options))->render($student->qr_token);

        // In php-qrcode v6, render() returns a base64 data URI by default
        if (str_starts_with($content, 'data:image/png;base64,')) {
            $content = base64_decode(substr($content, 22));
        }

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
