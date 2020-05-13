<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

class Mail extends PHPMailer
{
    public function __construct()
    {
        parent::__construct(true);
        $this->smtp();
    }

    public function config(array $options = [])
    {
        
    }

    public function smtp()
    {
        $this->isSMTP(); // 使用 SMTP 发送
        $this->CharSet    = 'utf8'; // 编码
        $this->SMTPDebug  = SMTP::DEBUG_SERVER; // 启用详细调试输出
        $this->Host       = 'smtp.sina.com'; // 将 SMTP 服务器设置为发送通过
        $this->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // 启用TLS加密； 鼓励使用PHPMailer::ENCRYPTION_SMTPS
        $this->Port       = 465;  // 要连接的TCP端口，对上面的`PHPMailer::ENCRYPTION_SMTPS`使用465
        $this->SMTPAuth   = true; // 启用 SMTP 身份验证
        $this->Username   = 'cokery@sina.com'; // SMTP 用户名
        $this->Password   = '3b0ca664489be30d';  // SMTP 密码
    }

    /**
     * 添加发件人
     * @return void
     */
    public function sendFrom(string $from, string $name = null)
    {
        if ($name == null) {
            $this->setFrom($from);
        } else {
            $this->setFrom($from, $name);
        }
        return $this;
    }

    /**
     * 添加收件人
     *
     * @param string $to
     * @param string $name
     * @return void
     */
    public function sendTo($to, $name = null)
    {
        if ($name == null) {
            $this->addAddress($to);
        } else {
            $this->addAddress($to, $name);
        }

        return $this;
    }

    /**
     * 邮件回函地址
     *
     * @param [type] $reply
     * @param [type] $name
     * @return void
     */
    public function replyTo($reply, $name = null)
    {
        if ($name == null) {
            $this->addReplyTo($reply);
        } else {
            $this->addReplyTo($reply, $name);
        }

        return $this;
    }

    /**
     * 邮件抄送地址
     *
     * @param [type] $cc
     * @param [type] $name
     * @return void
     */
    public function cc($cc, $name = null)
    {
        if ($name == null) {
            $this->addCC($cc);
        } else {
            $this->addCC($cc, $name);
        }

        return $this;
    }

    /**
     * 邮件密送地址
     *
     * @param [type] $bcc
     * @param [type] $name
     * @return void
     */
    public function bcc($bcc, $name = null)
    {
        if ($name == null) {
            $this->addBCC($bcc);
        } else {
            $this->addBCC($bcc, $name);
        }
        return $this;
    }

    /**
     * 邮件主题
     *
     * @param string $subject
     * @return void
     */
    public function setSubject($subject)
    {
        $this->Subject = $subject;
        return $this;
    }

    /**
     * 邮件正文
     *
     * @param string $body
     * @return void
     */
    public function setBody($body)
    {
        $this->Body = $body;
        return $this;
    }

    /**
     * 邮件纯文本
     *
     * @param string $altBody
     * @return void
     */
    public function setAltBody($altBody)
    {
        $this->AltBody = $altBody;
        return $this;
    }

    /**
     * 邮件附件
     *
     * @param string $file
     * @param string $newName
     * @return void
     */
    public function attachment($file, $newName = null)
    {

        if ($newName == null) {
            $this->addAttachment($file);
        } else {
            $this->addAttachment($file, $newName);
        }

        return $this;
    }

    /**
     * 发送邮件
     *
     * @return void
     */
    public function send()
    {
        parent::send();
        return $this;
    }
}

$mail = new mail();
$mail->config([

]);
$mail->sendFrom('cokery@sina.com', 'Mailer Servie')
    ->sendTo('775151354@qq.com', 'Customer Client')
    ->sendTo('hou.msn@hotmail.com', 'Customer Client')
    ->setSubject('邮件标题')
    ->setBody('邮件正文')
    ->setAltBody('邮件纯文本')
    ->send();
