<?php require_once __DIR__ . '/../../app/functions/csrf.php'; ?>
<?php include __DIR__ . '/../header.php'; ?>
<form action="/password-reset" method="POST">
    <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">

    <label for="email">Email:</label>
    <input type="email" name="email" required>
    
    <button type="submit">Request Password Reset</button>
</form>
<a href="/login">Login</a> |
<a href="/register">Register</a>
<?php include __DIR__ . '/../footer.php'; ?>