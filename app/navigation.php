<article>
    <?php
    if ($_SESSION['user']['name'] === "viktor") { //@todo MAKE THIS CHECK THE .env FILE FOR LIST OF ADMINS
    ?>
        <p>You're logged in as admin. Hello, <?= $_SESSION['user']['name']; ?></p>
        <form action="./app/admin.php">
            <button type="submit">Go to Admin Page</button>
        </form>
        <form action="./app/users/logout.php">
            <button type="submit">Logout</button>
        </form>
    <?php
    } else {
    ?>
        <a href="./login.php">Login</a>
    <?php
    }
    ?>
</article>