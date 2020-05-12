<?php
namespace cokery\lib;

// Load Composer's autoloader
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;

class SmtpMailer extends PHPMailer 
{
    public function __construct()
    {
        echo "a";
    }
}

$a = new SmtpMailer();

print_r($a);