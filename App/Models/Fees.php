<?php

namespace App\Models;

class Fees extends FeesDataHandler
{
    public function insertFeeData($feeName, $feeAmount)
    {
        $iterator = $this->feeIterate();

        if ($this->setPath() && $iterator) {

            return  file_put_contents(
                $this->setPath().'/'.'fees.rep',
                $iterator.'|'.$feeName.'|'.$feeAmount."\n",
                FILE_APPEND
            );
        } else {
            return false;
        }
    }

    public function updateFeeName($feeName, $feeNumber)
    {
        if ($this->reportDataExists('fees.rep')) {

            $lines = file($this->setPath().'/'.'fees.rep');

            if ( ! empty($lines)) {
                for ($i=0; $i < count($lines); $i++) {
                    $id              = explode('|', $lines[$i]);
                    $feeLine[$id[0]] = $lines[$i];
                }
                if (array_key_exists($feeNumber, $feeLine)) {
                    $singleLine[]        = explode('|', $feeLine[$feeNumber]);
                    $singleLine[0][1]    = $feeName;
                    $feeLine[$feeNumber] = implode('|', $singleLine[0]);

                    return file_put_contents($this->setPath().'/'.'fees.rep', $feeLine);
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }

    public function updateFeeAmount($feeAmount, $feeNumber)
    {
        if ($this->reportDataExists('fees.rep')) {

            $lines = file($this->setPath().'/'.'fees.rep');

            if ( ! empty($lines)) {
                for ($i=0; $i < count($lines); $i++) {
                    $id              = explode('|', $lines[$i]);
                    $feeLine[$id[0]] = $lines[$i];
                }
                if (array_key_exists($feeNumber, $feeLine)) {
                    $singleLine[]        = explode('|', $feeLine[$feeNumber]);
                    $singleLine[0][2]    = $feeAmount;
                    $feeLine[$feeNumber] = implode('|', $singleLine[0]);

                    return file_put_contents($this->setPath().'/'.'fees.rep', $feeLine);
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }

    public function deleteFee($feeNumber)
    {
        if ($this->reportDataExists('fees.rep')) {

            $lines = file($this->setPath().'/'.'fees.rep');

            if ( ! empty($lines)) {
                for ($i=0; $i < count($lines); $i++) {
                    $id              = explode('|', $lines[$i]);
                    $feeLine[$id[0]] = $lines[$i];
                }
                if (array_key_exists($feeNumber, $feeLine)) {
                    unset($feeLine[$feeNumber]);

                    return file_put_contents($this->setPath().'/'.'fees.rep', $feeLine);
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }
}
