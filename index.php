<?php

require __DIR__ . '/vendor/autoload.php';

use App\Controllers\KPIController;

// Load the environment variables from .env file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Create an instance of KPIController
$kpiController = new KPIController();

// Fetch the grouped KPI data
$groupedData = $kpiController->getGroupedKPIData();
