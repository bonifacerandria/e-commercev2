<?php

namespace App\Service;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailService
{
    public function send(string $to, string $filePath): void
    {
        $mail = new PHPMailer(true);

        try {

            // =====================
            // SMTP CONFIG
            // =====================
            $mail->isSMTP();
            $mail->Host = $_ENV['SMTP_HOST'] ?? '';
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['SMTP_USER'] ?? '';
            $mail->Password = $_ENV['SMTP_PASS'] ?? '';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = $_ENV['SMTP_PORT'] ?? 587;

            // =====================
            // SENDER
            // =====================
            $mail->setFrom(
                $_ENV['SMTP_FROM'] ?? 'no-reply@example.com',
                $_ENV['SMTP_NAME'] ?? 'BMOI System'
            );

            $mail->addAddress($to);

            // =====================
            // CONTENT
            // =====================
            $mail->isHTML(false);
            $mail->Subject = "Reçu de transaction BMOI";
            $mail->Body = "Veuillez trouver votre reçu en pièce jointe.";

            // =====================
            // ATTACHMENT
            // =====================
            if (!empty($filePath) && file_exists($filePath)) {
                $mail->addAttachment($filePath);
            }

            $mail->send();

        } catch (Exception $e) {
            throw new \Exception("Erreur envoi email: " . $e->getMessage());
        }
    }
}