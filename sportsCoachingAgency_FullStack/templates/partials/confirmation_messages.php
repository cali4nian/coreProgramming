<!-- SUCCESS -->
<?php if (isset($_GET['pending']) && $_GET['pending'] == 'true'): ?>
    <div class="alert alert-info">
    <p>Subscription pending. ✅ A confirmation email has been sent. Please check your inbox.</p>
    </div>
<?php endif; ?>

<?php if (isset($_GET['confirmed']) && $_GET['confirmed'] == 'true'): ?>
    <div class="alert alert-success">
        Subscription confirmed. Thank you for subscribing!
    </div>
<?php endif; ?>

<?php if (isset($_GET['success']) && $_GET['success'] == 'password_reset_email_sent'): ?>
    <div class="alert alert-success">
        Check your inbox. Your password reset link has been sent!
    </div>
<?php endif; ?>

<!-- ERRORS -->
<?php if (isset($_GET['error']) && $_GET['error'] == 'invalid_email'): ?>
    <div class="alert alert-danger">
        Invalid email address. Please try again.
    </div>
<?php endif; ?>

<?php if (isset($_GET['error']) && $_GET['error'] == 'not_found'): ?>
    <div class="alert alert-danger">
        Email not found. Please try again.
    </div>
<?php endif; ?>

<?php if (isset($_GET['error']) && $_GET['error'] == 'emailing_error'): ?>
    <div class="alert alert-danger">
        Error when sending email. Try again later.
    </div>
<?php endif; ?>

<?php if (isset($_GET['error']) && $_GET['error'] == 'invalid_request'): ?>
    <div class="alert alert-danger">
        Refresh web browser, clear browser cache, or try again later.
    </div>
<?php endif; ?>

<?php if (isset($_GET['error']) && $_GET['error'] == 'email_or_password_empty'): ?>
    <div class="alert alert-danger">
        You must provide an email and password.
    </div>
<?php endif; ?>

<?php if (isset($_GET['error']) && $_GET['error'] == 'invalid_email_or_password'): ?>
    <div class="alert alert-danger">
        You must provide a valid email and password.
    </div>
<?php endif; ?>

<?php if (isset($_GET['error']) && $_GET['error'] == 'user_not_verified'): ?>
    <div class="alert alert-danger">
        ❌ Please verify your email before logging in.
        <br><a href='/resend-verification?email=<?php urlencode($_GET['email']); ?>'>Resend Verification Email</a>
        <br><a href='/login'>Back to Login</a>";
    </div>
<?php endif; ?>