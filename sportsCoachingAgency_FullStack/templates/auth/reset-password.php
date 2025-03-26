<?php require_once __DIR__ . '/../../app/functions/csrf.php'; ?>
<?php include __DIR__ . '/../header.php'; ?>

<!-- Login Section -->
<section class="login-container">
    <aside class="login-box">
    <a href="/"><img src="img/basketballLogo.webp" alt="" /></a>
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
<!-- END Admin Login Section -->

<?php include __DIR__ . '/../footer.php'; ?>