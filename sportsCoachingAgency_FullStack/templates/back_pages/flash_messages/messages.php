<!-- #################### SUCCESS #################### -->
 <!-- message_deleted -->
<?php if (isset($_GET['success']) && $_GET['success'] == 'message_deleted'): ?>
    <div class="alert alert-success">
        ✅ Message deleted successfully!
    </div>
<?php endif; ?>

<!-- ################### ERRORS ################### -->
<!-- invalid_request -->
<?php if (isset($_GET['error']) && $_GET['error'] == 'invalid_request'): ?>
    <div class="alert alert-danger">
        ❌ Refresh web browser, clear browser cache, or try again later.
    </div>
<?php endif; ?>
<!-- message_not_found -->
<?php if (isset($_GET['error']) && $_GET['error'] == 'message_not_found'): ?>
    <div class="alert alert-danger">
        ❌ Message not found. It may have been deleted or does not exist.
    </div>
<?php endif; ?>
<!-- invalid_id -->
<?php if (isset($_GET['error']) && $_GET['error'] == 'invalid_id'): ?>
    <div class="alert alert-danger">
        ❌ Invalid ID provided. Please check the ID and try again.
    </div>
<?php endif; ?>