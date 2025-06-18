<!-- ################### SUCCESS ################### -->
<!-- site_updated -->
<?php if (isset($_GET['success']) && $_GET['success'] == 'site_updated'): ?>
    <div class="alert alert-success">
        ✅ Site settings updated successfully!
    </div>
<?php endif; ?>
<!-- social_media_updated -->
<?php if (isset($_GET['success']) && $_GET['success'] == 'social_media_updated'): ?>
    <div class="alert alert-success">
        ✅ Social media settings updated successfully!
    </div>
<?php endif; ?>
<!-- home_page_updated -->
<?php if (isset($_GET['success']) && $_GET['success'] == 'home_page_updated'): ?>
    <div class="alert alert-success">
        ✅ Home page settings updated successfully!
    </div>
<?php endif; ?>
<!-- about_page_updated -->
<?php if (isset($_GET['success']) && $_GET['success'] == 'about_page_updated'): ?>
    <div class="alert alert-success">
        ✅ About page settings updated successfully!
    </div>
<?php endif; ?>

<!-- ################### ERRORS ################### -->
<!-- invalid_request -->
<?php if (isset($_GET['error']) && $_GET['error'] == 'invalid_request'): ?>
    <div class="alert alert-danger">
       ❌ Refresh web browser, clear browser cache, or try again later.
    </div>
<?php endif; ?>

