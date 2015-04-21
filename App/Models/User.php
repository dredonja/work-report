<?php
namespace App\Models;

class User extends UserDataHandler
{
    public function insertReportData($task, $hours)
    {
        $iterator = $this->iterate();

        if ($this->setPath() && $iterator) {
            
            return  file_put_contents(
                $this->setPath().'/'.'report.rep',
                $iterator.'|'.$task.'|'.$hours."\n",
                FILE_APPEND
            );
        } else {
            return false;
        }
    }

    public function updateTask($updatedTask, $taskNumber)
    {
        if ($this->reportDataExists('report.rep')) {
            $lines = file($this->setPath().'/'.'report.rep');

            if ( ! empty($lines)) {

                for ($i=0; $i < count($lines); $i++) {
                    $id               = explode('|', $lines[$i]);
                    $taskLine[$id[0]] = $lines[$i];
                }

                if (array_key_exists($taskNumber, $taskLine)) {
                    $singleLine[]          = explode('|', $taskLine[$taskNumber]);
                    $singleLine[0][1]      = $updatedTask;
                    $taskLine[$taskNumber] = implode('|', $singleLine[0]);

                    return file_put_contents($this->setPath().'/'.'report.rep', $taskLine);
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }

    public function updateTaskTime($updatedTime, $taskNumber)
    {
        if ($this->reportDataExists('report.rep')) {
            $lines = file($this->setPath().'/'.'report.rep');
            
            if ( ! empty($lines)) {

                for ($i=0; $i < count($lines); $i++) {
                    $id               = explode('|', $lines[$i]);
                    $taskLine[$id[0]] = $lines[$i];
                }

                if (array_key_exists($taskNumber, $taskLine)) {
                    $singleLine[]          = explode('|', $taskLine[$taskNumber]);
                    $singleLine[0][2]      = $updatedTime;
                    $taskLine[$taskNumber] = implode('|', $singleLine[0])."\n";

                    return file_put_contents($this->setPath().'/'.'report.rep', $taskLine);
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }

    public function deleteTask($taskNumber)
    {
        if ($this->reportDataExists('report.rep')) {
            $lines = file($this->setPath().'/'.'report.rep');

            if ( ! empty($lines)) {

                for ($i=0; $i < count($lines); $i++) {
                    $id               = explode('|', $lines[$i]);
                    $taskLine[$id[0]] = $lines[$i];
                }
                
                if (array_key_exists($taskNumber, $taskLine)) {
                    unset($taskLine[$taskNumber]);

                    return file_put_contents($this->setPath().'/'.'report.rep', $taskLine);
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }

    public function setCurrentMonth($month, $year = null)
    {
        if ($year == null) {
            $year = date("Y");
        } else {
            $year;
        }
        
        $months = [
            'january'   => '01',
            'february'  => '02',
            'march'     => '03',
            'april'     => '04',
            'may'       => '05',
            'june'      => '06',
            'july'      => '07',
            'august'    => '08',
            'september' => '09',
            'october'   => '10',
            'november'  => '11',
            'december'  => '12',
        ];

        if (is_numeric($month)) {
            
            if (strlen($month) == 1) {
                $month = '0'.$month;
            } else {
                $month;
            }

            $monthName   = ucfirst(array_search($month, $months));
            $monthNumber = $month;
        } else {
            $monthName   = ucfirst($month);
            $monthNumber = $months["{$month}"];
        }

        return  file_put_contents('User/current-month.rep', "{$monthName}_{$monthNumber}_{$year}");
    }
}
