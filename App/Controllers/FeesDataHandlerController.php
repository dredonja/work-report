<?php

namespace App\Controllers;

use App\Models\Colors;

class FeesDataHandlerController extends Colors
{
    public function createNewFeeReportCheck($action)
    {
        if ($action) {
            return $this->getColoredString('New fee report is created.', 'green', null)."\n";
        } else {
            return $this->getColoredString('WARNING: You have already created fee report for this month.', 'red', null)."\n";
        }
    }
}
