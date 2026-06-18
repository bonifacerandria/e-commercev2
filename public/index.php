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

    echo "[OK] Chargement bootstrap...\n";

    require_once __DIR__ . '/../bootstrap.php';

    echo "[OK] bootstrap chargé\n";

    echo "[OK] Chargement controller...\n";

    require_once __DIR__ . '/../src/Controller/TransactionController.php';

    echo "[OK] Controller chargé\n";

    $controller = new TransactionController();

    echo "[OK] Controller instancié\n";

    echo "\n";
    echo "REQUEST_METHOD = " . ($_SERVER['REQUEST_METHOD'] ?? 'N/A') . "\n";

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

                    require_once __DIR__ . '/../src/Service/PdfService.php';

                    echo "[OK] PdfService chargé\n";

                    $data = $_POST;

                    echo "[OK] Données PDF :\n";
                    print_r($data);

                    $pdfService = new PdfService();

                    echo "[OK] Objet PdfService créé\n";

                    $pdfService->generate($data);

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

                    require_once __DIR__ . '/../src/Service/PdfService.php';
                    require_once __DIR__ . '/../src/Service/MailService.php';

                    echo "[OK] Services chargés\n";

                    $email = trim($_POST['email'] ?? '');

                    echo "Email destinataire : " . $email . "\n";

                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

                        throw new Exception(
                            "Adresse email invalide : " . $email
                        );
                    }

                    echo "[OK] Email valide\n";

                    $pdfService = new PdfService();

                    echo "[OK] Génération PDF...\n";

                    $pdfPath = $pdfService->generate(
                        $_POST,
                        true
                    );

                    echo "[OK] PDF généré :\n";
                    echo $pdfPath . "\n";

                    if (!file_exists($pdfPath)) {

                        throw new Exception(
                            "Le PDF n'existe pas : " . $pdfPath
                        );
                    }

                    echo "[OK] Fichier PDF trouvé\n";

                    echo "\nCONFIG SMTP\n";

                    echo "HOST : " . ($_ENV['SMTP_HOST'] ?? 'VIDE') . "\n";
                    echo "PORT : " . ($_ENV['SMTP_PORT'] ?? 'VIDE') . "\n";
                    echo "USER : " . ($_ENV['SMTP_USER'] ?? 'VIDE') . "\n";
                    echo "FROM : " . ($_ENV['SMTP_FROM'] ?? 'VIDE') . "\n";

                    $mailService = new MailService();

                    echo "[OK] MailService créé\n";

                    $mailService->send(
                        $email,
                        $pdfPath
                    );

                    echo "\n";
                    echo "====================================\n";
                    echo "EMAIL ENVOYE AVEC SUCCES\n";
                    echo "====================================\n";

                } catch (Throwable $e) {

                    echo "\n[ERREUR EMAIL]\n";
                    echo $e->getMessage() . "\n";

                    echo "\nFichier : ";
                    echo $e->getFile();

                    echo "\nLigne : ";
                    echo $e->getLine();

                    echo "\n\nTrace complète :\n";
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

    echo "\n";
    echo "====================================\n";
    echo "ERREUR FATALE\n";
    echo "====================================\n";

    echo $e->getMessage();
    echo "\n\n";

    echo "Fichier : ";
    echo $e->getFile();

    echo "\n";

    echo "Ligne : ";
    echo $e->getLine();

    echo "\n\n";

    echo $e->getTraceAsString();

    error_log($e);
}