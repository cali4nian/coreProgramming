<?php require_once __DIR__ . '/../../app/functions/csrf.php'; ?>
<?php include __DIR__ . '/../header.php'; ?>
<h2>Reset Password</h2>
<form action="/reset-password/request" method="POST">
    <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">
    <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">

    <label for="password">New Password:</label>
    <input type="password" name="password" required>

    <button type="submit">Reset Password</button>
</form>
<?php include __DIR__ . '/../footer.php'; ?>