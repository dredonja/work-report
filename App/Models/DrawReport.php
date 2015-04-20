<?php

namespace App\Models;

use App\Models\UserDataHandler;

class DrawReport
{
    protected $longestTask;
    protected $sum;
    protected $taskID;
    protected $taskItSelf;
    protected $taskHours;

    public function __construct(UserDataHandler $UserDataHandler)
    {
        $this->longestTask = $UserDataHandler->calculateLongestTask();
        $this->sum         = $UserDataHandler->calculateSum();
        $this->taskID      = $UserDataHandler->taskID();
        $this->taskItSelf  = $UserDataHandler->taskItSelf();
        $this->taskHours   = $UserDataHandler->taskHours();
    }

    protected function writeDataFromFile($idFromFile, $taskfromFile, $timeFromFile)
    {
        // id task time line data
        $idPartDataLenght       = strlen($idFromFile);
        $idPartDataSpacesLenght = 6 - $idPartDataLenght;
        $idPartDataSpaces       = [];

        for ($i=0; $i < $idPartDataSpacesLenght; $i++) {
            array_push($idPartDataSpaces, ' ');
        }

        $idPartDataSpaces = implode($idPartDataSpaces);
        $idPartData       = $idPartDataSpaces.$idFromFile.' ';

        $taskDataPartSpacesLenghtTotal = $this->longestTask + 15;
        $taskFromFileLenght            = strlen($taskfromFile);
        $taskDataPartSpacesLenght      = $taskDataPartSpacesLenghtTotal - $taskFromFileLenght;
        $taskDataPartSpaces            = [];

        for ($i=0; $i < $taskDataPartSpacesLenght; $i++) {
            array_push($taskDataPartSpaces, ' ');
        }

        $taskDataPartSpaces = implode($taskDataPartSpaces);
        $taskDataPart       = ' ' . $taskfromFile.$taskDataPartSpaces;

        $timeDataPartLenght       = strlen($timeFromFile);
        $timeDataPartSpacesLenght = 11 - $timeDataPartLenght;
        $timeDataSpaces           = [];

        for ($i=0; $i < $timeDataPartSpacesLenght; $i++) {
            array_push($timeDataSpaces, ' ');
        }

        $timeDataSpaces          = implode($timeDataSpaces);
        $timeDataPart            = $timeDataSpaces.$timeFromFile.' ';
        $idTaskTimeDataLineFinal = '|'.$idPartData.'|'.$taskDataPart.'|'.$timeDataPart.'|';

        return $idTaskTimeDataLineFinal;
    }

    protected function wrapLine()
    {
        // third, fifth, seventh and second to last line
        $wrapLinePartOne       = '-------';
        $wrapLinePartTwoLenght = 16 + $this->longestTask;
        $wrapLinePartTwo       = [];

        for ($i=0; $i < $wrapLinePartTwoLenght; $i++) {
            array_push($wrapLinePartTwo, '-');
        }

        $wrapLinePartTwo   = implode($wrapLinePartTwo);
        $wrapLinePartThree = '------------';
        $wrapLineFinal     = '+'.$wrapLinePartOne.'+'.$wrapLinePartTwo.'+'.$wrapLinePartThree.'+';
        
        return $wrapLineFinal;
    }

    protected function idTaskTimeLine()
    {
        // id task time line definition
        $idPart               = '    ID ';
        $taskPartSpacesLenght = $this->longestTask + 11;
        $taskPartSpaces       = [];

        for ($i=0; $i < $taskPartSpacesLenght; $i++) {
            array_push($taskPartSpaces, ' ');
        }

        $taskPartSpaces      = implode($taskPartSpaces);
        $taskPart            = ' Task'.$taskPartSpaces;
        $timePart            = '   Time (h) ';
        $idTaskTimeLineFinal = '|'.$idPart.'|'.$taskPart.'|'.$timePart.'|';

        return $idTaskTimeLineFinal;
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
        $sumSpacesLenght = 11 - strlen($this->sum);
        $sumSpaces       = [];

        for ($i=0; $i < $sumSpacesLenght; $i++) {
            array_push($sumSpaces, ' ');
        }

        $sumSpaces      = implode($sumSpaces);
        $totalLineFinal = '|'.$totalLineSpaces.'Total '.'|'.$sumSpaces.$this->sum.' |';

        return $totalLineFinal;
    }

    protected function lastLine()
    {
        $wrapLinePartOne       = '-------';
        $wrapLinePartTwoLenght = 16 + $this->longestTask;
        $wrapLinePartTwo       = [];

        for ($i=0; $i < $wrapLinePartTwoLenght; $i++) {
            array_push($wrapLinePartTwo, '-');
        }

        $wrapLinePartTwo   = implode($wrapLinePartTwo);
        $wrapLinePartThree = '------------';
        $wrapLineFinal     = '+'.$wrapLinePartOne.'-'.$wrapLinePartTwo.'+'.$wrapLinePartThree.'+';
        
        return $wrapLineFinal;
    }

    public function draw()
    {
        $linesPartOne = [
            "\t".$this->wrapLine()."\n",
            "\t".$this->idTaskTimeLine()."\n",
            "\t".$this->wrapLine()."\n",
        ];

        $linesPartTwo = [
            "\t".$this->wrapLine()."\n",
            "\t".$this->totalLine()."\n",
            "\t".$this->lastLine()."\n",
        ];

        for ($i=0; $i < count($this->taskID); $i++) {
            $FileData = "\t".$this->writeDataFromFile(
                $this->taskID[$i],
                $this->taskItSelf[$i],
                $this->taskHours[$i]
            )."\n";

            array_push($linesPartOne, $FileData);
        }

        $lines = array_merge($linesPartOne, $linesPartTwo);

        return $lines = implode($lines);
    }
}
