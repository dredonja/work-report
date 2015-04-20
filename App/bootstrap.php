<?php

require 'Autoload/autoloader.php';

use App\Controllers\FeesDataHandlerController;
use App\Controllers\FeesController;
use App\Controllers\MainControllers\MainFeesController;
use App\Controllers\MainControllers\MainPDFFileController;
use App\Controllers\MainControllers\MainUserController;
use App\Controllers\UserController;
use App\Controllers\UserDataHandlerController;
use App\Models\DrawFeesReport;
use App\Models\DrawFeesReportFinal;
use App\Models\DrawReport;
use App\Models\DrawReportFinal;
use App\Models\Fees;
use App\Models\FeesDataHandler;
use App\Models\PDFFileDump;
use App\Models\User;
use App\Models\UserDataHandler;

unset($argv[0]);

$MUC  = new MainUserController(
    new User,
    new UserDataHandler,
    new UserController,
    new UserDataHandlerController,
    new DrawReport(new UserDataHandler)
);
$MFC  = new MainFeesController(
    new Fees,
    new FeesDataHandler,
    new FeesController,
    new FeesDataHandlerController,
    new DrawFeesReport(new FeesDataHandler)
);
$MPFC = new MainPDFFileController(
    new DrawFeesReportFinal(new FeesDataHandler),
    new DrawReportFinal(new UserDataHandler),
    new PDFFileDump
);
