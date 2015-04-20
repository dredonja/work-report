<?php

namespace App\Controllers\MainControllers;

use App\Controllers\UserController;
use App\Controllers\UserDataHandlerController;
use App\Models\DrawReport;
use App\Models\User;
use App\Models\UserDataHandler;

class MainUserController
{
    protected $User;
    protected $UserDataHandler;
    protected $DrawReport;
    protected $UserController;
    protected $UserDataHandlerController;

    public function __construct(
        User $User,
        UserDataHandler $UserDataHandler,
        UserController $UserController, 
        UserDataHandlerController $UserDataHandlerController,
        DrawReport $DrawReport
    )
    {
        $this->User                      = $User;
        $this->UserDataHandler           = $UserDataHandler;
        $this->UserController            = $UserController;
        $this->UserDataHandlerController = $UserDataHandlerController;
        $this->DrawReport                = $DrawReport;
    }

    public function getHelp()
    {
        return $this->UserDataHandler->getHelp();
    }

    public function credentials($firstName, $lastName, $email)
    {
        $action = $this->UserDataHandler->storeCredentials($firstName, $lastName, $email);

        return $this->UserDataHandlerController->storeCredentialsCheck($action);
    }

    public function credentialsEdit($firstName, $lastName, $email)
    {
        $action = $this->UserDataHandler->editCredentials($firstName, $lastName, $email);

        return $this->UserDataHandlerController->editCredentialsCheck($action);
    }

    public function getStatus()
    {
        return $this->UserDataHandler->status()."\n";
    }

    public function reset()
    {
        $actionOne = $this->UserDataHandler->resetReportData();
        $actionTwo = $this->UserDataHandler->resetIterator();
        
        return $this->UserDataHandlerController->resetReportDataCheck($actionOne, $actionTwo);
    }

    public function create()
    {
        $this->UserDataHandler->storeCurrentDateData();
        $this->UserDataHandler->setPath();
        $action = $this->UserDataHandler->createNewReport();
        
        return $this->UserDataHandlerController->createNewReportCheck($action);
    }

    public function createPrevious()
    {
        $this->UserDataHandler->setPath();
        $action = $this->UserDataHandler->createReportForPreviousMonth();
        
        return $this->UserDataHandlerController->createReportForPreviousMonthCheck($action);
    }

    public function editTask($task, $hours, $taskId)
    {
        $actionOne = $this->User->updateTask($task, $taskId);
        $actionTwo = $this->User->updateTaskTime($hours, $taskId);
        
        return $this->UserController->updateTaskCheck($actionOne, $actionTwo);
    }

    public function deleteTask($taskId)
    {
        $action = $this->User->deleteTask($taskId);

        return $this->UserController->deleteTaskCheck($action);
    }

    public function addTask($task, $hours)
    {
        $action = $this->User->insertReportData($task, $hours);

        return $this->UserController->insertReportDataCheck($action);
    }

    public function reportVisual()
    {
        return "\n".$this->DrawReport->draw()."\n";
    }
}
