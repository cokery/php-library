<?php
require 'vendor/autoload.php';

use cokery\lib\File;
use cokery\lib\Directory;

// $file = 'C:\www\htdoc\php-library\src\lib\File.php';
// $dir = 'C:\www\htdoc\php-library\src\lib';

// $file = 'C:\www\php-library\demo\demo.txt';
// $newfile = 'C:\www\php-library\demo\test.txt';
// $res = File::info($file);
// echo 'info:'.print_r($res).PHP_EOL;
// $res = File::create($file);
// echo 'create:'.print_r($res).PHP_EOL;
// $res = File::duplicate($file,$newfile);
// echo 'duplicate:'.print_r($res).PHP_EOL;

// $newfile = 'C:\www\php-library\demo\test2.txt';
// $newfile2 = 'C:\www\php-library\demo\child\test.txt';

// $res = File::move($newfile,$newfile2);
// echo 'move:'.print_r($res).PHP_EOL;

// $dir = 'C:\www\php-library\demo\child/2';
// $res = Directory::create($dir);
// echo 'create:'.print_r($res).PHP_EOL;

// $res = File::duplicate($newfile,$newfile2,false,true);
// echo 'duplicate:'.print_r($res).PHP_EOL;

$newfile = 'C:\www\php-library\demo\demo.txt';
// $res = File::read($newfile,'array');
// print_r($res).PHP_EOL;

$res = File::write($newfile,PHP_EOL.'arrayaaaaaaaaaaaaaaaaaaaaa');
print_r($res).PHP_EOL;