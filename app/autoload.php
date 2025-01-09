<?php

declare(strict_types=1);

// START SESSION 
session_start();

// REQUIRE FUNCTIONS
require_once __DIR__ . '/functions.php';

// REQUIRE ALL OTHER AUTOLOADS
require_once __DIR__ . '/../vendor/autoload.php';

// CONNECT TO DATABASE 
$db = new PDO('sqlite:' . __DIR__ . '/../app/database/hotel.db');

// LOAD THE .ENV-FILE
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// FIX FILE PATHS: IF TRUE, WE'RE IN THE LOCAL ENVIRONMENT. IF FALSE, WE'RE IN THE DEPLOYED ENVIRONMENT.
if ($_ENV['FILE_PATH'] == __DIR__) {
    // LOCAL:
    define('BASE_URL', '');
} else {
    // DEPLOYED:
    define('BASE_URL', '/hotel/');
}
