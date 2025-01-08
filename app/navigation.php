<nav class="flexRow">
    <p>Second Long Island</p>
    <div class="flexRow">
        <?php
        if (isset($_SESSION['user']['name']) && $_SESSION['user']['name'] === $_ENV['ADMIN_NAME']) {
        ?>
            <p>You're logged in as admin. Hello, <?= $_SESSION['user']['name']; ?></p>
            <?php
            if (basename($_SERVER['PHP_SELF']) != 'admin.php') {
            ?>
                <form action="<?= BASE_URL . '/../admin.php'; ?>">
                    <button type="submit">Go to Admin Page</button>
                </form>

            <?php
            }
            ?>
            <form action="<?= BASE_URL . '/app/users/logout.php'; ?>">
                <button type="submit">Logout</button>
            </form>
        <?php
        } else {
        ?>
            <a href="<?= BASE_URL . '/login.php'; ?>">Login</a>
        <?php
        }
        ?>
    </div>
</nav>