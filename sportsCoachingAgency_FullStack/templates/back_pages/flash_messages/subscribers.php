<!-- ################### SUCCESS ################### -->
<!-- subscriber_deleted -->
<?php if (isset($_GET['success']) && $_GET['success'] == 'subscriber_deleted'): ?>
    <div class="alert alert-success">
        <p>✅ Subscriber deleted successfully.</p>
    </div>
<?php endif; ?>

<!-- ################### ERRORS ################### -->
<!-- invalid_request -->
<?php if (isset($_GET['error']) && $_GET['error'] == 'invalid_request'): ?>
    <div class="alert alert-danger">
       ❌ Refresh web browser, clear browser cache, or try again later.
    </div>
<?php endif; ?>

