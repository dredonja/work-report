<?php

namespace App\Models;

class FeesDataHandler extends UserDataHandler
{
    public function createNewFeeReport()
    {
        if (file_exists($this->setPath()) && ! file_exists($this->setPath().'/'.'fee_iterator')) {
            return $this->setFeeIterator($this->setPath());
        } else {
            return false;
        }
    }

    protected function setFeeIterator($path)
    {
        return file_put_contents($path.'/'.'fee_iterator', 0);
    }

    protected function feeIterate()
    {
        if ($this->reportDataExists('fee_iterator')) {
            $currentIteratorValue = file_get_contents($this->setPath().'/'.'fee_iterator');
            $iterator             = $currentIteratorValue + 1;
            
            file_put_contents($this->setPath().'/'.'fee_iterator', $iterator);

            return $iterator;
        } else {
            return false;
        }
    }

    protected function getFeeData()
    {
        if ($this->reportDataExists('fees.rep')) {

            return $this->setPath().'/'.'fees.rep';
        } else {
            return false;
        }
    }

    public function feeID()
    {
        if ($this->reportDataExists('fees.rep')) {
            $lines = file($this->getFeeData());
            $feeID = [];

            for ($i=0; $i <count($lines); $i++) {
                 $feeLine[] = explode('|', $lines[$i]);
                 array_push($feeID, trim($feeLine[$i][0]));
            }

            return $feeID;
        } else {
            return false;
        }
    }

    public function feeName()
    {
        if ($this->reportDataExists('fees.rep')) {
            $lines   = file($this->getFeeData());
            $feeName = [];

            for ($i=0; $i <count($lines); $i++) {
                 $feeLine[] = explode('|', $lines[$i]);
                 array_push($feeName, trim($feeLine[$i][1]));
            }

            return $feeName;
        } else {
            return false;
        }
    }

    public function feeAmount()
    {
        if ($this->reportDataExists('fees.rep')) {
            $lines     = file($this->getFeeData());
            $feeAmount = [];

            for ($i=0; $i <count($lines); $i++) {
                 $feeLine[] = explode('|', $lines[$i]);
                 array_push($feeAmount, trim($feeLine[$i][2]));
            }

            return $feeAmount;
        } else {
            return false;
        }
    }

    public function calculateFeeSum()
    {
        if ($this->reportDataExists('fees.rep')) {
            $lines = file($this->getFeeData());
            $sum   = [];

            for ($i=0; $i <count($lines); $i++) {
                $feeLine[] = explode('|', $lines[$i]);
                array_push($sum, $feeLine[$i][2]);
            }

            return array_sum($sum);
        } else {
            return false;
        }
    }

    public function resetFeeData()
    {
        return file_put_contents($this->setPath().'/'.'fees.rep', '');
    }

    public function resetFeeIterator()
    {
        return $this->setFeeIterator($this->setPath());
    }
}
