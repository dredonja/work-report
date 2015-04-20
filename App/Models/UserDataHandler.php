<?php

namespace App\Models;

class UserDataHandler
{
    public function setPath()
    {
        $monthName     = $this->currentMonthName();
        $year          = $this->currentYear();
        $newReportPath = 'Reports_Data/'.$monthName.'_'.$year;

        return $newReportPath;
    }

    public function currentMonthName()
    {
        if ($this->getCurrentDateData()) {
            $currentMonthName = explode('_', $this->getCurrentDateData());
          
            return $currentMonthName[0];
        } else {
            return false;
        }
    }

    public function storeCredentials($firstName, $lastName, $email)
    {
        if ( ! file_exists('User/credentials.rep')) {

            return file_put_contents('User/credentials.rep', $firstName.'|'.$lastName.'|'.$email);
        } else {
            return false;
        }
    }

    public function editCredentials($firstName, $lastName, $email)
    {
        if (file_exists('User/credentials.rep')) {

            return file_put_contents('User/credentials.rep', $firstName.'|'.$lastName.'|'.$email);
        } else {
            return false;
        }
    }

    protected function getCredentials()
    {
        if (file_exists('User/credentials.rep')) {
            
            return file_get_contents('User/credentials.rep');
        } else {
            return false;
        }
    }

    public function getUserFirstName()
    {
        if ($this->getCredentials()) {
            $credentials   = $this->getCredentials();
            $userFirstName = explode('|', $credentials);
            
            return $userFirstName[0];
        } else {
            return false;
        }
    }

    public function getUserLastName()
    {
        if ($this->getCredentials()) {
            $credentials  = $this->getCredentials();
            $userLastName = explode('|', $credentials);
            
            return $userLastName[1];
        } else {
            return false;
        }
    }

    public function getUserEmail()
    {
        if ($this->getCredentials()) {
            $credentials = $this->getCredentials();
            $userEmail   = explode('|', $credentials);
            
            return $userEmail[2];
        } else {
            return false;
        }
    }

    public function currentYear()
    {
        if ($this->getCurrentDateData()) {
            $currentYear = explode('_', $this->getCurrentDateData());

            return $currentYear[2];
        } else {
            return false;
        }
    }

    public function currentMonthNumber()
    {
        if ($this->getCurrentDateData()) {
            $currentMonthNumber = explode('_', $this->getCurrentDateData());

            return $currentMonthNumber[1];
        } else {
            return false;
        }
    }

    public function storeCurrentDateData()
    {
        return file_put_contents('User/current-month.rep', date("F_m_Y"));
    }

    protected function getCurrentDateData()
    {
        if (file_exists('User/current-month.rep')) {
            return file_get_contents('User/current-month.rep');
        } else {
            return false;
        }
    }

    protected function reportDataExists($fileName)
    {
        return file_exists($this->setPath().'/'.$fileName);
    }

    public function createNewReport()
    {
        if ( ! file_exists($this->setPath())) {
            mkdir($this->setPath());

            return $this->setIterator($this->setPath());
        } else {
            return false;
        }
    }

    public function createReportForPreviousMonth()
    {
        if ( ! file_exists($this->setPath())) {
            mkdir($this->setPath());

            return $this->setIterator($this->setPath());
        } else {
            return false;
        }
    }

    protected function setIterator($path)
    {
        return file_put_contents($path.'/'.'iterator', 0);
    }

    protected function iterate()
    {
        if ($this->reportDataExists('iterator')) {
            $currentIteratorValue = file_get_contents($this->setPath().'/'.'iterator');
            $iterator             = $currentIteratorValue + 1;
            
            file_put_contents($this->setPath().'/'.'iterator', $iterator);

            return $iterator;
        } else {
            return false;
        }
    }

    public function getReportData()
    {
        if ($this->reportDataExists('report.rep')) {
            return $this->setPath().'/'.'report.rep';
        } else {
            return false;
        }
    }

    public function calculateLongestTask()
    {
        if ($this->reportDataExists('report.rep')) {
            $lines       = file($this->getReportData());
            $longestTask = [];
            for ($i=0; $i <count($lines); $i++) {
                $taskLine[] = explode('|', $lines[$i]);
                array_push($longestTask, strlen($taskLine[$i][1]));
            }
            if ( ! empty($longestTask)) {
                return $longestTask = max($longestTask);
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function calculateSum()
    {
        if ($this->reportDataExists('report.rep')) {
            $lines = file($this->getReportData());
            $sum   = [];
            for ($i=0; $i <count($lines); $i++) {
                $taskLine[] = explode('|', $lines[$i]);
                array_push($sum, $taskLine[$i][2]);
            }

            return array_sum($sum);
        } else {
            return false;
        }
    }

    public function taskID()
    {
        if ($this->reportDataExists('report.rep')) {
            $lines  = file($this->getReportData());
            $taskID = [];
            for ($i=0; $i <count($lines); $i++) {
                  $taskLine[] = explode('|', $lines[$i]);
                  array_push($taskID, trim($taskLine[$i][0]));
            }

            return $taskID;
        } else {
            return false;
        }
    }

    public function taskItSelf()
    {
        if ($this->reportDataExists('report.rep')) {
            $lines      = file($this->getReportData());
            $taskItSelf = [];
            for ($i=0; $i <count($lines); $i++) {
                 $taskLine[] = explode('|', $lines[$i]);
                 array_push($taskItSelf, trim($taskLine[$i][1]));
            }

            return $taskItSelf;
        } else {
            return false;
        }
    }

    public function taskHours()
    {
        if ($this->reportDataExists('report.rep')) {
            $lines     = file($this->getReportData());
            $taskHours = [];
            for ($i=0; $i <count($lines); $i++) {
                 $taskLine[] = explode('|', $lines[$i]);
                 array_push($taskHours, trim($taskLine[$i][2]));
            }

            return $taskHours;
        } else {
            return false;
        }
    }

    public function resetReportData()
    {
        return file_put_contents($this->setPath().'/'.'report.rep', '');
    }

    public function resetIterator()
    {
        return $this->setIterator($this->setPath());
    }

    public function status()
    {
        return 'First name: ' . $this->getUserFirstName() . "\n" .
               'Last name: ' . $this->getUserLastName() . "\n" .
               'Skrill e-mail: ' . $this->getUserEmail() . "\n\n" .
               'Current month is set to '.$this->currentMonthName().'/'.$this->currentYear().'.';
    }

    public function getHelp()
    {
        return file_get_contents('User/help.txt');
    }
}
