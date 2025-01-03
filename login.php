<?php require __DIR__ . '/app/autoload.php'; ?>

<article>
    <h1>Login</h1>

    <?php
    if (isset($_SESSION['error'])) {
        foreach ($_SESSION['error'] as $error):
            echo $error; //@todo MAKE PRETTIER
        endforeach;
        $_SESSION['error'] = [];
    }
    ?>

    <form action="app/users/login.php" method="post">
        <div>
            <label for="email" class="form-label">Email</label>
            <input class="form-control" type="email" name="email" id="email" placeholder="example@email.com" required>
            <small class="form-text">Please provide the your email address.</small>
        </div>

        <div>
            <label for="password" class="form-label">Password</label>
            <input class="form-control" type="password" name="password" id="password" required>
            <small class="form-text">Please provide the your password (passphrase).</small>
        </div>

        <button type="submit">Login</button>
    </form>
    <form action="index.php">
        <small>Not where you'd like to be?</small>
        <button type="submit">Return Home</button>
    </form>
</article>