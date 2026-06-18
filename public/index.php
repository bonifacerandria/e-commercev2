<?php

/**
 * DEBUG MODE
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<pre>";
echo "====================================\n";
echo "BMOI E-COMMERCE DEBUG MODE\n";
echo "====================================\n";

try {

    echo "[OK] Chargement autoload...\n";

    // IMPORTANT (fix principal)
    require_once __DIR__ . '/../vendor/autoload.php';

    echo "[OK] Autoload chargé\n";

    echo "[OK] Chargement bootstrap...\n";
    require_once __DIR__ . '/../bootstrap.php';
    echo "[OK] bootstrap chargé\n";

    echo "[OK] Chargement controller...\n";
    require_once __DIR__ . '/../src/Controller/TransactionController.php';
    echo "[OK] Controller chargé\n";

    $controller = new TransactionController();
    echo "[OK] Controller instancié\n";

    echo "\nREQUEST_METHOD = " . ($_SERVER['REQUEST_METHOD'] ?? 'N/A') . "\n";

    echo "\nPOST RECU :\n";
    print_r($_POST);

    echo "\nGET RECU :\n";
    print_r($_GET);

    echo "\nFILES RECUS :\n";
    print_r($_FILES);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        echo "\n====================================\n";
        echo "TRAITEMENT POST\n";
        echo "====================================\n";

        if (isset($_POST['action'])) {

            echo "Action reçue : " . $_POST['action'] . "\n";

            /**
             * PDF
             */
            if ($_POST['action'] === 'download_pdf') {

                echo "\n=== TEST GENERATION PDF ===\n";

                try {

                    echo "[OK] PdfService instanciation\n";

                    $pdfService = new PdfService();

                    echo "[OK] Objet PdfService créé\n";

                    //  IMPORTANT : PDF attend du HTML, pas un array
                    $html = "
                        <h1>TEST PDF</h1>
                        <pre>" . print_r($_POST, true) . "</pre>
                    ";

                    echo "[OK] HTML généré\n";

                    $pdfService->generate($html, "test.pdf", true);

                    echo "[OK] PDF généré\n";

                } catch (Throwable $e) {

                    echo "\n[ERREUR PDF]\n";
                    echo $e->getMessage() . "\n";
                    echo "\nFichier : " . $e->getFile();
                    echo "\nLigne : " . $e->getLine();
                    echo "\n\nTrace :\n";
                    echo $e->getTraceAsString();

                    error_log($e);
                    exit;
                }
            }

            /**
             * EMAIL
             */
            if ($_POST['action'] === 'send_email') {

                echo "\n=== TEST ENVOI EMAIL ===\n";

                try {

                    echo "[OK] Services chargés\n";

                    $email = trim($_POST['email'] ?? '');

                    echo "Email destinataire : " . $email . "\n";

                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        throw new Exception("Email invalide : " . $email);
                    }

                    echo "[OK] Email valide\n";

                    $pdfService = new PdfService();

                    echo "[OK] Génération PDF...\n";

                    $html = "
                        <h1>FACTURE</h1>
                        <pre>" . print_r($_POST, true) . "</pre>
                    ";

                    $pdfPath = $pdfService->generate($html, "facture.pdf", false);

                    echo "[OK] PDF généré en mémoire\n";

                    $mailService = new MailService();

                    echo "[OK] MailService créé\n";

                    $mailService->send($email, $pdfPath);

                    echo "\n====================================\n";
                    echo "EMAIL ENVOYE AVEC SUCCES\n";
                    echo "====================================\n";

                } catch (Throwable $e) {

                    echo "\n[ERREUR EMAIL]\n";
                    echo $e->getMessage() . "\n";

                    echo "\nFichier : " . $e->getFile();
                    echo "\nLigne : " . $e->getLine();

                    echo "\n\nTrace :\n";
                    echo $e->getTraceAsString();

                    error_log($e);
                    exit;
                }
            }
        } else {
            echo "[INFO] Aucun action reçu\n";
        }
    }

    echo "\n====================================\n";
    echo "AFFICHAGE PAGE\n";
    echo "====================================\n";

    $controller->show();

} catch (Throwable $e) {

    echo "\n====================================\n";
    echo "ERREUR FATALE\n";
    echo "====================================\n";

    echo $e->getMessage() . "\n\n";
    echo "Fichier : " . $e->getFile() . "\n";
    echo "Ligne : " . $e->getLine() . "\n\n";
    echo $e->getTraceAsString();

    error_log($e);
}