<?php include __DIR__ . '/../header.php'; ?>
<section class="login-container">
    <aside class="login-box">
    <a href="/"><img src="img/basketballLogo.webp" alt="" /></a>
    <aside id="email-form-content">
        <h2>Forgot Password</h2>
        <form action="/forgot-password/request" method="POST">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>" />
        <p class="input-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required />
        </p>
        <button type="submit">Send Reset Link</button>
        </form>
    </aside>
    <p class="login"><a href="/login">Login</a></p>
    </aside>
</section>
<?php include __DIR__ . '/../footer.php'; ?>