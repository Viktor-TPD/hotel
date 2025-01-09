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
            <p class="textJustify">
                On Andra Långgatan, where the air is thick with cigarette smoke and regret, we offer a place that’s
                less a hotel and more a survival test with pillows. The walls? Thin enough to hear the guy next
                door arguing with his soon-to-be ex. Our lobbies? A minimalist masterpiece featuring a vending machine
                that probably has a soul. And the staff? Let’s just say they’ve seen it all and would rather not see you.
                It’s not about comfort—it’s about proximity to the pub that might ruin your life tonight.
                You’ll leave poorer, hungover, and questioning your choices. Just like everyone else here.</p>
        </div>
        <aside>
            <img src="<?= BASE_URL . '/assets/images/aside1.jpg'; ?>" alt="">
        </aside>
    </article>
    <hr>
    <article class="hero flexRow">
        <aside>
            <img src="<?= BASE_URL . '/assets/images/aside2.jpg'; ?>" alt="">
        </aside>
        <div class="textLeft">
            <h1>DEBAUCHERY FOR YOU AND THE ONES YOU LOVE</h1>
            <p class="textJustify">
                Bring the whole crew—or at least the ones who can hold their liquor and won’t embarrass you too much.
                This joint is tailor-made for chaos in numbers: bachelor parties, divorce celebrations, or whatever
                excuse you need to drink yourself stupid while someone films it. The rooms are big enough to fit
                your poor decisions, and the bar downstairs doesn’t even pretend to cut you off. Got a family reunion?
                Perfect. Nothing bonds you with Aunt Karen quite like watching her challenge a stranger to a tequila-off.
                Here, debauchery isn’t just encouraged—it’s practically mandatory.</p>
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
                        <p class="textJustify">
                            Underneath the strip club where dreams go to die and dignity is a mere suggestion, we offer
                            accommodations for those who aren’t faint of heart—or blessed with better options.
                            Here, you can sip on our wildly overpriced, alcohol-free beer while reflecting on every
                            life choice that led you to this exact moment. And don’t worry, the shame is
                            complimentary—just like the view of the alley out back where someone is definitely
                            losing a fight with a trash can. You didn’t come here for luxury; you came here because
                            you were curious. Shame on you.
                        </p>
                    </label>
                </section>
                <section>
                    <label>
                        <p class="overlayText">Click to select</p>
                        <input class="hideMe" type="radio" name="room_choice" value="standard">
                        <h2><?= $roomNames['standard']; ?></h2>
                        <p class="textJustify">
                            Don’t let the atmosphere fool you—this is a haven where hardened criminals perfect their
                            cloak-and-dagger routine and degenerate gamblers double down on their kid’s college fund
                            for one more shot at Grodjakten glory. The clientele is a rogues’ gallery of questionable
                            morals and worse judgment, but hey, that’s part of the charm.
                            But for those brave (or reckless) enough to stay a night or two, the rewards are
                            undeniable: unforgettable memories, dubious camaraderies, and stories you’ll never be
                            able to tell in polite company. Thrilling, isn’t it?
                        </p>
                    </label>
                </section>
                <section>
                    <label>
                        <p class="overlayText">Click to select</p>
                        <input class="hideMe" type="radio" name="room_choice" value="luxury">
                        <h2><?= $roomNames['luxury']; ?></h2>
                        <p class="textJustify">
                            So, you want the fancy stuff? Sure, we’ve got the fancy stuff. Order a beer, and we’ll even
                            throw in a buffet—just don’t ask too many questions about the corn. Word is, something
                            happened to the corn. This fine establishment attracts a delightful mix of students too
                            broke to care, vagrants riding out the storm, and folks whose luck ran out
                            somewhere after the poliskravallerna of 2001. You’ll fit right in, whether you’re here for the questionable
                            cuisine, the ambiance that smells faintly of regret, or just to remind yourself that
                            rock bottom can still have a happy hour. Cheers to that!
                        </p>
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
