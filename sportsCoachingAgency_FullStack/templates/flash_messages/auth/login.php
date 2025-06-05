<!-- #################### SUCCESS #################### -->
<!-- account_confirmed -->
<?php if (isset($_GET['success']) && $_GET['success'] == 'account_confirmed'): ?>
    <div class="alert alert-success">
      ✅ Your account has been confirmed. You can now login.
    </div>
<?php endif; ?>
<!-- confirmation_email_sent -->
<?php if (isset($_GET['success']) && $_GET['success'] == 'confirmation_email_sent'): ?>
    <div class="alert alert-success">
      ✅ A confirmation email has been sent. Please check your inbox.
    </div>
<?php endif; ?>

<!-- #################### ERROR #################### -->
<!-- invalid_request -->
<?php if (isset($_GET['error']) && $_GET['error'] == 'invalid_request'): ?>
    <div class="alert alert-danger">
      ❌ Invalid request. Please try again.
    </div>
<?php endif; ?>
<!-- too_many_attempts -->
<?php if (isset($_GET['error']) && $_GET['error'] == 'too_many_attempts'): ?>
    <div class="alert alert-danger">
      ❌ Too many login attempts. Please try again later.
    </div>
<?php endif; ?>
<!-- email_or_password_empty -->
<?php if (isset($_GET['error']) && $_GET['error'] == 'email_or_password_empty'): ?>
    <div class="alert alert-danger">
      ❌ Please enter both email and password.
    </div>
<?php endif; ?>
<!-- user_not_verified -->
<?php if (isset($_GET['error']) && isset($_GET['email']) && $_GET['error'] == 'user_not_verified'): ?>
    <div class="alert alert-danger">
      ❌ Your account is not verified. Please check your email (<?= htmlspecialchars($_GET['email']) ?>) for the verification link.
    </div>
<?php endif; ?>
<!-- invalid_email_or_password -->
<?php if (isset($_GET['error']) && $_GET['error'] == 'invalid_email_or_password'): ?>
    <div class="alert alert-danger">
      ❌ Invalid email or password. Please try again.
    </div>
<?php endif; ?>
<!-- invalid_email -->
<?php if (isset($_GET['error']) && $_GET['error'] == 'invalid_email'): ?>
    <div class="alert alert-danger">
      ❌ Invalid email address. Please try again.
    </div>
<?php endif; ?>
<!-- not_found -->
<?php if (isset($_GET['error']) && $_GET['error'] == 'not_found'): ?>
    <div class="alert alert-danger">
      ❌ Email not found. Please try again.
    </div>
<?php endif; ?>
<!-- system_emailing_error -->
<?php if (isset($_GET['error']) && $_GET['error'] == 'system_emailing_error'): ?>
    <div class="alert alert-danger">
      ❌ System error while sending email. Please try again later.
    </div>
<?php endif; ?>