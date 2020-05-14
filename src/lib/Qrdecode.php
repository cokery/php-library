<?php
// Load Composer's autoloader
require 'vendor/autoload.php';
use Zxing\QrReader;

$qrcode = new QrReader('C:\www\htdoc\php-library\a.png');
echo $text = $qrcode->text(); //return decoded text from QR Code