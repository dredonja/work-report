<?php

namespace App\Models;

use App\Models\FeesDataHandler;

class DrawFeesReportFinal
{
    protected $feeSum;
    protected $feeID;
    protected $feeName;
    protected $feeAmount;

    public function __construct(FeesDataHandler $FeesDataHandler)
    {
        $this->feeSum    = $FeesDataHandler->calculateFeeSum();
        $this->feeID     = $FeesDataHandler->feeID();
        $this->feeName   = $FeesDataHandler->feeName();
        $this->feeAmount = $FeesDataHandler->feeAmount();
    }

    protected function writeDataFromFile($feeName, $feeAmount)
    {
        $feeDataPartSpacesLenghtTotal = 82;
        $feeFromFileLenght            = strlen($feeName);
        $feeDataPartSpacesLenght      = $feeDataPartSpacesLenghtTotal - $feeFromFileLenght;
        $feeDataPartSpaces            = [];

        for ($i=0; $i < $feeDataPartSpacesLenght; $i++) {
            array_push($feeDataPartSpaces, ' ');
        }

        $feeDataPartSpaces = implode($feeDataPartSpaces);
        $feeDataPart       = ' '.$feeName.$feeDataPartSpaces;

        $feeAmountPartLenght       = strlen($feeAmount);
        $feeAmountPartSpacesLenght = 11 - $feeAmountPartLenght;
        $feeAmountSpaces           = [];

        for ($i=0; $i < $feeAmountPartSpacesLenght; $i++) {
            array_push($feeAmountSpaces, ' ');
        }

        $feeAmountSpaces      = implode($feeAmountSpaces);
        $feeAmountPart        = $feeAmountSpaces.$feeAmount.' ';
        $idFeeAmountLineFinal = '|'.$feeDataPart.'|'.$feeAmountPart.'|';

        return $idFeeAmountLineFinal;
    }

    protected function firstLine()
    {
        $firstLinePartTwoLenght = 83;
        $firstLinePartTwo       = [];

        for ($i=0; $i < $firstLinePartTwoLenght; $i++) {
            array_push($firstLinePartTwo, '-');
        }

        $firstLinePartTwo   = implode($firstLinePartTwo);
        $firstLinePartThree = '------------';
        $firstLineFinal     = '+'.$firstLinePartTwo.'+'.$firstLinePartThree.'+';
        
        return $firstLineFinal;
    }

    protected function secondLine()
    {
        $feePartSpacesLenght = 78;
        $feePartSpaces       = [];

        for ($i=0; $i < $feePartSpacesLenght; $i++) {
            array_push($feePartSpaces, ' ');
        }

        $feePartSpaces        = implode($feePartSpaces);
        $feePart              = ' Fees'.$feePartSpaces;
        $amountPart           = ' Amount (€) ';
        $idFeeAmountLineFinal = '|'.$feePart.'|'.$amountPart.'|';

        return $idFeeAmountLineFinal;
    }

    protected function totalLine()
    {
        $totalLineSpacesLenght = 77;
        $totalLineSpaces       = [];

        for ($i=0; $i < $totalLineSpacesLenght; $i++) {
            array_push($totalLineSpaces, ' ');
        }

        $totalLineSpaces = implode($totalLineSpaces);
        $sumSpacesLenght = 11 - strlen($this->feeSum);
        $sumSpaces       = [];

        for ($i=0; $i < $sumSpacesLenght; $i++) {
            array_push($sumSpaces, ' ');
        }

        $sumSpaces      = implode($sumSpaces);
        $totalLineFinal = '|'.$totalLineSpaces.'Total '.'|'.$sumSpaces.$this->feeSum.' |';

        return $totalLineFinal;
    }

    protected function lastLine()
    {
        $lastLinePartOneLenght = 83;
        $lastLinePartOne       = [];

        for ($i=0; $i < $lastLinePartOneLenght; $i++) {
            array_push($lastLinePartOne, '-');
        }

        $lastLinePartOne = implode($lastLinePartOne);
        $lastLinePartTwo = '------------';
        $lastLineFinal   = '+'.$lastLinePartOne.'+'.$lastLinePartTwo.'+';
        
        return $lastLineFinal;
    }

    public function draw()
    {
        $linesPartOne = [
            "\t".$this->firstLine()."\n",
            "\t".$this->secondLine()."\n",
            "\t".$this->firstLine()."\n",
        ];

        $linesPartTwo = [
            "\t".$this->firstLine()."\n",
            "\t".$this->totalLine()."\n",
            "\t".$this->lastLine()."\n",
        ];

        for ($i=0; $i < count($this->feeID); $i++) {
            $FileData = "\t".$this->writeDataFromFile(
                $this->feeName[$i],
                $this->feeAmount[$i]
            )."\n";

            array_push($linesPartOne, $FileData);
        }

        $lines = array_merge($linesPartOne, $linesPartTwo);
        $lines = implode($lines);

        return iconv('UTF-8', 'windows-1252', $lines);
    }
}
