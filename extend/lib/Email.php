<?php

namespace lib;
use lib\PHPMailer;
/**
 * 使用PHPMailer发送邮件
 */
class Email {
    /*
     * $title = 邮件的标题
     * $content = 邮件的内容
     * $getter = 接收者的邮箱地址
     */
    public static function send($title, $content, $getter) {
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->Host = \config('email.email_host');
        $mail->From = \config('email.sender');
        $mail->FromName = \config('email.nickname');
        $mail->Username = \config('email.account');
        $mail->Password = \config('email.token');
        $mail->IsHTML(true);
        $mail->CharSet = 'utf-8';
        $mail->Subject = $title;
        $mail->MsgHTML($content);
        $mail->AddAddress($getter);
        $result = $mail->Send();

        if ($result) {
            return true;
        } else {
            return $mail->ErrorInfo;
        }
    }
}