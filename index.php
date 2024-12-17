<?php

declare(strict_types=1);
require_once __DIR__ . '/app/autoload.php';
require_once __DIR__ . '/app/header.php';

use benhall14\phpCalendar\Calendar as Calendar;

$calendar = new Calendar(2025, 1);
$calendar->useMondayStartingDate();
// $calendar->stylesheet();

?>

<body>
    <main>
        <div>
            <label for="name">Name</label>
            <input type="text" name="name" id="name" placeholder="Enter your name...">
        </div>
        <div class="formSelectedDates">
            <small>Selected dates...</small>
            <small id="showSelectedDates"></small>
        </div>
    </main>
    <?php
    echo $calendar->draw(date('2025-01-01'));
    ?>
</body>

<script src="./assets/scripts/app.js"></script>

</html>
<?php
// @todo ADD FOOTER