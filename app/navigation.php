<article>
    <?php
    if ($_SESSION['user']['name'] === $_ENV['ADMIN_NAME']) {
    ?>
        <p>You're logged in as admin. Hello, <?= $_SESSION['user']['name']; ?></p>
        <?php
        if (basename($_SERVER['PHP_SELF']) != 'admin.php') {
        ?>
            <form action="/admin.php">
                <button type="submit">Go to Admin Page</button>
            </form>

        <?php
        }
        ?>
        <form action="/app/users/logout.php">
            <button type="submit">Logout</button>
        </form>
    <?php
    } else {
    ?>
        <a href=<?= "/login.php"; ?>>Login</a>
    <?php
    }
    ?>
</article>