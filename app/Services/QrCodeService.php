<?php

namespace App\Services;

use ZipArchive;

class QrCodeService
{
    public function getZip(iterable $students): string
    {
        $zipPath = sys_get_temp_dir() . '/qr_siswa_' . time() . '.zip';
        $zip     = new ZipArchive();
        $zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        $responses = \Illuminate\Support\Facades\Http::pool(function ($pool) use ($students) {
            foreach ($students as $student) {
                $pool->as($student->id)->get('https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode($student->qr_token));
            }
        });

        foreach ($students as $student) {
            $response = $responses[$student->id] ?? null;
            if ($response && $response->ok()) {
                $zip->addFromString($student->nama . '_' . $student->qr_token . '.png', $response->body());
            }
        }

        $zip->close();

        return $zipPath;
    }
}
