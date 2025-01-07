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

<!-- @todo REBUILD DATABASE FUNCTIONALITY HERE -->
<form method="POST">
    <button type="submit" id="rebuildDatabase" name="rebuildDatabase">Rebuild Database</button>
</form>


<!-- @todo ADD THIS TOO -->
<small>Current Money: </small>

<?php
require_once __DIR__ . '/app/footer.php';
