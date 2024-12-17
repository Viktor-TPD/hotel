<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

//@debug
$dates = calendarDatesToTimeStamp($_POST['selectedDates']);
die(var_dump($dates));

// var_dump($_POST); //@debug
// CHECK AND SANITIZE
if (!empty($_POST)) {
    //CHECK IF ALL REQUIRED PARAMETERS ARE PRESENT @todo ADD THEM AS THEY COME ALONG
    if (!isset($_POST['name'], $_POST['selectedDates'], $_POST['roomType'])) {
        echo "SOMETHING WASN'T SET";
        // header('Location: /');
        // exit;
    }
    //USER HAS ENTERED ALL REQUIRED INFO
    //SANITIZE INPUT
    $date = date("U"); //@debug
    $room = htmlspecialchars($_POST['roomType']);
    $dates = htmlspecialchars($_POST['selectedDates']);
    $name = htmlspecialchars($_POST['name']);

    //PREPARE STATEMENT (BOOKINGS GOES: id, guests, room_id, room_price, arrival_date, total_price)
    //@debug: LOTS OF PLACEHOLDER VALUES HERE
    $statement = "INSERT INTO bookings ('guests_id', 'room_id', 'room_price', 'arrival_date', 'total_price')
    VALUES (1, 1, 1, $date, 1);";
    executeQuery($db, $statement);
} else {
    $_POST['error'][] = "No data found";
}


// header('Location: /');
