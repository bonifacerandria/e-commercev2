<?php

namespace App\Service;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailService
{
    public function send(string $to, ?string $filePath = null): void
    {
        $mail = new PHPMailer(true);

        try {

            // =====================
            // DEBUG (désactivé en prod)
            // =====================
            $mail->SMTPDebug = 0;
            $mail->Debugoutput = 'error_log';

            // =====================
            // SMTP CONFIG
            // =====================
            $mail->isSMTP();
            $mail->Host = getenv('SMTP_HOST');
            $mail->SMTPAuth = true;
            $mail->Username = getenv('SMTP_USER');
            $mail->Password = getenv('SMTP_PASS');
            $mail->Port = (int) getenv('SMTP_PORT');

            // Sécurité SMTP (recommandé pour SMTP2GO)
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

            // Charset
            $mail->CharSet = 'UTF-8';

            // =====================
            // EXPÉDITEUR
            // =====================
            $mail->setFrom(
                getenv('SMTP_FROM') ?: getenv('SMTP_USER'),
                getenv('SMTP_NAME') ?: 'BMOI E-Commerce'
            );

            // =====================
            // DESTINATAIRE
            // =====================
            $mail->addAddress($to);

            // =====================
            // CONTENU
            // =====================
            $mail->isHTML(false);
            $mail->Subject = "Reçu de transaction BMOI";
            $mail->Body = "Veuillez trouver votre reçu en pièce jointe.";

            // =====================
            // PIÈCE JOINTE (optionnelle)
            // =====================
            if (!empty($filePath) && file_exists($filePath)) {
                $mail->addAttachment($filePath);
            }

            // =====================
            // ENVOI
            // =====================
            if (!$mail->send()) {
                throw new Exception("Erreur SMTP: " . $mail->ErrorInfo);
            }

        } catch (Exception $e) {
            throw new \Exception("Erreur envoi email: " . $e->getMessage());
        }
    }
}