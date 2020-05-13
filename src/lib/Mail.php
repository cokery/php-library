<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

// Load Composer's autoloader
require 'vendor/autoload.php';

class Mail extends PHPMailer
{
    public function __construct()
    {
        parent::__construct(true);
        $this->smtp();
    }

    /**
     * 配置SMTP服务器
     *
     * @param array $options
     * @param string $secure
     * @param bool $debug
     * @return void
     */
    public function smtp(array $options = [], string $secure = 'ssl', bool $debug = false)
    {
        $this->isSMTP(); // 使用 SMTP 发送
        $this->CharSet    = 'utf8'; // 编码

        // 启用详细调试输出
        if ($debug) {
            $this->SMTPDebug  = SMTP::DEBUG_SERVER;
        }

        $this->SMTPAuth   = true; // 启用 SMTP 身份验证

        // TLS加密
        if ($secure == 'tls') {
            $this->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

            if ($options['port'] == null) {
                $options['port'] = 587;
            }
        }

        // SSL加密
        if ($secure == 'ssl' or $secure == null) {
            $this->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $options['port'] = 465;
        }

        $this->Host     = $options['host'];      // 将    SMTP 服务器设置为发送通过
        $this->Port     = $options['port'];      // 要连接的TCP端口，对上面的`PHPMailer::ENCRYPTION_SMTPS`使用465
        $this->Username = $options['username'];  // SMTP 用户名
        $this->Password = $options['password'];  // SMTP 密码
    }

    /**
     * 添加发件人
     * 
     * @return void
     */
    public function sendFrom($from,  $name = null)
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
    public function sendTo(string $to, string $name = null)
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
     * @param string $reply
     * @param string $name
     * @return void
     */
    public function replyTo(string $reply, string $name = null)
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
     * @param string $cc
     * @param string $name
     * @return void
     */
    public function cc(string $cc, string $name = null)
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
     * @param string $bcc
     * @param string $name
     * @return void
     */
    public function bcc(string $bcc, string $name = null)
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
    public function setSubject(string $subject)
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
    public function setBody(string $body)
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
    public function setAltBody(string $altBody)
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
    public function attachment(string $file, string $newName = null)
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

$mail->smtp([
    'host'     => "smtp.sina.com",
    'port'     => 465,
    'username' => 'cokery@sina.com',
    'password' => '3b0ca664489be30d',
]);

$mail->sendFrom('cokery@sina.com', 'Mailer Servie')
    ->sendTo('775151354@qq.com', 'Customer Client')
    ->sendTo('hou.msn@hotmail.com', 'Customer Client')
    ->setSubject('邮件标题')
    ->setBody('邮件正文')
    ->setAltBody('邮件纯文本')
    ->send();
