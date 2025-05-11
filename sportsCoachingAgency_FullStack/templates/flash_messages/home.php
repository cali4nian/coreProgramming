<!-- SUCCESS -->
<!-- subscription_pending -->
<?php if (isset($_GET['success']) && $_GET['success'] == 'subscription_pending'): ?>
    <aside class="alert alert-danger">
        ✅ Subscription is pending. Please check your inbox for the confirmation email.
    </aside>
<?php endif; ?>

<!-- confirmation_email_sent -->
<?php if (isset($_GET['pending']) && $_GET['pending'] == 'confirmation_email_sent'): ?>
    <aside class="alert alert-success">
        ✅ Confirmation email sent. Please check your inbox.
    </aside>
<?php endif; ?>

<!-- ERRORS -->
<!-- invalid_email -->
<?php if (isset($_GET['error']) && $_GET['error'] == 'invalid_email'): ?>
    <aside class="alert alert-danger">
        ❌ Invalid email address. Please try again.
    </aside>
<?php endif; ?>

<!-- not_found -->
<?php if (isset($_GET['error']) && $_GET['error'] == 'not_found'): ?>
    <aside class="alert alert-danger">
        ❌ Email not found. Please try again.
    </aside>
<?php endif; ?>

<!-- invalid_request -->
<?php if (isset($_GET['error']) && $_GET['error'] == 'invalid_request'): ?>
    <aside class="alert alert-danger">
        ❌ Refresh web browser, clear browser cache, or try again later.
    </aside>
<?php endif; ?>

<!-- email_failed -->
<?php if (isset($_GET['error']) && $_GET['error'] == 'email_failed'): ?>
    <aside class="alert alert-danger">
        ❌ Action failed. Please try again later.
    </aside>
<?php endif; ?>

<!-- subscriber_already_verified -->
<?php if (isset($_GET['error']) && $_GET['error'] == 'subscriber_already_verified'): ?>
    <aside class="alert alert-danger">
        ❌ Your email is already verified. Please check your inbox for the confirmation email.
    </aside>
<?php endif; ?>

<!-- invalid_request -->
<?php if (isset($_GET['error']) && $_GET['error'] == 'invalid_request'): ?>
    <aside class="alert alert-danger">
        ❌ Invalid request. Please try again later.
    </aside>
<?php endif; ?>

<!-- subscriber_already_verified -->
<?php if (isset($_GET['error']) && $_GET['error'] == 'subscriber_already_verified'): ?>
    <aside class="alert alert-danger">
        ❌ You are already subscribed to our newsletter. Please check your inbox for the confirmation email.
    </aside>
<?php endif; ?>

<!-- subscriber_confirmed -->
<?php if (isset($_GET['error']) && $_GET['error'] == 'subscriber_confirmed'): ?>
    <aside class="alert alert-danger">
        ❌ Your email is verified. Please check your inbox for the confirmation email.
    </aside>
<?php endif; ?>

<!-- system_error -->
<?php if (isset($_GET['error']) && $_GET['error'] == 'system_error'): ?>
    <aside class="alert alert-danger">
        ❌ System error. Please try again later.
    </aside>
<?php endif; ?>