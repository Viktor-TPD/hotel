<?php

declare(strict_types=1);
require_once __DIR__ . '/../autoload.php';

header('Content-Type: application/json');
$query = "SELECT type, price FROM rooms";
$prices = queryFetchAssoc($db, $query);
echo json_encode($prices);
