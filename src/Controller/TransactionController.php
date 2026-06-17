<?php

require_once __DIR__ . '/../Service/PdfService.php';
require_once __DIR__ . '/../Service/MailService.php';

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
        $pdfService->generate($data);
    }

    public function sendEmail()
    {
        $email = $_POST['email'] ?? '';

        $data = $this->getTransactionData();

        $pdfService = new PdfService();
        $filePath = $pdfService->generate($data, true);

        $mailService = new MailService();
        $mailService->send($email, $filePath);

        echo "Email envoyé avec succès";
    }

    private function getTransactionData()
    {
        // sécurisation basique
        return [
            "orderID" => $_POST['orderID'] ?? '',
            "merchant" => $_POST['outletAcronym'] ?? '',
            "amount" => $_POST['purchaseAmountFormatted'] ?? '',
            "currency" => $_POST['purchaseCurrencyAlphaCode'] ?? '',
            "card" => $_POST['paddedCardNb'] ?? '',
            "date" => date('Y-m-d H:i:s')
        ];
    }
}