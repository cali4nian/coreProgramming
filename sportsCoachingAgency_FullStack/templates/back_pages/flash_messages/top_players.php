<!-- #################### SUCCESS #################### -->
<!-- top_player_updated -->
<?php if (isset($_GET['success']) && isset($_GET['player_name']) && $_GET['success'] == 'top_player_updated'): ?>
    <aside class="alert alert-info">
      <p>✅ <?php $_GET['player_name'] ?> player stats updated successfully!</p>
    </aside>
<?php endif; ?>
<!-- top_player_deleted -->
<?php if (isset($_GET['success']) && isset($_GET['player_name']) && $_GET['success'] == 'top_player_deleted'): ?>
    <aside class="alert alert-info">
      <p>✅ <?php $_GET['player_name'] ?> player stats deleted successfully!</p>
    </aside>
<?php endif; ?>

<!-- #################### ERRORS #################### -->
<!-- invalid_request -->
<?php if (isset($_GET['error']) && $_GET['error'] == 'invalid_request'): ?>
    <aside class="alert alert-danger">
      <p>❌ Invalid request. Please try again.</p>
    </aside>
<?php endif; ?>
<!-- player_not_found -->
<?php if (isset($_GET['error']) && $_GET['error'] == 'player_not_found'): ?>
    <aside class="alert alert-danger">
      <p>❌ Player not found. Please try again.</p>
    </aside>
<?php endif; ?>
<!-- missing_id -->
<?php if (isset($_GET['error']) && $_GET['error'] == 'missing_id'): ?>
    <aside class="alert alert-danger">
      <p>❌ Missing player ID. Please try again.</p>
    </aside>
<?php endif; ?>