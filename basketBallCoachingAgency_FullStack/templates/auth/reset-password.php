<?php require_once __DIR__ . '/../../app/functions/csrf.php'; ?>
<?php require_once __DIR__ . '/../header.php'; ?>

<section class="login-container">
    <aside class="login-box">
        <a href="/"><img src="img/basketballLogo.webp" alt="site logo" /></a>
        <h2>Update Password</h2>
        <form action="/reset-password/request" method="POST">
            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
            <label for="password">New Password:</label>
            <input type="password" name="password" required>
            <button type="submit">Update Password</button>
        </form>
        <p>Remembered your password? <a href="/login">Login</a></p>
    </aside>
</section>
 
<?php require_once __DIR__ . '/../flash_messages/auth/reset_password.php' ?>
<?php require_once __DIR__ . '/../footer.php'; ?>