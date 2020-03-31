<?php
require 'vendor/autoload.php';

use cokery\lib\File;

$file = 'C:\www\htdoc\php-library\src\lib\File.php';
$res = File::info($file);
print_r($res);
print_r($res->getPath());