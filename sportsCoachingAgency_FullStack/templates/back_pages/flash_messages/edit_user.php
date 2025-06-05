<!-- SUCCESS -->
<?php if (isset($_GET['success']) && $_GET['success'] == 'account_verified'): ?>
    <div class="alert alert-info">
    <p>✅ Your account has been confirmed. You can now login.</p>
    </div>
<?php endif; ?>

<?php if (isset($_GET['success']) && $_GET['success'] == 'subscription_already_verified'): ?>
    <div class="alert alert-success">
        ✅ Your subscription is already verified.
    </div>
<?php endif; ?>

<?php if (isset($_GET['pending']) && $_GET['pending'] == 'true'): ?>
    <div class="alert alert-info">
    <p>Subscription pending. ✅ A confirmation email has been sent. Please check your inbox.</p>
    </div>
<?php endif; ?>

<?php if (isset($_GET['pending']) && $_GET['pending'] == 'confirmation_email_sent'): ?>
    <div class="alert alert-success">
        ✅ Confirmation email sent. Please check your inbox.
    </div>
<?php endif; ?>

<?php if (isset($_GET['confirmed']) && $_GET['confirmed'] == 'true'): ?>
    <div class="alert alert-success">
        Subscription confirmed. Thank you for subscribing!
    </div>
<?php endif; ?>

<?php if (isset($_GET['confirmed']) && $_GET['confirmed'] == 'already_confirmed'): ?>
    <div class="alert alert-success">
        ✅ Your email is already verified. You can <a href='/login'>login</a>.
    </div>
<?php endif; ?>

<?php if (isset($_GET['success']) && $_GET['success'] == 'password_reset_email_sent'): ?>
    <div class="alert alert-success">
        Check your inbox. Your password reset link has been sent!
    </div>
<?php endif; ?>

<?php if (isset($_GET['confirmation']) && $_GET['confirmation'] == 'resent'): ?>
    <div class="alert alert-success">
        ✅ Verification email resent! Please check your inbox.
    </div>
<?php endif; ?>

<?php if (isset($_GET['success']) && $_GET['success'] == 'password_reset_successful'): ?>
    <div class="alert alert-success">
        ✅ Password reset successful! You can now <a href='/login'>login</a>.
    </div>
<?php endif; ?>

<?php if (isset($_GET['success']) && $_GET['success'] == 'message_sent'): ?>
    <div class="alert alert-success">
        ✅ Your message has been sent successfully! We will get back to you soon.
    </div>
<?php endif; ?>

<?php if (isset($_GET['success']) && $_GET['success'] == 'profile_updated'): ?>
    <div class="alert alert-success">
        ✅ Your profile has been updated successfully!
    </div>
<?php endif; ?>

<?php if (isset($_GET['success']) && $_GET['success'] == 'password_changed'): ?>
    <div class="alert alert-success">
        ✅ Your password has been changed successfully!
    </div>
<?php endif; ?>

<?php if (isset($_GET['success']) && $_GET['success'] == 'site_updated'): ?>
    <div class="alert alert-success">
        ✅ Site settings updated successfully!
    </div>
<?php endif; ?>

<?php if (isset($_GET['success']) && $_GET['success'] == 'social_media_updated'): ?>
    <div class="alert alert-success">
        ✅ Social media settings updated successfully!
    </div>
<?php endif; ?>

<?php if (isset($_GET['success']) && $_GET['success'] == 'home_page_updated'): ?>
    <div class="alert alert-success">
        ✅ Home page settings updated successfully!
    </div>
<?php endif; ?>

<?php if (isset($_GET['success']) && $_GET['success'] == 'subscriber_deleted'): ?>
    <div class="alert alert-success">
        ✅ Subscriber deleted successfully!
    </div>
<?php endif; ?>
<!-- END SUCCESS -->

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

<!-- invalid_request -->
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

<?php if (isset($_GET['error']) && isset($_GET['email']) && $_GET['error'] == 'user_not_verified'): ?>
    <div class="alert alert-danger">
        ❌ Please verify your email before logging in.
        <br><a href='/resend-verification?email=<?php urlencode($_GET['email']); ?>'>Resend Verification Email</a>
        <br><a href='/login'>Back to Login</a>";
    </div>
<?php endif; ?>

<?php if (isset($_GET['error']) && $_GET['error'] == 'message_failed'): ?>
    <div class="alert alert-danger">
        Message failed to send. Please try again later.
    </div>
<?php endif; ?>

<?php if (isset($_GET['error']) && $_GET['error'] == 'empty_fields'): ?>
    <div class="alert alert-danger">
        Please fill in all fields and try again.
    </div>
<?php endif; ?>

<?php if (isset($_GET['error']) && $_GET['error'] == 'email_taken'): ?>
    <div class="alert alert-danger">
        Email is associated with another account. Please use a different email or contact support.
    </div>
<?php endif; ?>

<?php if (isset($_GET['error']) && $_GET['error'] == 'invalid_file_type'): ?>
    <div class="alert alert-danger">
        Invalid file type. Please upload a valid image file (jpg, jpeg, png, gif).
    </div>
<?php endif; ?>

<?php if (isset($_GET['error']) && $_GET['error'] == 'file_too_large'): ?>
    <div class="alert alert-danger">
        Invalid file type. Please upload a valid image file (jpg, jpeg, png, gif).
    </div>
<?php endif; ?>

<?php if (isset($_GET['error']) && $_GET['error'] == 'upload_fail'): ?>
    <div class="alert alert-danger">
        Failed to upload the file. Please try again.
    </div>
<?php endif; ?>

<?php if (isset($_GET['error']) && $_GET['error'] == 'passwords_mismatch'): ?>
    <div class="alert alert-danger">
        Passwords do not match. Please try again.
    </div>
<?php endif; ?>

<?php if (isset($_GET['error']) && $_GET['error'] == 'password_too_short'): ?>
    <div class="alert alert-danger">
        Password must be at least 6 characters long.
    </div>
<?php endif; ?>

<?php if (isset($_GET['error']) && $_GET['error'] == 'incorrect_password'): ?>
    <div class="alert alert-danger">
        Incorrect current password. Please try again.
    </div>
<?php endif; ?>

<?php if (isset($_GET['error']) && $_GET['error'] == 'email_failed'): ?>
    <div class="alert alert-danger">
        Action failed. Please try again later.
    </div>
<?php endif; ?>