<!-- SUCCESS -->
<!-- message_sent -->
<?php if (isset($_GET['success']) && $_GET['success'] == 'message_sent'): ?>
    <aside class="alert alert-success">
        ✅ Your message has been sent successfully! We will get back to you soon.
    </aside>
<?php endif; ?>

<!-- ERRORS -->
<!-- invalid_request -->
<?php if (isset($_GET['error']) && $_GET['error'] == 'invalid_request'): ?>
    <aside class="alert alert-danger">
      ❌ Refresh web browser, clear browser cache, or try again later.
    </aside>
<?php endif; ?>

<!-- message_failed -->
<?php if (isset($_GET['error']) && $_GET['error'] == 'message_failed'): ?>
    <aside class="alert alert-danger">
      ❌ Message failed to send. Please try again later.
    </aside>
<?php endif; ?>

<!-- empty_fields -->
<?php if (isset($_GET['error']) && $_GET['error'] == 'empty_fields'): ?>
    <aside class="alert alert-danger">
      ❌ Please fill in all fields and try again.
    </aside>
<?php endif; ?>