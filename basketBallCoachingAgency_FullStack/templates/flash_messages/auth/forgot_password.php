<!-- ################### SUCCESS ################### -->
<!-- password_reset_email_sent -->
<?php if (isset($_GET['success']) && $_GET['success'] == 'password_reset_email_sent'): ?>
    <div class="alert alert-success">
        ✅ Check your inbox. Your password reset link has been sent!
    </div>
<?php endif; ?>

<!-- ################### ERRORS ################### -->
<!-- invalid_csrf_token -->
<?php if (isset($_GET['error']) && $_GET['error'] == 'invalid_csrf_token'): ?>
    <div class="alert alert-danger">
        ❌ Invalid CSRF token. Please refresh the page and try again.
    </div>
<?php endif; ?>
<!-- invalid_email -->
<?php if (isset($_GET['error']) && $_GET['error'] == 'invalid_email'): ?>
    <div class="alert alert-danger">
        ❌ Invalid email address. Please try again.
    </div>
<?php endif; ?>
<!-- system_error_file_not_found -->
<?php if (isset($_GET['error']) && $_GET['error'] == 'system_error_file_not_found'): ?>
    <div class="alert alert-danger">
        ❌ System error: required file not found. Please contact support.
    </div>
<?php endif; ?>
<!-- system_emailing_error -->
<?php if (isset($_GET['error']) && $_GET['error'] == 'system_emailing_error'): ?>
    <div class="alert alert-danger">
        ❌ System error: unable to send email. Please try again later.
    </div>
<?php endif; ?>