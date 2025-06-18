<!-- #################### SUCCESS #################### -->
<!-- password_reset_successful -->
<?php if (isset($_GET['success']) && $_GET['success'] == 'password_reset_successful'): ?>
    <div class="alert alert-success">
      ✅ Password reset successful! You can now <a href='/login'>login</a>.
    </div>
<?php endif; ?>

<!-- #################### ERROR #################### -->
<!-- invalid_request -->
<?php if (isset($_GET['error']) && $_GET['error'] == 'invalid_request'): ?>
    <div class="alert alert-danger">
      ❌ Invalid request. Please try again.
    </div>
<?php endif; ?>
<!-- password_too_short -->
<?php if (isset($_GET['error']) && $_GET['error'] == 'password_too_short'): ?>
    <div class="alert alert-danger">
      ❌ Password must be at least 6 characters long.
    </div>
<?php endif; ?>