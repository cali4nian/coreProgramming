<!-- ################### SUCCESS ################### -->
<?php if (isset($_GET['success']) && $_GET['success'] == 'account_verified'): ?>
    <div class="alert alert-info">
    <p>✅ Your account has been confirmed. You can now login.</p>
    </div>
<?php endif; ?>

<!-- ################### ERRORS ################### -->
<!-- invalid_request -->
<?php if (isset($_GET['error']) && $_GET['error'] == 'invalid_request'): ?>
    <div class="alert alert-danger">
       ❌ Refresh web browser, clear browser cache, or try again later.
    </div>
<?php endif; ?>

