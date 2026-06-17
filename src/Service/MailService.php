<?php

use PHPMailer\PHPMailer\PHPMailer;

class MailService
{
    public function send($to, $filePath)
    {
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = $_ENV['SMTP_HOST'];
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['SMTP_USER'];
        $mail->Password = $_ENV['SMTP_PASS'];
        $mail->SMTPSecure = 'tls';
        $mail->Port = $_ENV['SMTP_PORT'];

        $mail->setFrom($_ENV['SMTP_FROM'], $_ENV['SMTP_NAME']);
        $mail->addAddress($to);

        $mail->Subject = "Reçu de transaction BMOI";
        $mail->Body = "Veuillez trouver votre reçu en pièce jointe.";

        $mail->addAttachment($filePath);

        $mail->send();
    }
}