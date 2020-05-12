<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    // 服务器设定
    $mail->isSMTP(); // 使用 SMTP 发送
    $mail->Host       = 'smtp.sina.com'; // 将 SMTP 服务器设置为发送通过
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // 启用TLS加密； 鼓励使用PHPMailer::ENCRYPTION_SMTPS
    $mail->Port       = 465;  // 要连接的TCP端口，对上面的`PHPMailer::ENCRYPTION_SMTPS`使用465
    $mail->SMTPAuth   = true; // 启用 SMTP 身份验证

    $mail->Username   = 'cokery@sina.com'; // SMTP 用户名
    $mail->Password   = '3b0ca664489be30d';  // SMTP 密码

    $mail->SMTPDebug  = SMTP::DEBUG_SERVER; // 启用详细调试输出


    //收件者
    $mail->setFrom('cokery@sina.com', 'Mailer');
    $mail->addAddress('775151354@qq.com', 'addAddress');     // 添加收件人 // 名称是可选的
    $mail->addAddress('775151354@qq.com');     // 添加收件人 // 名称是可选的
    $mail->addReplyTo('hou.msn@hotmail.com', 'addReplyTo'); // 添加一个“答复”地址。
    $mail->addCC('hou.msn@hotmail.com');
    $mail->addBCC('hou.msn@hotmail.com');

    // 内容
    $mail->isHTML(true);                                  // 将电子邮件格式设置为HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
