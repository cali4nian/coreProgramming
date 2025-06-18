<!-- ##################### SUCCESS ##################### -->
<!-- profile_updated -->
<?php if (isset($_GET['success']) && $_GET['success'] == 'profile_updated'): ?>
    <div class="alert alert-success">
        ✅ Profile updated successfully!
    </div>
<?php endif; ?>
<!-- password_changed -->
<?php if (isset($_GET['success']) && $_GET['success'] == 'password_changed'): ?>
    <div class="alert alert-success">
        ✅ Password changed successfully!
    </div>
<?php endif; ?>

<!-- ##################### ERRORS ##################### -->
<!-- invalid_request -->
<?php if (isset($_GET['error']) && $_GET['error'] == 'invalid_request'): ?>
    <div class="alert alert-danger">
        ❌ Refresh web browser, clear browser cache, or try again later.
    </div>
<?php endif; ?>
<!-- empty_fields -->
<?php if (isset($_GET['error']) && $_GET['error'] == 'empty_fields'): ?>
    <div class="alert alert-danger">
        ❌ Please fill in all fields.
    </div>
<?php endif; ?>
<!-- invalid_email -->
<?php if (isset($_GET['error']) && $_GET['error'] == 'invalid_email'): ?>
    <div class="alert alert-danger">
        ❌ Invalid email address. Please enter a valid email.
    </div>
<?php endif; ?>
<!-- email_taken -->
<?php if (isset($_GET['error']) && $_GET['error'] == 'email_taken'): ?>
    <div class="alert alert-danger">
        ❌ This email is already taken. Please choose a different email.
    </div>
<?php endif; ?>
<!-- invalid_file_type -->
<?php if (isset($_GET['error']) && $_GET['error'] == 'invalid_file_type'): ?>
    <div class="alert alert-danger">
        ❌ Invalid file type. Please upload a valid image file (jpg, jpeg, png, gif).
    </div>
<?php endif; ?>
<!-- file_too_large -->
<?php if (isset($_GET['error']) && $_GET['error'] == 'file_too_large'): ?>
    <div class="alert alert-danger">
        ❌ File size exceeds the limit. Please upload a file smaller than 2MB.
    </div>
<?php endif; ?>
<!-- upload_failed -->
<?php if (isset($_GET['error']) && $_GET['error'] == 'upload_failed'): ?>
    <div class="alert alert-danger">
        ❌ Failed to upload the file. Please try again.
    </div>
<?php endif; ?>
<!-- password_mismatch -->
<?php if (isset($_GET['error']) && $_GET['error'] == 'password_mismatch'): ?>
    <div class="alert alert-danger">
        ❌ Passwords do not match. Please try again.
    </div>
<?php endif; ?>
<!-- password_too_short -->
<?php if (isset($_GET['error']) && $_GET['error'] == 'password_too_short'): ?>
    <div class="alert alert-danger">
        ❌ Password must be at least 6 characters long.
    </div>
<?php endif; ?>
<!-- incorrect_password -->
<?php if (isset($_GET['error']) && $_GET['error'] == 'incorrect_password'): ?>
    <div class="alert alert-danger">
        ❌ Incorrect current password. Please try again.
    </div>
<?php endif; ?>