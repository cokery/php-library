<?php
require 'vendor/autoload.php';

use cokery\lib\File;
use cokery\lib\Directory;

// $file = 'C:\www\htdoc\php-library\src\lib\File.php';
$dir = 'C:\www\htdoc\php-library\src\lib';
// $res = File::info($file);
$res = Directory::info($dir);
print_r($res);
print_r($res->getBaseName());
