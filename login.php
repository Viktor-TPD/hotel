<?php require __DIR__ . '/app/autoload.php'; ?>

<article>
    <h1>Login</h1>

    <?php
    if (isset($_SESSION['errors'])) {
        printErrors();
    }
    ?>

    <form action="<?= BASE_URL . '/app/users/login.php'; ?>" method="post">
        <div>
            <label for="email" class="form-label">Name</label>
            <input class="form-control" type="text" name="name" id="name" placeholder="Admin name..." required>
            <small class="form-text">Please provide your name.</small>
        </div>

        <div>
            <label for="password" class="form-label">Password</label>
            <input class="form-control" type="password" name="password" id="password" placeholder="Admin password..." required>
            <small class="form-text">Please provide your password.</small>
        </div>

        <button type="submit">Login</button>
    </form>
    <form action="<?= BASE_URL . '/index.php'; ?>">
        <small>Not where you'd like to be?</small>
        <button type="submit">Return Home</button>
    </form>
</article>