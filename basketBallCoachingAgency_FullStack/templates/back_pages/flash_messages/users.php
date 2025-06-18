<!-- #################### SUCCESS #################### -->
<!-- user_deleted -->
<?php if (isset($_GET['success']) && $_GET['success'] == 'user_deleted'): ?>
    <aside class="alert alert-success">
      <p>✅ User deleted successfully.</p>
    </aside>
<?php endif; ?>
<!-- user_paused -->
<?php if (isset($_GET['success']) && $_GET['success'] == 'user_paused'): ?>
    <aside class="alert alert-success">
      <p>✅ User paused successfully.</p>
    </aside>
<?php endif; ?>
<!-- user_unpaused -->
<?php if (isset($_GET['success']) && $_GET['success'] == 'user_unpaused'): ?>
    <aside class="alert alert-success">
      <p>✅ User unpaused successfully.</p>
    </aside>
<?php endif; ?>
<!-- reset_password -->
<?php if (isset($_GET['success']) && $_GET['success'] == 'reset_password'): ?>
    <aside class="alert alert-success">
      <p>✅ User password reset successfully.</p>
    </aside>
<?php endif; ?>
<!-- added_super_user -->
<?php if (isset($_GET['success']) && $_GET['success'] == 'added_super_user'): ?>
    <aside class="alert alert-success">
      <p>✅ Super user added successfully.</p>
    </aside>
<?php endif; ?>
<!-- user_updated -->
<?php if (isset($_GET['success']) && $_GET['success'] == 'user_updated'): ?>
    <aside class="alert alert-success">
      <p>✅ User updated successfully.</p>
    </aside>
<?php endif; ?>

<!-- #################### ERRORS #################### -->
<!-- invalid_request -->
<?php if (isset($_GET['error']) && $_GET['error'] == 'invalid_request'): ?>
    <aside class="alert alert-danger">
      <p>❌ Invalid request. Please try again.</p>
    </aside>
<?php endif; ?>
<!-- cannot_delete_admin -->
<?php if (isset($_GET['error']) && $_GET['error'] == 'cannot_delete_admin'): ?>
    <aside class="alert alert-danger">
      <p>❌ Cannot delete the admin user.</p>
    </aside>
<?php endif; ?>
<!-- action_failed -->
<?php if (isset($_GET['error']) && $_GET['error'] == 'action_failed'): ?>
    <aside class="alert alert-danger">
      <p>❌ Action failed. Please try again.</p>
    </aside>
<?php endif; ?>
<!-- reset_failed -->
<?php if (isset($_GET['error']) && $_GET['error'] == 'reset_failed'): ?>
    <aside class="alert alert-danger">
      <p>❌ Password reset failed. Please try again.</p>
    </aside>
<?php endif; ?>
<!-- add_failed -->
<?php if (isset($_GET['error']) && $_GET['error'] == 'add_failed'): ?>
    <aside class="alert alert-danger">
      <p>❌ Adding super user failed. Please try again.</p>
    </aside>
<?php endif; ?>
<!-- user_not_found -->
<?php if (isset($_GET['error']) && $_GET['error'] == 'user_not_found'): ?>
    <aside class="alert alert-danger">
      <p>❌ User not found. Please try again.</p>
    </aside>
<?php endif; ?>
<!-- update_failed -->
<?php if (isset($_GET['error']) && $_GET['error'] == 'update_failed'): ?>
    <aside class="alert alert-danger">
      <p>❌ User update failed. Please try again.</p>
    </aside>
<?php endif; ?>