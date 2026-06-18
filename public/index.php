<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ✅ IMPORTS TOUJOURS EN HAUT
use App\Controller\TransactionController;
use App\Service\PdfService;
use App\Service\MailService;

echo "<pre>";
echo "=== DEBUG E-COMMERCE ===\n";

try {

    require_once __DIR__ . '/../vendor/autoload.php';
    require_once __DIR__ . '/../bootstrap.php';

    require_once __DIR__ . '/../src/Controller/TransactionController.php';

    $controller = new TransactionController();

    echo "[OK] Controller OK\n";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $action = $_POST['action'] ?? null;

        echo "Action: $action\n";

        // =======================
        // PDF
        // =======================
        if ($action === 'download_pdf') {

            echo "[PDF] Generation...\n";

            $pdf = new PdfService();

            $html = "
                <h1>FACTURE TEST</h1>
                <pre>" . print_r($_POST, true) . "</pre>
            ";

            $pdf->generate($html, "facture.pdf", true);
        }

        // =======================
        // EMAIL
        // =======================
        if ($action === 'send_email') {

            echo "[EMAIL] Processing...\n";

            $email = $_POST['email'] ?? '';

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception("Email invalide");
            }

            $pdf = new PdfService();

            $html = "
                <h1>FACTURE EMAIL</h1>
                <pre>" . print_r($_POST, true) . "</pre>
            ";

            $pdfBinary = $pdf->generate($html, "facture.pdf", false);

            $mail = new MailService();
            $mail->send($email, $pdfBinary);

            echo "[OK] Email envoyé\n";
        }
    }

    echo "\n[PAGE LOAD]\n";
    $controller->show();

} catch (Throwable $e) {

    echo "\n[ERROR]\n";
    echo $e->getMessage();
    echo "\n" . $e->getFile() . ":" . $e->getLine();
}