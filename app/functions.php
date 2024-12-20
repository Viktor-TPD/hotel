<?php

declare(strict_types=1);

// LOAD GUZZLE :)
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

// EXECUTE QUERY
function executeQuery(PDO $db, string $query)
{
    try {
        $statement = $db->prepare($query);
        $statement->execute();
        echo "Query executed successfully.\n";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//EXAMPLE:
// SQL QUERIES
// $queries = [
//QUERIES (AS STRINGS) GOES HERE SEPARATED BY COMMAS
// ];

// EXECUTE
// foreach ($queries as $query) {
//     executeQuery($db, $query);
// }

// FETCH ALL (OR SINGLE IF YOU ADD A STRING TO THIRD ARGUMENT), RETURNS VALUE OF QUERY
function queryFetchAssoc(PDO $db, string $query, string $fetchAll = "all")
{
    try {
        $result = $db->prepare($query);
        $result->execute();
        $value = ($fetchAll === "all") ? $result->fetchAll(PDO::FETCH_ASSOC) : $result->fetch(PDO::FETCH_ASSOC);
        return $value;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

function calendarDatesToTimeStamp(string $selectedDates): array
{
    //MAKE DATES INTO ARRAY
    $selectedDates = explode(",", $selectedDates);
    $cleanedDates = [];
    foreach ($selectedDates as $date) {
        // ADD JANUARY'S DATE IN FRONT OF $date, ADD A 0 TO THE START OF SINGLE DIGITS
        $date = $date < 10 ? '2025-01-0' . $date : '2025-01-' . $date;
        $cleanedDates[] = $date;
        // echo $date; //@debug
    }
    return $cleanedDates;
}

function rebuildDataBase(PDO $db)
{
    $tempQuery = "DROP TABLES *;";
    executeQuery($db, $tempQuery);
    $rebuildQuery =
        [
            "--ADMIN SETTINGS
CREATE TABLE IF NOT EXISTS admin_settings (
id INTEGER PRIMARY KEY AUTOINCREMENT,
stars INTEGER NOT NULL,
greeting_message VARCHAR(60) NOT NULL,
image_url VARCHAR(200) NOT NULL
);",

            "--ROOMS
CREATE TABLE IF NOT EXISTS rooms (
id INTEGER PRIMARY KEY AUTOINCREMENT,
type VARCHAR(60) NOT NULL,
price DECIMAL(10, 2) NOT NULL
);",

            "-- AMENITIES
CREATE TABLE IF NOT EXISTS amenities (
id INTEGER PRIMARY KEY AUTOINCREMENT,
type VARCHAR(60) NOT NULL,
price DECIMA(10, 2) NOT NULL
);",

            "--GUESTS
CREATE TABLE IF NOT EXISTS guests (
id INTEGER PRIMARY KEY AUTOINCREMENT,
transfer_code VARCHAR(50) NOT NULL
);",

            "--AMENITIES_GUESTS
CREATE TABLE IF NOT EXISTS amenities_guests (
id INTEGER PRIMARY KEY AUTOINCREMENT,
amenities_id INTEGER NOT NULL,
guests_id INTEGER NOT NULL,
FOREIGN KEY (amenities_id) REFERENCES amenities(id),
FOREIGN KEY (guests_id) REFERENCES guests_id
);",

            "--BOOKINGS
CREATE TABLE IF NOT EXISTS bookings (
id INTEGER PRIMARY KEY AUTOINCREMENT,
guests_id INTEGER NOT NULL,
room_id INTEGER NOT NULL,
room_price DECIMAL(10,2) NOT NULL,
arrival_date VARCHAR(400) NOT NULL,
total_price DECIMAL(10,2),
FOREIGN KEY (guests_id) REFERENCES guests(id),
FOREIGN KEY (room_id) REFERENCES rooms(id)
);"
        ];

    foreach ($rebuildQuery as $query) {
        executeQuery($db, $query);
    }

    return;
}

function validateBookedDates(PDO $db): bool
{
    $dateQuery = "SELECT arrival_date FROM bookings";
    $bookedDates = queryFetchAssoc($db, $dateQuery);
    $bookedRooms = [];
    foreach ($bookedDates as $item) {
        // EXPLODE ARRIVAL_DATE STRING INTO ARRAY, THEN MERGE WITH RESULT
        $bookedRooms = array_merge($bookedRooms, explode(',', $item['arrival_date']));
    }

    //MAKE THEM INTs
    $bookedRooms = array_map('intval', $bookedRooms);

    //FETCH USER INPUT BOOKED DATES IN SAME FORMAT
    $selectedRooms = explode(",", $_POST['selectedDates']);
    $selectedRooms = array_map('intval', $selectedRooms);

    if (array_intersect($bookedRooms, $selectedRooms)) {
        return true;
    } else {
        return false;
    }
}

function printErrors()
{
    foreach ($_SESSION['error'] as $error):
?> <p><?php echo $error; ?></p>
<?php
    endforeach;
    unset($_SESSION['error']);
}

function validateTransferCode(string $transferCode, int $totalCost): array
{
    $client = new Client();

    try {
        $response = $client->post('https://www.yrgopelago.se/centralbank/transferCode', [
            'form_params' => [
                'transferCode' => $transferCode,
                'totalcost' => $totalCost
            ]
        ]);
        $data = json_decode($response->getBody()->getContents(), true);

        // Return data from API source
        if (isset($data['status']) && $data['status'] === 'success') {
            return [
                'status' => true,
                'message' => 'Transfer code is valid.',
                'data' => $data
            ];
        } else {
            return [
                'status' => false,
                'message' => 'Transfer code is invalid or insufficient funds.',
                'data' => $data
            ];
        }
    } catch (RequestException $e) {
        return [
            'status' => false,
            'message' => 'Error processing request: ' . $e->getMessage(),
            'data' => null
        ];
    }
}
