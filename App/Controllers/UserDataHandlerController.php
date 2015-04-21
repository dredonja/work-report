<?php

namespace App\Controllers;

use App\Models\Colors;

class UserDataHandlerController extends Colors
{
    public function createNewReportCheck($action)
    {
        if ($action) {
            return $this->getColoredString('New report has been created.', 'green', null)."\n";
        } else {
            return $this->getColoredString('WARNING: You have created report for this month.', 'red', null)."\n";
        }
    }

    public function createReportForPreviousMonthCheck($action)
    {
        if ($action) {
            return $this->getColoredString('New report has been created.', 'green', null)."\n";
        } else {
            return $this->getColoredString('WARNING: You have created report for this month.', 'red', null)."\n";
        }
    }

    public function storeCredentialsCheck($action)
    {
        if ($action) {
            return $this->getColoredString('Your personal data is successfully stored.', 'green', null)."\n";
        } else {
            return $this->getColoredString('WARNING: You have already stored your personal data.', 'red', null)."\n";
        }
    }

    public function editCredentialsCheck($action)
    {
        if ($action) {
            return $this->getColoredString('Your personal data is successfully edited.', 'green', null)."\n";
        } else {
            return $this->getColoredString('WARNING: There is no data to edit.', 'red', null)."\n";
        }
    }
}
