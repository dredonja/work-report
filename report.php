<?php

require 'App/bootstrap.php';

if (isset($argv) && ! empty($argv)) {
    
    if ($argv[1] == 'fees-create') {
        echo $MFC->feesCreate();
        exit;
    }

    if ($argv[1] == 'fees-reset') {
        echo $MFC->feesReset();
        exit;
    }

    if ($argv[1] == 'fees' && isset($argv[2]) && ($argv[2] == 'visual' || $argv[2] == '-v')) {
        echo $MFC->feesVisual();
        exit;
    }

    if ($argv[1] == 'fees' && isset($argv[2]) && isset($argv[3]) &&
       ($argv[2] == 'edit' || $argv[2] == '-e') && is_numeric($argv[3])) {
        echo "Enter New Fee Name: ";
        $feeName = trim(fgets(STDIN, 80));

        echo "Enter New Amount (€): ";
        $feeAmount = trim(fgets(STDIN, 10));

        echo $MFC->editFee($feeName, $feeAmount, $argv[3]);
        exit;
    }

    if ($argv[1] == 'fees' && isset($argv[2]) && isset($argv[3]) &&
       ($argv[2] == 'delete' || $argv[2] == '-d') && is_numeric($argv[3])) {
        echo $MFC->deleteFee($argv[3]);
        exit;
    }

    if ($argv[1] == 'fees') {
        echo "Enter Fee Name: ";
        $feeName = trim(fgets(STDIN, 80));

        echo "Enter Fee Amount (€): ";
        $feeAmount = trim(fgets(STDIN, 10));

        echo $MFC->insertNewFee($feeName, $feeAmount);
        exit;
    }

    if ($argv[1] == 'help' || $argv[1] == '-h') {
        echo $MUC->getHelp();
        exit;
    }

    if ($argv[1] == 'personal' && isset($argv[2]) && ($argv[2] == 'edit' || $argv[2] == '-e')) {
        echo "Enter your first name: ";
        $firstName = trim(fgets(STDIN, 40));

        echo "Enter your last name: ";
        $lastName = trim(fgets(STDIN, 40));

        echo "Enter your Skrill e-mail: ";
        $email = trim(fgets(STDIN, 40));

        echo $MUC->credentialsEdit($firstName, $lastName, $email);
        exit;
    }

    if ($argv[1] == 'personal') {
        echo "Enter your first name: ";
        $firstName = trim(fgets(STDIN, 40));

        echo "Enter your last name: ";
        $lastName = trim(fgets(STDIN, 40));

        echo "Enter your Skrill e-mail: ";
        $email = trim(fgets(STDIN, 40));

        echo $MUC->credentials($firstName, $lastName, $email);
        exit;
    }

    if ($argv[1] == 'status') {
        echo $MUC->getStatus();
        exit;
    }

    if ($argv[1] == 'reset') {
        echo $MUC->reset($actionOne, $actionTwo);
        exit;
    }

    if ($argv[1] == 'create' || $argv[1] == '-c') {
        echo $MUC->create();
        exit;
    }

    if ($argv[1] == 'CREATE' || $argv[1] == '-C') {
        echo $MUC->createPrevious();
        exit;
    }

    if (($argv[1] == 'edit' || $argv[1] == '-e') && is_numeric($argv[2])) {
        echo "Enter New Task Name: ";
        $task = trim(fgets(STDIN, 80));

        echo "Enter New TTC (h): ";
        $hours = trim(fgets(STDIN, 40));

        echo $MUC->editTask($task, $hours, $argv[2]);
        exit;
    }

    if (($argv[1] == 'delete' || $argv[1] == '-d') && is_numeric($argv[2])) {
        echo $MUC->deleteTask($argv[2]);
        exit;
    }

    if ($argv[1] == 'visual' || $argv[1] == '-v') {
        echo $MUC->reportVisual();
        exit;
    }

    if ($argv[1] == 'set' && $argv[2] == '-m' && isset($argv[3])) {
        if (isset($argv[4]) && $argv[4] == '-y') {
            if (isset($argv[5])) {
                $year = $argv[5];
            } else {
                $year = null;
            }
        } else {
            $year = null;
        }

        echo $MUC->setMonth($argv[3], $year);
        exit;
    }

    if ($argv[1] == 'dump-pdf') {
        echo $MPFC->dumpPdf();
        exit;
    }
}

echo "Enter Task Name: ";
$task = trim(fgets(STDIN, 80));

echo "Enter TTC (h): ";
$hours = trim(fgets(STDIN, 10));

echo $MUC->addTask($task, $hours);
