<?php

declare(strict_types=1);

// LOAD THE .ENV-FILE
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// START SESSION 
session_start();
