<?php require_once __DIR__ . '/../../app/functions/csrf.php'; ?>
<?php include __DIR__ . '/../header.php'; ?>
<h2>Login</h2>
<form action="/login/request" method="POST">
    <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">
    
    <label for="email">Email:</label>
    <input type="email" name="email" value="john@example.com" required>
    
    <label for="password">Password:</label>
    <input type="password" name="password" value="password123" required>
    
    <button type="submit">Login</button>
</form>
<a href="/forgot-password">Forgot Password?</a> |
<a href="/register">Register</a>
<?php include __DIR__ . '/../footer.php'; ?>
