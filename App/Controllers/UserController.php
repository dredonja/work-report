<?php

namespace App\Controllers;

use App\Models\Colors;

class UserController extends Colors
{
    public function insertReportDataCheck($action)
    {
        if ($action) {
            return $this->getColoredString("New data has been inserted.", "green", null) . "\n";
        } else {
            return $this->getColoredString("WARNING: There is no existing report, please create one.", "red", null) . "\n";
        }
    }

    public function resetReportDataCheck($reportReset, $iteratorReset)
    {
        if (($reportReset || $reportReset === 0) && $iteratorReset) {
            return $this->getColoredString("Report has been reseted", "green", null) . "\n";
        } else {
            return $this->getColoredString("WARNING: This operation cannot be done.", "red", null) . "\n";
        }
    }

    public function updateTaskCheck($actionOne, $actionTwo)
    {
        if ($actionOne && $actionTwo) {
            return $this->getColoredString("Task has been updated.", "green", null) . "\n";
        } else {
            return $this->getColoredString("WARNING: There is no data to edit.", "red", null) . "\n";
        }
    }

    public function deleteTaskCheck($action)
    {
        if ($action || $action === 0) {
            return $this->getColoredString("Task has been deleted.", "green", null) . "\n";
        } else {
            return $this->getColoredString("WARNING: There is no data to delete.", "red", null) . "\n";
        }
    }

    public function setCurrentMonthCheck($action)
    {
        if ($action) {
            return $this->getColoredString("Current month is reseted.", "green", null) . "\n";
        } else {
            return $this->getColoredString("WARNING: This operation cannot be done.", "red", null) . "\n";
        }
    }
}
