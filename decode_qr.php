<?php
require 'vendor/autoload.php';

$qrcode = new \chillerlan\QRCode\QRCode();
try {
    $result = $qrcode->readFromFile('public/test_qr.png');
    echo "Decoded: " . $result->data;
} catch (\Exception $e) {
    echo "Error decoding: " . $e->getMessage();
}
