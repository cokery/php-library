<?php
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class MailSMPT extends PHPMailer 
{
    public function __construct()
    {
        parent::__construct(true);
        $this->smtp();
    }

    public function smtp()
    {
        $this->CharSet = 'utf8'; // 编码
        $this->SMTPDebug  = SMTP::DEBUG_SERVER; // 启用详细调试输出
        $this->isSMTP(); // 使用 SMTP 发送
        $this->Host       = 'smtp.sina.com'; // 将 SMTP 服务器设置为发送通过
        $this->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // 启用TLS加密； 鼓励使用PHPMailer::ENCRYPTION_SMTPS
        $this->Port       = 465;  // 要连接的TCP端口，对上面的`PHPMailer::ENCRYPTION_SMTPS`使用465
        $this->SMTPAuth   = true; // 启用 SMTP 身份验证
        $this->Username   = 'cokery@sina.com'; // SMTP 用户名
        $this->Password   = '3b0ca664489be30d';  // SMTP 密码
    }
}