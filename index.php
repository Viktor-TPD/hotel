<?php

require_once __DIR__ . '/app/autoload.php';
require_once __DIR__ . '/app/header.php';

use benhall14\phpCalendar\Calendar as Calendar;

$calendar = new Calendar(2025, 1);
$calendar->useMondayStartingDate();

$rooms = queryFetchAssoc($db, "SELECT * FROM rooms;");
// var_dump($rooms);
echo $rooms[0]['type'];
?>


<main>
    <div>
        <label for="name">Name</label>
        <input type="text" name="name" id="name" placeholder="Enter your name...">
    </div>
    <div class="flexRow">
        <small>Selected dates:&nbsp</small>
        <small id="selectedDatesContainer"></small>
    </div>
    <div class="flexRow">
        <small>Selected Room:&nbsp</small>
        <small><?= $rooms[0]["type"] ?></small>
    </div>
</main>
<?php
echo $calendar->draw(date('2025-01-01'));

require_once __DIR__ . '/app/footer.php';
