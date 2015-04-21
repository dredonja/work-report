<?php

namespace App\Models;

use App\Models\UserDataHandler;

class DrawReportFinal
{
    protected $date;
    protected $sum;
    protected $taskID;
    protected $taskItSelf;
    protected $taskHours;

    public $userEmail;
    public $userFirstName;
    public $userLastName;
    public $monthName;
    public $year;
    public $monthNumber;

    public function __construct(UserDataHandler $UserDataHandler)
    {
        $this->sum           = $UserDataHandler->calculateSum();
        $this->userFirstName = $UserDataHandler->getUserFirstName();
        $this->userLastName  = $UserDataHandler->getUserLastName();
        $this->userEmail     = $UserDataHandler->getUserEmail();
        $this->monthName     = $UserDataHandler->currentMonthName();
        $this->year          = $UserDataHandler->currentYear();
        $this->date          = $UserDataHandler->currentMonthNumber().'/'.
                               $UserDataHandler->currentYear();
        $this->monthNumber   = $UserDataHandler->currentMonthNumber();
        $this->taskID        = $UserDataHandler->taskID();
        $this->taskItSelf    = $UserDataHandler->taskItSelf();
        $this->taskHours     = $UserDataHandler->taskHours();
    }

    protected function writeDataFromFile($taskfromFile, $timeFromFile)
    {
        $taskDataPartSpacesLenghtTotal = 82;
        $taskFromFileLenght            = strlen($taskfromFile);
        $taskDataPartSpacesLenght      = $taskDataPartSpacesLenghtTotal - $taskFromFileLenght;
        $taskDataPartSpaces            = [];

        for ($i=0; $i < $taskDataPartSpacesLenght; $i++) {
            array_push($taskDataPartSpaces, ' ');
        }

        $taskDataPartSpaces = implode($taskDataPartSpaces);
        $taskDataPart       = ' '.$taskfromFile.$taskDataPartSpaces;

        $timeDataPartLenght       = strlen($timeFromFile);
        $timeDataPartSpacesLenght = 11 - $timeDataPartLenght;
        $timeDataSpaces           = [];

        for ($i=0; $i < $timeDataPartSpacesLenght; $i++) {
            array_push($timeDataSpaces, ' ');
        }

        $timeDataSpaces          = implode($timeDataSpaces);
        $timeDataPart            = $timeDataSpaces.$timeFromFile.' ';
        $idTaskTimeDataLineFinal = '|'.$taskDataPart.'|'.$timeDataPart.'|';

        return $idTaskTimeDataLineFinal;
    }

    protected function idTaskTimeLine()
    {
        $taskPartSpacesLenght = 78;
        $taskPartSpaces       = [];

        for ($i=0; $i < $taskPartSpacesLenght; $i++) {
            array_push($taskPartSpaces, ' ');
        }

        $taskPartSpaces      = implode($taskPartSpaces);
        $taskPart            = ' Task'.$taskPartSpaces;
        $timePart            = '   Time (h) ';
        $idTaskTimeLineFinal = '|'.$taskPart.'|'.$timePart.'|';

        return $idTaskTimeLineFinal;
    }

    protected function totalLine()
    {
        $totalLineSpacesLenght = 77;
        $totalLineSpaces       = [];

        for ($i=0; $i < $totalLineSpacesLenght; $i++) {
            array_push($totalLineSpaces, ' ');
        }

        $totalLineSpaces = implode($totalLineSpaces);
        $sumSpacesLenght = 11 - strlen($this->sum);
        $sumSpaces       = [];

        for ($i=0; $i < $sumSpacesLenght; $i++) {
            array_push($sumSpaces, ' ');
        }

        $sumSpaces      = implode($sumSpaces);
        $totalLineFinal = '|'.$totalLineSpaces.'Total '.'|'.$sumSpaces.$this->sum.' |';

        return $totalLineFinal;
    }

    protected function wrapLine()
    {
        $wrapLinePartOneLength = 83;
        $wrapLinePartOne       = [];
        for ($i=0; $i < $wrapLinePartOneLength; $i++) {
            array_push($wrapLinePartOne, '-');
        }

        $wrapLinePartOne = implode($wrapLinePartOne);

        $wrapLinePartTwo = '------------';
        $wrapLineFinal   = '+'.$wrapLinePartOne.'+'.$wrapLinePartTwo.'+';
        
        return $wrapLineFinal;
    }

    public function draw()
    {
        $linesPartOne = [
            "\t".$this->userFirstName.' '.$this->userLastName."\n",
            "\t".$this->userEmail."\n"."\n",
            "\t".'Work report '.$this->date."\n"."\n",

            "\t".$this->wrapLine()."\n",
            "\t".$this->idTaskTimeLine()."\n",
            "\t".$this->wrapLine()."\n",
        ];

        $linesPartTwo = [
            "\t".$this->wrapLine()."\n",
            "\t".$this->totalLine()."\n",
            "\t".$this->wrapLine()."\n",
        ];

        for ($i=0; $i < count($this->taskID); $i++) {
            $FileData = "\t".$this->writeDataFromFile(
                $this->taskItSelf[$i],
                $this->taskHours[$i]
            )."\n";

            array_push($linesPartOne, $FileData);
        }

        $lines = array_merge($linesPartOne, $linesPartTwo);

        return $lines = implode($lines);
    }
}
