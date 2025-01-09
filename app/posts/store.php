<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

// EARLY ESCAPES:
// CHECK IF USER, FOR SOME REASON, MANAGED TO BOOK A BOOKED ROOM
if (validateBookedDates($db, $_POST['roomType'])) {
    // USER HAS SUBMITTED A BOOKED ROOM
    $_SESSION['errors'][] = "Oops, someone already booked one of your rooms. Please try again.";
    header('Location: ' . BASE_URL . '/index.php');
    exit;
}
// CHECK IF USER'S TRANSFER CODE IS VALID
if (!isValidUuid($_POST['transferCode'])) {
    $_SESSION['errors'][] = "Oops, your transfer code is not in the proper format. Please try again.";
    header('Location: ' . BASE_URL . '/index.php');
    exit;
}

// $features = $_POST['amenities'] ?? [];

// CHECK AND SANITIZE
if (!empty($_POST)) {
    //CHECK IF ALL REQUIRED PARAMETERS ARE PRESENT @todo ADD THEM AS THEY COME ALONG
    if (!isset($_POST['name'], $_POST['selectedDates'], $_POST['roomType'], $_POST['transferCode'])) {
        $_SESSION['errors'][] = "Oops! You didn't fill out a field properly. Try again!";
        header('Location: ' . BASE_URL . '/index.php');
        exit;
    }

    //CHECK IF ALL REQUIRED PARAMETERS ARE PRESENT @todo ADD THEM AS THEY COME ALONG
    if (empty($_POST['name']) || empty($_POST['selectedDates']) || empty($_POST['roomType']) || empty($_POST['transferCode'])) {
        $_SESSION['errors'][] = "Oops! You didn't fill out a field properly. Try again!";
        header('Location: ' . BASE_URL . '/index.php');
        exit;
    }

    // USER HAS ENTERED ALL REQUIRED INFO
    // SOME HELP FOR THE ROOM TYPE
    //@todo THIS IS NOT DRY. WILL CHANGE APPROACH IF THERE'S TIME
    $roomToNumber =
        [
            'budget' => 1,
            'standard' => 2,
            'luxury' => 3
        ];
    $roomTypeToName =
        [
            'budget' => "Wanda's Dungeon",
            'standard' => "Sejdeln's Imporium",
            'luxury' => "FIT FOR A KING'S HEAD"
        ];

    // SANITIZE INPUT
    $room = htmlspecialchars($_POST['roomType']);
    $dates = htmlspecialchars($_POST['selectedDates']);
    $name = htmlspecialchars($_POST['name']);
    $transferCode = htmlspecialchars($_POST['transferCode']);

    // TAKE THEIR MONEY (@todo MAKE A FUNCTION?)
    // GET THE PRICE OF THE ROOM TYPE THEY'VE BOOKED
    $priceQuery = "SELECT price FROM rooms WHERE type = :roomType;";
    $priceResult = queryFetchAssoc($db, $priceQuery, [':roomType' => $room], "");
    // CALCULATE THE TOTAL COST
    // GET NUMBER OF DAYS BOOKED
    $tempArray = array_filter(explode(",", $dates));
    $priceDateMultiplyer = count($tempArray);
    // THEN MULTIPLY NUMBER OF DAYS WITH THE COST OF ROOM 
    $totalPrice = $priceResult['price'] * $priceDateMultiplyer;
    // VALIDATE THE TRANSFER CODE
    if (!validateTransferCode($transferCode, $totalPrice)) {
        $_SESSION['errors'][] = "Invalid transfer code, please try again.";
        header('Location: ' . BASE_URL . '/index.php');
        exit;
    }
    // CODE IS VALID, TAKE MONEY!
    makeDeposit($transferCode);
} else {
    $_SESSION['errors'][] = "No data found";
    header('Location: ' . BASE_URL . '/index.php');
    exit;
}
// USER INPUTE IS GOOD! WRITE TO DATABASE...
// @debug: LOTS OF PLACEHOLDER VALUES HERE, ADD THEM PROPERLY!!
// WRITE TO GUEST
$statement = "INSERT INTO guests ('transfer_code') VALUES ('$transferCode');";
executeQuery($db, $statement);
$guestId = getCurrentGuestId($db);
// PREPARE STATEMENT (BOOKINGS GOES: id, guests_id, guest_name, room_id, room_price, arrival_date, total_price)
$statement = "INSERT INTO bookings 
    (guests_id, guest_name, room_id, room_price, arrival_date, total_price)
    VALUES (:guests_id, :guest_name, :room_id, :room_price, :arrival_date, :total_price);";

$parameters = [
    ':guests_id' => $guestId,
    ':guest_name' => $name,
    ':room_id' => $roomToNumber[$room],
    ':room_price' => $priceResult['price'],
    ':arrival_date' => $dates,
    ':total_price' => $totalPrice
];
// WRITE TO BOOKINGS
executeQuery($db, $statement, $parameters);

// GIVE USER RECEIPT
// @todo SOME DATA HERE SHOULD BE SET IN THE DATABASE. WILL IMPLEMENT WHEN TIME IS AVAILABLE
// PREPARE SOME VARIABLES
$tempDates = explode(',', $dates);
$arrivalDate = calendarDatesToTimeStamp($tempDates[0]);
$departureDate = calendarDatesToTimeStamp(end($tempDates));
$datesAmount = count($tempDates);
$_SESSION['receipt'] = [
    'island' => 'Second Long Island',
    'hotel' => $roomTypeToName[$room],
    'arrival_date' => $arrivalDate,
    'departure_date' => $departureDate,
    'total_cost' => $totalPrice,
    'additional_info' => [
        'greeting' => "Thank you for your booking. Enjoy your stay at our facilities on Second Long Island!",
        'imageUrl' => 'https://i.giphy.com/media/v1.Y2lkPTc5MGI3NjExNThoZDIzOHFneGY2YTYyOTMxeG5tMmJyaDByb2FsbjRydHVpeWNraSZlcD12MV9pbnRlcm5hbF9naWZfYnlfaWQmY3Q9Zw/QsyPRpG6WVR6SYfBVw/giphy.gif',
        'totalDays' => "We look forward to having you stay at $roomTypeToName[$room] for $datesAmount days.",
    ],
];
$_SESSION['openReceipt'] = true;
// $_SESSION['bookingComplete'] = true;

header('Location: ' . BASE_URL . '/index.php#radioButtons');
exit;
