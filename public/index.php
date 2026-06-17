<?php
require_once __DIR__ . '/../bootstrap.php';

require_once __DIR__ . '/../src/Controller/TransactionController.php';

$controller = new TransactionController();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'download_pdf') {
        $controller->downloadPdf();
        exit;
    }

    if ($_POST['action'] === 'send_email') {
        $controller->sendEmail();
        exit;
    }
}

$controller->show();