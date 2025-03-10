<?php require_once __DIR__ . '/../../app/functions/csrf.php'; ?>
<?php include __DIR__ . '/../header.php'; ?>
<h2>Forgot Password</h2>
<form action="/forgot-password/request" method="POST">
    <label for="email">Enter your email:</label>
    <input type="email" name="email" required>
    <button type="submit">Send Reset Link</button>
</form>
<a href="/login">Login</a> |
<a href="/register">Register</a>
<?php include __DIR__ . '/../footer.php'; ?>