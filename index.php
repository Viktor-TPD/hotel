<?php

require_once __DIR__ . '/app/autoload.php';
require_once __DIR__ . '/app/header.php';

if (!empty($_SESSION['openReceipt']) && isset($_SESSION['openReceipt'])) {
?>
    <script type="text/javascript">
        const win = window.open('./app/posts/receipt.php');
    </script>
<?php
}

// ROOM NAMES
$roomNames = [
    'budget' => "WANDA'S DUNGEON",
    'standard' => "SEJDELN'S IMPORIUM",
    'luxury' => "FIT FOR A KING'S HEAD"
];

?>

<main>
    <article class="bgImage">
        <img src="<?= BASE_URL . '/assets/images/hero.webp'; ?>" id="parallaxImage" alt="">
    </article>
    <h1 class="heroHeadline">WELCOME TO SECOND LONG ISLAND</h1>
    <article class="hero flexRow">
        <div class="textRight">
            <h1>FOR DEGENERATES, VAGRANTS, AND YOU</h1>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quam, mollitia incidunt quaerat vel minima accusantium
                ad totam earum odio, quas repellendus iusto rerum consequatur adipisci saepe autem pariatur, praesentium nemo?</p>
        </div>
        <aside>
            <img src="" alt="">
        </aside>
    </article>
    <hr>
    <article class="hero flexRow">
        <aside>
            <img src="" alt="">
        </aside>
        <div class="textLeft">
            <h1>DEBAUCHERY FOR YOU AND THE ONES YOU LOVE</h1>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quam, mollitia incidunt quaerat vel minima accusantium
                ad totam earum odio, quas repellendus iusto rerum consequatur adipisci saepe autem pariatur, praesentium nemo?</p>
        </div>
    </article>
    <hr>
    <form method="post" action="#radioButtons" id="radioButtons">
        <article class="ctaContainer">
            <div class="flexRow cta">
                <section>
                    <label>
                        <p class="overlayText">Click to select</p>
                        <input class="hideMe" type="radio" name="room_choice" value="budget">
                        <h2><?= $roomNames['budget']; ?></h2>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta doloremque ab consequatur sequi autem temporibus nisi architecto. Voluptate temporibus nihil doloribus doloremque ratione dolorem placeat consequuntur reiciendis fugit! Nesciunt, ut.</p>
                    </label>
                </section>
                <section>
                    <label>
                        <p class="overlayText">Click to select</p>
                        <input class="hideMe" type="radio" name="room_choice" value="standard">
                        <h2><?= $roomNames['standard']; ?></h2>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta doloremque ab consequatur sequi autem temporibus nisi architecto. Voluptate temporibus nihil doloribus doloremque ratione dolorem placeat consequuntur reiciendis fugit! Nesciunt, ut.</p>
                    </label>
                </section>
                <section>
                    <label>
                        <p class="overlayText">Click to select</p>
                        <input class="hideMe" type="radio" name="room_choice" value="luxury">
                        <h2><?= $roomNames['luxury']; ?></h2>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta doloremque ab consequatur sequi autem temporibus nisi architecto. Voluptate temporibus nihil doloribus doloremque ratione dolorem placeat consequuntur reiciendis fugit! Nesciunt, ut.</p>
                    </label>
                </section>
            </div>
            <button type="submit">Check availability</button>
        </article>
    </form>
    <?php
    // PRINT ERRORS IF THERE ARE ANY
    if (isset($_SESSION['errors'])) {
    ?>
        <div class="errorContainer flexColumn">
            <?php
            printErrors();
            ?>
        </div>
    <?php
    }
    ?>
    </div>
</main>
<?php
if (isset($_POST['room_choice'])) {
    $roomChoice = $_POST["room_choice"];
?>
    <article class="calendarContainer">
        <form method="post" action='./app/posts/store.php'>
            <h2 class="textCenter">Booking a room at <?= $roomNames[$roomChoice] ?></h2>
            <div class="flexRow">
                <label for="name">Name:</label>
                <input id="name" type="text" name="name" placeholder="Enter your name..." required>
            </div>
            <div class="flexRow">
                <a href="https://www.yrgopelago.se/centralbank/start.php">Transfer Code:</a>
                <input id="transferCode" type="text" name="transferCode" placeholder="Enter transfer code here..."></input>
            </div>
            <div class="flexRow">
                <!-- @bug KNOWN ISSUE: SELECTING MORE THAN 10 DATES LOOKS BAD; IT CLIPS. SOLVE THIS. -->
                <small>Selected dates:</small>
                <input id="selectedDatesContainer" class="uninteractable" type="text" name="selectedDates" required></input>
            </div>
            <div class="flexRow">
                <small>Room price class:</small>
                <input id="roomType" class="uninteractable" type="text" name="roomType" value="<?= $roomChoice ?>"></input>
            </div>
            <div class="flexRow">
                <small>Total price:</small>
                <p id="totalPrice"><!--TOTAL PRICE GOES HERE --></p>
            </div>


            <button type="submit">Book!</button>

        </form>
        <?php
        $calendar = drawCalendar($db, $roomChoice);
        echo $calendar->draw(date('2025-01-01'));
        ?>
    </article>
<?php
}

if (isset($_SESSION['openReceipt'])) {
?>
    <article class="bookingConfirmContainer">
        <img src="<?= $_SESSION['receipt']['additional_info']['imageUrl'] ?>" alt="Actor Simon Pegg raises his glass in an English pub. The camera zooms in and he winks at you.">
        <div>
            <p class="bookingConfirm"><?= $_SESSION['receipt']['additional_info']['greeting'] ?></p>
            <p class="bookingConfirm"><?= $_SESSION['receipt']['additional_info']['totalDays'] ?></p>
            <p class="bookingConfirm">We've opened a new tab with your receipt.</p>
        </div>
    </article>
<?php
    unset($_SESSION['openReceipt']);
}
require_once __DIR__ . '/app/footer.php';
