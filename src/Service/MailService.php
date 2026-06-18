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
            // DEBUG
            // =====================
            $mail->SMTPDebug = 0;
            $mail->Debugoutput = 'error_log';

            // =====================
            // SMTP CONFIG
            // =====================
            $host = $_ENV['SMTP_HOST'] ?? '';
            $user = $_ENV['SMTP_USER'] ?? '';
            $pass = $_ENV['SMTP_PASS'] ?? '';
            $port = (int) ($_ENV['SMTP_PORT'] ?? 587);

            if (empty($host) || empty($user) || empty($pass)) {
                throw new \Exception(
                    "SMTP configuration missing : HOST={$host}, USER={$user}"
                );
            }

            $mail->isSMTP();
            $mail->Host = $host;
            $mail->SMTPAuth = true;
            $mail->Username = $user;
            $mail->Password = $pass;
            $mail->Port = $port;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->CharSet = 'UTF-8';

            // =====================
            // EXPEDITEUR
            // =====================
            $fromEmail = $_ENV['SMTP_FROM'] ?? $user;
            $fromName  = $_ENV['SMTP_NAME'] ?? 'BMOI System';

            if (empty($fromEmail)) {
                throw new \Exception("SMTP_FROM missing in .env");
            }

            $mail->setFrom($fromEmail, $fromName);

            // =====================
            // DESTINATAIRE
            // =====================
            if (empty($to)) {
                throw new \Exception("Recipient email is empty");
            }

            $mail->addAddress($to);

            // =====================
            // CONTENU
            // =====================
            $mail->isHTML(false);
            $mail->Subject = 'Reçu de transaction BMOI';
            $mail->Body = 'Veuillez trouver votre reçu en pièce jointe.';

            // =====================
            // PIECE JOINTE
            // =====================
            if (!empty($filePath) && file_exists($filePath)) {
                $mail->addAttachment($filePath);
            }

            // =====================
            // ENVOI
            // =====================
            $mail->send();

        } catch (Exception $e) {
            throw new \Exception(
                'Erreur envoi email : ' . $e->getMessage()
            );
        }
    }
}