<?php require_once __DIR__ . '/../../app/functions/csrf.php'; ?>
<?php include __DIR__ . '/../header.php'; ?>

<!-- Register Section -->
<section class="login-container">
      <aside class="login-box">
        <a href="/"><img src="/assets/img/basketballLogo.webp" alt="" /></a>
        <h2>Register</h2>
        <form action="/register/request" method="POST">
        <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">
        <p class="input-group">
            <label for="name">Full Name:</label>
            <input type="text" name="name" placeholder="Enter your email" required>
        </p>
          <p class="input-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required />
          </p>
          <p class="input-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required />
          </p>
          <button type="submit">Register</button>
          <p class="login"><a href="/login">Login</a></p>
          <p class="forgot-password"><a href="/forgot-password">Forgot Password?</a></p>
        </form>
      </aside>
    </section>
    <!-- END Register Section -->
<?php include __DIR__ . '/../footer.php'; ?>