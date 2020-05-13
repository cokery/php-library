<?php
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$a = new SMTP();
print_r(get_class_methods($a));
// print_r(get_class_vars (get_class($a)));

