<?php
require_once __DIR__ . "/autoload.php";

if (!isset($_SESSION['user'])) {
    header("HTTP/1.1 401 Unauthorized");
    echo "<h1>Unauthorized</h1>";
    echo "<p>You must be logged in to view this page. Please log in and try again.</p>";
}

require_once __DIR__ . "/header.php";
?>
<form action="index.php">
    <button type="submit">Go Home</button>
</form>
<form action="">
    <!-- @todo REBUILD DATABASE FUNCTIONALITY HERE -->
    <small>Rebuild Database</small>
</form>

<small>Current Money: </small>

<?php
require_once __DIR__ . "/footer.php";
