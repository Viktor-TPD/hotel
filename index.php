<?php

require_once __DIR__ . '/app/autoload.php';
require_once __DIR__ . '/app/header.php';

?>
<main>
    <!-- SESSION/POST CHECKS -->
    <?php
    if (isset($_SESSION['openReceipt'])) {
        unset($_SESSION['openReceipt']);
    ?>
        <script type="text/javascript">
            const win = window.open('./app/posts/receipt.php', '_blank');
            win.focus();
        </script>
    <?php
    }

    if (isset($_POST['errors'])) {
        printErrors();
    }
    $rooms[0]["type"] = "budget"; //@todo TEMP VALUE
    ?>
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
        <div class="flexRow">
            <small>Transfer code:&nbsp</small>
            <a href="https://www.yrgopelago.se/centralbank/start.php">Generate code here</a>
            <input id="transferCode" type="text" name="transferCode" placeholder="Enter transfer code here..."></input>
        </div>

        <button type="submit">Book!</button>

    </form>

    </div>
</main>
<?php
echo $calendar->draw(date('2025-01-01'));

require_once __DIR__ . '/app/footer.php';
