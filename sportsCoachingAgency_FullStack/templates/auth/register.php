<?php require_once __DIR__ . '/../../app/functions/csrf.php'; ?>
<?php include __DIR__ . '/../header.php'; ?>
<h2>Register</h2>
<form action="/register/request" method="POST">
    <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">

    <label for="name">Full Name:</label>
    <input type="text" name="name" required>

    <label for="email">Email:</label>
    <input type="email" name="email" required>

    <label for="password">Password:</label>
    <input type="password" name="password" required>

    <button type="submit">Register</button>
</form>
<a href="/forgot-password">Forgot Password?</a> |
<a href="/login">Login</a>
<?php include __DIR__ . '/../footer.php'; ?>