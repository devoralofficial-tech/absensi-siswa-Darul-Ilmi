<?php

namespace App\Services;

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use ZipArchive;

class QrCodeService
{
    public function getZip(iterable $students): string
    {
        $zipPath = sys_get_temp_dir() . '/qr_siswa_' . time() . '.zip';
        $zip     = new ZipArchive();
        $zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        $options = new QROptions([
            'outputInterface'  => \chillerlan\QRCode\Output\QRMarkupSVG::class,
            'outputBase64'     => false,
            'scale'            => 10,
        ]);
        $qr = new QRCode($options);

        foreach ($students as $student) {
            $content = $qr->render($student->qr_token);
            $zip->addFromString($student->nama . '_' . $student->qr_token . '.svg', $content);
        }

        $zip->close();

        return $zipPath;
    }
}
