<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

use App\Controller\TransactionController;
use App\Service\PdfService;
use App\Service\MailService;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../bootstrap.php';
require_once __DIR__ . '/../src/Controller/TransactionController.php';

try {

    $controller = new TransactionController();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $action = $_POST['action'] ?? null;

        // =======================
        // PDF GENERATION
        // =======================
        if ($action === 'download_pdf') {

            $pdf = new PdfService();

            $html = "
                <h1>FACTURE</h1>
            ";

            $pdf->generate($html, "facture.pdf", true);
            exit;
        }

        // =======================
        // SEND EMAIL
        // =======================
        if ($action === 'send_email') {

            $email = $_POST['email'] ?? '';

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception("Email invalide");
            }

            $pdf = new PdfService();

            $html = "
                <h1>FACTURE</h1>
            ";

            $pdfBinary = $pdf->generate($html, "facture.pdf", false);

            $mail = new MailService();
            $mail->send($email, $pdfBinary);

            echo "Email envoyé avec succès";
            exit;
        }
    }

    $controller->show();

} catch (Throwable $e) {

    http_response_code(500);

    echo "Erreur système";

    // Optionnel (log serveur)
    error_log($e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine());
}