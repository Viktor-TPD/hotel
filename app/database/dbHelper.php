<?php
// Connect to SQLite database (creates the database file if it doesn't exist)
require_once __DIR__ . '/../functions.php';
$db = new PDO('sqlite:hotel.db');

// SQL QUERIES
$queries = [
    //QUERIES GOES HERE SEPARATED BY COMMAS
];

// EXECUTE
foreach ($queries as $query) {
    executeQuery($db, $query);
}

echo "Query successful.\n";
