<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

$error = [];

if (isset($_POST['email'], $_POST['password']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $userEmail = trim(htmlspecialchars($_POST['email']));
    $userPassword = trim(htmlspecialchars($_POST['password']));

    $result = $db->prepare("SELECT id, name , email, password from users WHERE email = :email;");
    $result->bindParam(':email', $userEmail, PDO::PARAM_STR);
    $result->execute();
    $userInfo = $result->fetch(PDO::FETCH_ASSOC);

    if (!$userInfo) {
        $error[] = 'User not found.';
        $_SESSION['error'] = $error;
        header("Location: /login.php");
        exit;
    }

    if (!password_verify($userPassword, $userInfo['password'])) {
        $error[] = 'Incorrect password.';
        $_SESSION['error'] = $error;
        header("Location: /login.php");
        exit;
    } else {
        unset($userInfo['password']);
        $userInfo['name'] = htmlspecialchars($userInfo['name']);
        $_SESSION['user'] = $userInfo;
        // echo "<pre>"; //@debug
        // var_dump($_SESSION['user']); //@debug
        header("Location: /");
    }
}
