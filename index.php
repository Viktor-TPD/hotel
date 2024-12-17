<?php

require_once __DIR__ . '/app/autoload.php';
require_once __DIR__ . '/app/header.php';

use benhall14\phpCalendar\Calendar as Calendar;

$calendar = new Calendar(2025, 1);
$calendar->useMondayStartingDate();

$rooms = queryFetchAssoc($db, "SELECT * FROM rooms;");
// var_dump($rooms);
// echo "<pre>";
// var_dump($_POST); //@debug
// echo "</pre>";

$bookings = queryFetchAssoc($db, "SELECT * FROM bookings;");
// var_dump($bookings);
$myDate = $bookings[0]['arrival_date'];
$myDate = gmdate("Y-m-d", $myDate);
echo $myDate;

?>
<main>
    <form method="post" action='./app/posts/store.php'>

        <div>
            <label for="name">Name</label>
            <input id="name" type="text" name="name" placeholder="Enter your name..." required>
        </div>
        <div class="flexRow">
            <small>Selected dates:&nbsp</small>
            <input id="selectedDatesContainer" class="uninteractable" type="text" name="selectedDates" required></input>
        </div>
        <div class="flexRow">
            <small>Selected Room:&nbsp</small>
            <input id="roomType" class="uninteractable" type="text" name="roomType" value="<?= $rooms[0]["type"] ?>"></input>
        </div>
        <button type="submit">Book!</button>

    </form>

    </div>
</main>
<?php
echo $calendar->draw(date('2025-01-01'));

require_once __DIR__ . '/app/footer.php';
