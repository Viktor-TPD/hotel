<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

// CHECK IF USER, FOR SOME REASON, MANAGED TO BOOK A BOOKED ROOM
if (validateBookedDates($db)) {
    // USER HAS SUBMITTED A BOOKED ROOM
    $_SESSION['error'][] = "Oops, someone already booked one of your rooms. Please try again.";
    header('Location: /');
    exit;
}

// $features = $_POST['amenities'] ?? [];



// CHECK AND SANITIZE
if (!empty($_POST)) {
    //CHECK IF ALL REQUIRED PARAMETERS ARE PRESENT @todo ADD THEM AS THEY COME ALONG
    if (!isset($_POST['name'], $_POST['selectedDates'], $_POST['roomType'])) {
        $_SESSION['error'][] = "Oops! You didn't fill out a field properly. Try again!";
        header('Location: /');
        exit;
    }

    //CHECK IF ALL REQUIRED PARAMETERS ARE PRESENT @todo ADD THEM AS THEY COME ALONG
    if (empty($_POST['name']) || empty($_POST['selectedDates']) || empty($_POST['roomType'])) {
        $_SESSION['error'][] = "Oops! You didn't fill out a field properly. Try again!";
        header('Location: /');
        exit;
    }

    //USER HAS ENTERED ALL REQUIRED INFO
    //SANITIZE INPUT
    $room = htmlspecialchars($_POST['roomType']);
    $dates = htmlspecialchars($_POST['selectedDates']);
    $name = htmlspecialchars($_POST['name']);

    // TAKE THEIR MONEY
    // GET THE PRICE OF THE ROOM
    $priceQuery = "SELECT price FROM rooms WHERE id=1";

    $priceResult = queryFetchAssoc($db, $priceQuery, [], "");
    die(var_dump($priceResult));


    //PREPARE STATEMENT (BOOKINGS GOES: id, guests, room_id, room_price, arrival_date, total_price)
    //@debug: LOTS OF PLACEHOLDER VALUES HERE
    $statement = "INSERT INTO bookings ('guests_id', 'room_id', 'room_price', 'arrival_date', 'total_price')
    VALUES (1, 1, 1, '$dates', 1);";
    executeQuery($db, $statement);
} else {
    $_SESSION['error'][] = "No data found";
}


header('Location: /');
