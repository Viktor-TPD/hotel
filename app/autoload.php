<?php

declare(strict_types=1);

// REQUIRE FUNCTIONS
require_once __DIR__ . '/functions.php';

// REQUIRE ALL AUTOLOADS
require_once __DIR__ . '/../vendor/autoload.php';

// CONNECT TO DATABASE 
$db = new PDO('sqlite:' . __DIR__ . '/../app/database/hotel.db');

// START SESSION 
session_start();

// LOAD THE .ENV-FILE
// echo __DIR__ . '/../'; //@debug
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();
