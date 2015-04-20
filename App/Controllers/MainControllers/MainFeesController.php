<?php

namespace App\Controllers\MainControllers;

use App\Controllers\FeesController;
use App\Controllers\FeesDataHandlerController;
use App\Models\DrawFeesReport;
use App\Models\Fees;
use App\Models\FeesDataHandler;

class MainFeesController
{
    protected $Fees;
    protected $FeesDataHandler;
    protected $FeesController;
    protected $FeesDataHandlerController;
    protected $DrawFeeReport;

    public function __construct(
        Fees $Fees,
        FeesDataHandler $FeesDataHandler,
        FeesController $FeesController,
        FeesDataHandlerController $FeesDataHandlerController,
        DrawFeesReport $DrawFeesReport
    )
    {
        $this->Fees                      = $Fees;
        $this->FeesDataHandler           = $FeesDataHandler;
        $this->FeesController            = $FeesController;
        $this->FeesDataHandlerController = $FeesDataHandlerController;
        $this->DrawFeesReport            = $DrawFeesReport;
    }

    public function feesCreate()
    {
        $action = $this->FeesDataHandler->createNewFeeReport();

        return $this->FeesDataHandlerController->createNewFeeReportCheck($action);
    }

    public function feesReset()
    {
        $actionOne = $this->Fees->resetFeeData();
        $actionTwo = $this->Fees->resetIterator();
        
        return $this->FeesController->resetFeeDataCheck($actionOne, $actionTwo);
    }

    public function editFee($feeName, $feeAmount, $feeId)
    {
        $actionOne = $this->Fees->updateFeeName($feeName, $feeId);
        $actionTwo = $this->Fees->updateFeeAmount($feeAmount, $feeId);
        
        return $this->FeesController->updateFeesCheck($actionOne, $actionTwo);
    }

    public function deleteFee($feeId)
    {
        $action = $this->Fees->deleteFee($feeId);
        
        return $this->FeesController->deleteFeeCheck($action);
    }

    public function insertNewFee($feeName, $feeAmount)
    {
        $action = $this->Fees->insertFeeData($feeName, $feeAmount);
        
        return $this->FeesController->insertFeeDataCheck($action);
    }

    public function feesVisual()
    {
        return "\n".$this->DrawFeesReport->draw()."\n";
    }
}
