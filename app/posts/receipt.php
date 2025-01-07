<?php

declare(strict_types=1);

require_once __DIR__ . "/../autoload.php";

var_dump($_SESSION['receipt']);
unset($_SESSION['receipt']);
