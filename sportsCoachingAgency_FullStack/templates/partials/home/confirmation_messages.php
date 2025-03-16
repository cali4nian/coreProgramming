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