<?php
require 'vendor/autoload.php';

$options = new \chillerlan\QRCode\QROptions([
    'outputInterface'  => \chillerlan\QRCode\Output\QRGdImagePNG::class,
    'imageBase64'      => false,
    'scale'            => 10,
    'imageTransparent' => false,
]);
$qr = new \chillerlan\QRCode\QRCode($options);
$res = $qr->render('123');
file_put_contents('test.png', $res);
echo "Length: " . strlen($res) . "\n";
