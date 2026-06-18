<?php

namespace App\Service;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailService
{
    /**
     * Helper pour lire les variables d'environnement de façon safe
     */
    private function env(string $key, ?string $default = null): ?string
    {
        $value = getenv($key);

        return (!empty($value)) ? $value : $default;
    }

    public function send(string $to, ?string $filePath = null): void
    {
        $mail = new PHPMailer(true);

        try {

            // =====================
            // DEBUG (désactivé prod)
            // =====================
            $mail->SMTPDebug = 0;
            $mail->Debugoutput = 'error_log';

            // =====================
            // SMTP CONFIG
            // =====================
            $host = $this->env('SMTP_HOST');
            $user = $this->env('SMTP_USER');
            $pass = $this->env('SMTP_PASS');
            $port = (int) $this->env('SMTP_PORT', '587');

            if (empty($host) || empty($user) || empty($pass)) {
                throw new \Exception("SMTP configuration missing (.env)");
            }

            $mail->isSMTP();
            $mail->Host = $host;
            $mail->SMTPAuth = true;
            $mail->Username = $user;
            $mail->Password = $pass;
            $mail->Port = $port;

            // Sécurité SMTP (SMTP2GO / standard)
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

            // Charset
            $mail->CharSet = 'UTF-8';

            // =====================
            // EXPÉDITEUR (FIX ERREUR PRINCIPALE)
            // =====================
            $fromEmail = $this->env('SMTP_FROM', $user);
            $fromName  = $this->env('SMTP_NAME', 'System');

            if (empty($fromEmail)) {
                throw new \Exception("SMTP_FROM is missing or invalid");
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
                throw new Exception("SMTP Error: " . $mail->ErrorInfo);
            }

        } catch (Exception $e) {
            throw new \Exception("Erreur envoi email: " . $e->getMessage());
        }
    }
}