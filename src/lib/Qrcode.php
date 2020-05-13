<?php
// Load Composer's autoloader
require 'vendor/autoload.php';

use CodeItNow\BarcodeBundle\Utils\QrCode;

$qrCode = new QrCode();

$qrCode
    ->setText('QR code by codeitnow.in')
    ->setSize(300)
    ->setPadding(10)
    ->setErrorCorrection('high')
    ->setForegroundColor(array('r' => 0, 'g' => 0, 'b' => 0, 'a' => 0))
    ->setBackgroundColor(array('r' => 255, 'g' => 255, 'b' => 255, 'a' => 0))
    ->setLabel('Scan Qr Code')
    ->setLabelFontSize(16)
    ->setImageType(QrCode::IMAGE_TYPE_PNG)
;

echo '<img src="data:'.$qrCode->getContentType().';base64,'.$qrCode->generate().'" />';