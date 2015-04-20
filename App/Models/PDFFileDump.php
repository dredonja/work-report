<?php
namespace App\Models;

use App\Lib\FPDF\fpdf;

class PDFFileDump extends FPDF
{
    public function __construct($orientation = 'P', $unit = 'mm', $size = 'A4')
    {
        $this->FPDF($orientation, $unit, $size);
        $this->B    = 0;
        $this->I    = 0;
        $this->U    = 0;
        $this->HREF = '';
    }

    public function reportDump($content)
    {
        $this->SetMargins(20, 20);
        $this->AddPage();
        $this->SetFont('Courier', 'B', 8);
        $this->MultiCell(0, 4, $content, '0', 'L');
        $this->Ln();
    }
}
