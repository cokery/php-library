<?php
require 'vendor/autoload.php';

use cokery\lib\File;

$path = 'D:\www\htdoc\php-library\src\lib\File.php';
$file = new File($path);
$res = $file->create();
var_dump($res);
die;

