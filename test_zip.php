<?php
require 'vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$svc = new \App\Services\QrCodeService();
$students = \App\Models\Student::take(1)->get();
$zipPath = $svc->getZip($students);
var_dump(file_exists($zipPath), filesize($zipPath));
$zip = new ZipArchive;
if ($zip->open($zipPath) === TRUE) {
    for($i = 0; $i < $zip->numFiles; $i++) {
        $stat = $zip->statIndex($i);
        echo "File: " . $stat['name'] . " - Size: " . $stat['size'] . "\n";
        
        $content = $zip->getFromIndex($i);
        echo "Content Start: " . substr($content, 0, 30) . "\n";
    }
    $zip->close();
}
