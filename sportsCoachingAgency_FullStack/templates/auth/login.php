<?php require_once __DIR__ . '/../../app/functions/csrf.php'; ?>
<?php include __DIR__ . '/../header.php'; ?>

<!-- Login Section -->
<section class="login-container">
    <aside class="login-box">
    <a href="/"><img src="/assets/img/basketballLogo.webp" alt="" /></a>
    <h2>Login</h2>
    <form action="/login/request" method="POST">
    <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">
        <p class="input-group">
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" placeholder="Enter your email" value="admin@example.com" required />
        </p>
        <p class="input-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter your password" value="password123" required />
        </p>
        <button type="submit">Login</button>
        <p class="forgot-password"><a href="/forgot-password">Forgot Password?</a> |
        <a href="/register">Register</a></p>
    </form>
    </aside>
</section>
<!-- END Admin Login Section -->

<?php include __DIR__ . '/../footer.php'; ?>
