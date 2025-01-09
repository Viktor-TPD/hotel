<?php
require_once __DIR__ . "/app/autoload.php";

if (!isset($_SESSION['user'])) {
    header("HTTP/1.1 401 Unauthorized");
    echo "<h1>Unauthorized</h1>";
    echo "<p>You must be logged in to view this page. Please log in and try again.</p>";
?>
    <form action="index.php">
        <button type="submit">Go Home</button>
    </form>
<?php

    exit();
}

// Get prices from rooms
$query = $db->query("SELECT id, type, price FROM rooms");
$rooms = $query->fetchAll(PDO::FETCH_ASSOC);

require_once __DIR__ . "/app/header.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rebuildDatabase'])) {
    echo "Database rebuilt!";
    rebuildDataBase($db);
    unset($_POST['rebuildDatabase']);
}
?>
<form action="index.php">
    <button type="submit">Go Home</button>
</form>

<!-- REBULD DATABASE -->
<form method="POST">
    <button type="submit" id="rebuildDatabase" name="rebuildDatabase">Rebuild Database</button>
</form>

<form id="adminDashboard" method="POST" action=" <?= BASE_URL . '/app/posts/update.php'; ?>">
    <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
        <p class="success-message">Updates saved successfully!</p>
    <?php endif; ?>

    <!-- Update Room Prices -->
    <fieldset>
        <legend>Update Room Prices</legend>
        <?php
        $i = 1;
        foreach ($rooms as $room): ?>
            <div class="form-group">
                <label for="room_price_<?= $room['id'] ?>">
                    <?= "room " .  $i ?> - Current Price: $<?= $room['price'] ?>
                </label>
                <input type="number" id="room_price_<?= $room['id'] ?>" name="room_prices[<?= $room['id'] ?>]" value="<?= $room['price'] ?>" required>
            </div>
        <?php
            $i++;
        endforeach; ?>
    </fieldset>
    <button type="submit">Update Prices</button>
</form>

<?php
require_once __DIR__ . '/app/footer.php';
