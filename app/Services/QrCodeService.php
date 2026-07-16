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
            'outputInterface'  => \chillerlan\QRCode\Output\QRGdImagePNG::class,
            'scale'            => 10,
            'imageTransparent' => false,
        ]);
        $qr = new QRCode($options);

        foreach ($students as $student) {
            $content = $qr->render($student->qr_token);
            if (str_starts_with($content, 'data:image/png;base64,')) {
                $content = base64_decode(substr($content, 22));
            }
            $zip->addFromString($student->nama . '_' . $student->qr_token . '.png', $content);
        }

        $zip->close();

        return $zipPath;
    }
}
