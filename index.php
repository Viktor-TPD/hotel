<?php

declare(strict_types=1);
require_once __DIR__ . '/app/autoload.php';
require_once __DIR__ . '/app/header.php';

use benhall14\phpCalendar\Calendar as Calendar;

// (new Calendar)->display();
$calendar = new Calendar(2025, 1);
$calendar->useMondayStartingDate();
$calendar->stylesheet();

?>

<body>
    <?php
    echo $calendar->draw(date('2025-01-01'));
    ?>
</body>

</html>
<?php
// @todo ADD FOOTER