<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

$error = [];

if (isset($_POST['name'], $_POST['password'])) {
    $userName = trim(htmlspecialchars($_POST['name']));
    $userPassword = trim(htmlspecialchars($_POST['password']));

    if ($userName !== $_ENV['ADMIN_NAME']) {
        $error[] = 'User not found.';
        $_SESSION['error'] = $error;
        header("Location: /login.php");
        exit;
    }

    if ($userPassword !== $_ENV['API_KEY']) {
        $error[] = 'Incorrect password.';
        $_SESSION['error'] = $error;
        header("Location: /login.php");
        exit;
    } else {
        $_SESSION['user']['name'] = $userName;
        header("Location: /");
        exit;
    }
}
