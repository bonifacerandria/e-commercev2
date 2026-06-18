<?php

namespace App\Controller;

use App\Service\PdfService;
use App\Service\MailService;

class TransactionController
{
    public function show()
    {
        $data = $this->getTransactionData();
        require __DIR__ . '/../../views/transaction.php';
    }

    public function downloadPdf()
    {
        $data = $this->getTransactionData();

        $pdfService = new PdfService();
        $pdfService->generate($this->formatHtml($data), "facture.pdf", true);
    }

    public function sendEmail()
    {
        $email = $_POST['email'] ?? '';

        $data = $this->getTransactionData();

        $pdfService = new PdfService();
        $file = $pdfService->generate($this->formatHtml($data), "facture.pdf", false);

        $mailService = new MailService();
        $mailService->send($email, $file);

        echo "Email envoyé avec succès";
    }

    private function getTransactionData()
    {
        return [
            "orderID" => $_POST['orderID'] ?? '',
            "merchant" => $_POST['outletAcronym'] ?? '',
            "amount" => $_POST['purchaseAmountFormatted'] ?? '',
            "currency" => $_POST['purchaseCurrencyAlphaCode'] ?? '',
            "card" => $_POST['paddedCardNb'] ?? '',
            "date" => date('Y-m-d H:i:s')
        ];
    }

    private function formatHtml($data)
    {
        return "
            <h1>FACTURE</h1>
            <pre>" . print_r($data, true) . "</pre>
        ";
    }
}