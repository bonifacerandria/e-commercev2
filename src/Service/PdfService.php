<?php

use Dompdf\Dompdf;

class PdfService
{
    public function generate($data, $returnPath = false)
    {
        $dompdf = new Dompdf();

        ob_start();
        include __DIR__ . '/../../views/transaction.php';
        $html = ob_get_clean();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $fileName = 'transaction_' . time() . '.pdf';
        $filePath = __DIR__ . '/../../storage/pdf/' . $fileName;

        file_put_contents($filePath, $dompdf->output());

        if ($returnPath) {
            return $filePath;
        }

        $dompdf->stream($fileName);
    }
}