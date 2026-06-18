<?php

namespace App\Service;

use Dompdf\Dompdf;
use Dompdf\Options;

class PdfService
{
    /**
     * Génère un PDF à partir d'un HTML
     */
    public function generate(string $html, string $filename = "document.pdf", bool $download = true)
    {
        // 🔥 Options Dompdf (IMPORTANT pour PHP 8.4)
        $options = new Options();

        $options->set('isRemoteEnabled', true);

        // ⚠️ FIX CRITIQUE : désactive HTML5 parser (cause crash PHP 8.4)
        $options->set('isHtml5ParserEnabled', false);

        // Sécurité / performance
        $options->set('isPhpEnabled', false);
        $options->set('defaultFont', 'Arial');

        // Initialisation Dompdf
        $dompdf = new Dompdf($options);

        // Charger HTML
        $dompdf->loadHtml($html, 'UTF-8');

        // Format papier
        $dompdf->setPaper('A4', 'portrait');

        // Render PDF
        $dompdf->render();

        // Sortie
        if ($download) {
            // Téléchargement navigateur
            $dompdf->stream($filename, [
                "Attachment" => true
            ]);
            exit;
        }

        // Retour brut PDF (string)
        return $dompdf->output();
    }
}