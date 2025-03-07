<?php require_once __DIR__ . '/../../app/functions/csrf.php'; ?>
<?php include __DIR__ . '/../header.php'; ?>

<form action="/register" method="POST">
    <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">

    <label for="first-name">First Name:</label>
    <input type="text" name="first-name">

    <label for="last-name">Last Name:</label>
    <input type="text" name="last-name">
    
    <label for="email">Email:</label>
    <input type="email" name="email" required>
    
    <label for="password">Password:</label>
    <input type="password" name="password" required>
    
    <button type="submit">Register New Account</button>
</form>
<?php include __DIR__ . '/../footer.php'; ?>