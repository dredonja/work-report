<?php

namespace App\Models;

use App\Models\FeesDataHandler;

class DrawFeesReport
{
    protected $longestTask;
    protected $feeSum;
    protected $feeID;
    protected $feeName;
    protected $feeAmount;

    public function __construct(FeesDataHandler $FeesDataHandler)
    {
        $this->longestTask = $FeesDataHandler->calculateLongestTask();
        $this->feeSum      = $FeesDataHandler->calculateFeeSum();
        $this->feeID       = $FeesDataHandler->feeID();
        $this->feeName     = $FeesDataHandler->feeName();
        $this->feeAmount   = $FeesDataHandler->feeAmount();
    }

    protected function writeDataFromFile($feeID, $feeName, $feeAmount)
    {
        // id task time line data
        $idPartDataLenght       = strlen($feeID);
        $idPartDataSpacesLenght = 6 - $idPartDataLenght;
        $idPartDataSpaces       = [];

        for ($i=0; $i < $idPartDataSpacesLenght; $i++) {
            array_push($idPartDataSpaces, ' ');
        }

        $idPartDataSpaces = implode($idPartDataSpaces);
        $idPartData       = $idPartDataSpaces.$feeID.' ';

        $feeDataPartSpacesLenghtTotal = $this->longestTask + 15;
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
        $idFeeAmountLineFinal = '|'.$idPartData.'|'.$feeDataPart.'|'.$feeAmountPart.'|';

        return $idFeeAmountLineFinal;
    }

    protected function firstLine()
    {
        $firstLinePartOne       = '-------';
        $firstLinePartTwoLenght = 16 + $this->longestTask;
        $firstLinePartTwo       = [];

        for ($i=0; $i < $firstLinePartTwoLenght; $i++) {
            array_push($firstLinePartTwo, '-');
        }

        $firstLinePartTwo   = implode($firstLinePartTwo);
        $firstLinePartThree = '------------';
        $firstLineFinal     = '+'.$firstLinePartOne.'+'.$firstLinePartTwo.'+'.$firstLinePartThree.'+';
        
        return $firstLineFinal;
    }

    

    protected function secondLine()
    {
        $idPart              = '    ID ';
        $feePartSpacesLenght = $this->longestTask + 11;
        $feePartSpaces       = [];

        for ($i=0; $i < $feePartSpacesLenght; $i++) {
            array_push($feePartSpaces, ' ');
        }

        $feePartSpaces        = implode($feePartSpaces);
        $feePart              = ' Fees'.$feePartSpaces;
        $amountPart           = ' Amount (€) ';
        $idFeeAmountLineFinal = '|'.$idPart.'|'.$feePart.'|'.$amountPart.'|';

        return $idFeeAmountLineFinal;
    }

    protected function totalLine()
    {
        // total line
        $totalLineSpacesLenght = $this->longestTask + 18;
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
        $lastLinePartOne       = '-------';
        $lastLinePartTwoLenght = 16 + $this->longestTask;
        $lastLinePartTwo       = [];

        for ($i=0; $i < $lastLinePartTwoLenght; $i++) {
            array_push($lastLinePartTwo, '-');
        }

        $lastLinePartTwo   = implode($lastLinePartTwo);
        $lastLinePartThree = '------------';
        $lastLineFinal     = '+'.$lastLinePartOne.'-'.$lastLinePartTwo.'+'.$lastLinePartThree.'+';
        
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
                $this->feeID[$i],
                $this->feeName[$i],
                $this->feeAmount[$i]
            )."\n";
            
            array_push($linesPartOne, $FileData);
        }

        $lines = array_merge($linesPartOne, $linesPartTwo);

        return $lines = implode($lines);
    }
}
