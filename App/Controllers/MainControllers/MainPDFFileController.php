<?php

namespace App\Controllers\MainControllers;

use App\Models\DrawFeesReportFinal;
use App\Models\DrawReportFinal;
use App\Models\PDFFileDump;

class MainPDFFileController
{
    protected $DrawFeesReportFinal;
    protected $DrawReportFinal;
    protected $PDFFileDump;
    
    public function __construct(
        DrawFeesReportFinal $DrawFeesReportFinal,
        DrawReportFinal $DrawReportFinal,
        PDFFileDump $PDFFileDump
    )
    {
        $this->DrawFeesReportFinal = $DrawFeesReportFinal;
        $this->DrawReportFinal     = $DrawReportFinal;
        $this->PDFFileDump         = $PDFFileDump;
    }

    public function dumpPdf()
    {
        $this->PDFFileDump->reportDump($this->DrawReportFinal->draw()."\n\n".$this->DrawFeesReportFinal->draw());
        $this->PDFFileDump->Output(
            "Reports_PDF/".'Work_Report-'.
            $this->DrawReportFinal->userFirstName.'-'.
            $this->DrawReportFinal->userLastName.'-'.
            $this->DrawReportFinal->year.'.'.
            $this->DrawReportFinal->monthNumber.
            ".pdf"
        );
        
        return 'Your report is located in Reports_PDF/Work_Report-'.
                $this->DrawReportFinal->userFirstName.'-'.
                $this->DrawReportFinal->userLastName.'-'.
                $this->DrawReportFinal->year.'.'.
                $this->DrawReportFinal->monthNumber.'.pdf'.
                "\n";
    }
}
