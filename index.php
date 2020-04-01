<?php
require 'vendor/autoload.php';

use cokery\lib\File;
use cokery\lib\Directory;

$file = 'C:\www\php-library\src\lib\File.php';
$dir = 'C:\www\php-library\src\lib\b\lib\a';
$dir2 = 'C:\www\php-library\src\lib\lib\a';

$res = Directory::create($dir);
// $res = Directory::move($dir,$dir2);
