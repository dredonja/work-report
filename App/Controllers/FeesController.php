<?php

namespace App\Controllers;

use App\Models\Colors;

class FeesController extends Colors
{
    public function updateFeesCheck($actionOne, $actionTwo)
    {
        if ($actionOne && $actionTwo) {
            return $this->getColoredString('Fee data has been updated.', 'green', null)."\n";
        } else {
            return $this->getColoredString('WARNING: There is no data to edit.', 'red', null) . "\n";
        }
    }

    public function deleteFeeCheck($action)
    {
        if ($action || $action === 0) {
            return $this->getColoredString('Fee has been deleted.', 'green', null)."\n";
        } else {
            return $this->getColoredString('WARNING: There is no data to delete', 'red', null)."\n";
        }
    }

    public function insertFeeDataCheck($action)
    {
        if ($action) {
            return $this->getColoredString('New data has been inserted.', 'green', null)."\n";
        } else {
            return $this->getColoredString('WARNING: There is no existing report, please create one.', 'red', null)."\n";
        }
    }

    public function resetFeeDataCheck($feeDataReset, $iteratorReset)
    {
        if (($feeDataReset || $feeDataReset === 0) && $iteratorReset) {
            return $this->getColoredString('Fee report has been reseted', 'green', null)."\n";
        } else {
            return $this->getColoredString('WARNING: This operation cannot be done.', 'red', null)."\n";
        }
    }
}
