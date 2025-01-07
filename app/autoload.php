<?php

declare(strict_types=1);

// START SESSION 
session_start();


// REQUIRE FUNCTIONS
require_once __DIR__ . '/functions.php';

// REQUIRE ALL AUTOLOADS
require_once __DIR__ . '/../vendor/autoload.php';

// CONNECT TO DATABASE 
$db = new PDO('sqlite:' . __DIR__ . '/../app/database/hotel.db');


// LOAD THE .ENV-FILE
// echo __DIR__ . '/../'; //@debug
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// FIX FILE PATHS
if ($_ENV['FILE_PATH'] == __DIR__) {
    // LOCAL:
    define('BASE_URL', '');
    // echo "local"; // @debug
} else {
    // DEPLOYED:
    define('BASE_URL', '/hotel/');
    // echo "deployed"; // @debug
}
//ONLY LOAD CALENDAR WHEN WE'RE IN THE INDEX
if (basename($_SERVER['PHP_SELF']) == 'index.php') {
    require_once __DIR__ . '/calendarHandler.php';
}
