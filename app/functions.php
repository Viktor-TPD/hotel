<?php

declare(strict_types=1);

// LOAD GUZZLE :)
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

// EXECUTE QUERY
function executeQuery(PDO $db, string $query, array $parameters = [])
{
    try {
        $statement = $db->prepare($query);

        // SANITIZE INPUT
        foreach ($parameters as $key => $value) {
            $statement->bindValue($key, $value);
        }

        $statement->execute();
        // echo "Query executed successfully.\n";
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
function queryFetchAssoc(PDO $db, string $query, array $parameters = [], string $fetchAll = "all")
{
    try {
        $statement = $db->prepare($query);

        // SANITIZE INPUT
        foreach ($parameters as $key => $value) {
            $statement->bindValue($key, $value);
        }

        $statement->execute();

        // FETCH OR FETCHALL BASED ON THE $fetchAll PARAMETER
        $value = ($fetchAll === "all") ? $statement->fetchAll(PDO::FETCH_ASSOC) : $statement->fetch(PDO::FETCH_ASSOC);
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
    try {
        $tables = queryFetchAssoc($db, "SELECT name 
        FROM sqlite_master 
        WHERE type = 'table'");
        foreach ($tables as $table) {
            if ($table['name'] !== "sqlite_sequence") {
                executeQuery($db, "DROP TABLE $table[name]");
                echo $table['name'] . " dropped!<br>";
            }
        }
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
                                FOREIGN KEY (guests_id) REFERENCES guests(id)
                                );",

                "--BOOKINGS
                                CREATE TABLE IF NOT EXISTS bookings (
                                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                                    guests_id INTEGER NOT NULL,
                                    guest_name text NOT NULL,
                                    room_id INTEGER NOT NULL,
                                    room_price DECIMAL(10,2) NOT NULL,
                                    arrival_date VARCHAR(400) NOT NULL,
                                    total_price DECIMAL(10,2),
                                    FOREIGN KEY (guests_id) REFERENCES guests(id),
                                    FOREIGN KEY (room_id) REFERENCES rooms(id)
                                    );",
                "--INSERT DEFAULT ROOM DATA
                INSERT INTO rooms (type, price) VALUES ('budget', 1), ('standard', 2), ('luxury', 3);"
            ];
        foreach ($rebuildQuery as $query) {
            executeQuery($db, $query);
        }
    } catch (Exception $e) {
        $_SESSION['error'][] =  "Error: " . $e->getMessage() . "\n";
    }
    return;
}
// "INSERT INTO rooms (type, price) VALUES ('budget', 1), ('standard',2), ('luxury', 3);" //@debug

function getCurrentGuestId(PDO $db): int
{
    try {
        $query = "SELECT MAX(id) as latest_guest FROM guests;";
        $latestGuest = queryFetchAssoc($db, $query, [], "N");

        // CHECK IF IT EXISTS
        if (!isset($latestGuest['latest_guest'])) {
            throw new Exception("Failed to fetch the latest guest ID.");
        }

        return (int)$latestGuest['latest_guest'];
    } catch (Exception $e) {
        // LOG ERROR
        error_log("Error in getCurrentGuestId: " . $e->getMessage());
        return 0;
    }
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

// Deposit to centralbank
function makeDeposit(string $transferCode): bool
{
    $client = new Client();

    try {
        $response = $client->post('https://www.yrgopelago.se/centralbank/deposit', [
            'form_params' => [
                'user' => 'Viktor',
                'transferCode' => $transferCode,
            ]
        ]);
        $data = json_decode($response->getBody()->getContents(), true);

        return isset($data['status']) && $data['status'] === 'success';
    } catch (RequestException $e) {
        error_log('Error validating transfer code: ' . $e->getMessage());
        return false;
    }
}

function printErrors()
{
    foreach ($_SESSION['errors'] as $error):
?> <p><?php echo $error; ?></p>
<?php
    endforeach;
    unset($_SESSION['errors']);
}

// Validate transfercode on centralbank API (Thanks Max :))
function validateTransferCode(string $transferCode, int $totalCost): bool
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

        return isset($data['status']) && $data['status'] === 'success';
    } catch (RequestException $e) {
        error_log('Error validating transfer code: ' . $e->getMessage());
        return false;
    }
}

// VALIDATE Uuid (Thanks Hans :))
function isValidUuid(string $uuid): bool
{

    if (!is_string($uuid) || (preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/', $uuid) !== 1)) {
        return false;
    }

    return true;
}

use benhall14\phpCalendar\Calendar as Calendar;

function drawCalendar(PDO $db, string $roomChoice)
{
    // CREATE CALENDAR
    $calendar = new Calendar(2025, 1);
    $calendar->useMondayStartingDate();

    // FETCH BOOKED ROOMS
    $dateQuery = "SELECT arrival_date FROM bookings WHERE room_id = :roomChoice;";
    $bookedDates = queryFetchAssoc($db, $dateQuery, [':roomChoice' => $roomChoice]);

    // STANDARDIZE THE DATES
    $standardizedBookedDates = array_map(
        fn($bookedDate) => calendarDatesToTimeStamp($bookedDate['arrival_date']),
        $bookedDates
    );
    // FLATTEN THE DATES
    $allDates = is_array(reset($standardizedBookedDates))
        ? array_merge(...$standardizedBookedDates)
        : $standardizedBookedDates;

    foreach ($allDates as $date) {
        $calendar->addEvent(
            $date,
            $date,
            "Booked",
            true,
            ['booked']
        );
    }
    return $calendar;
}
