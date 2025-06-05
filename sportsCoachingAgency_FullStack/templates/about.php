<?php require_once __DIR__ . '/header.php'; ?>

<!-- About Section -->
<section class="about-section">
  <aside class="content">
    <h1>Our Story</h1>
    <aside class="about-image-container">
      <p>Discover our journey and what drives us.</p>
      <img src="<?php echo htmlspecialchars($settings['about_page_image'] ?? '/assets/img/default_about_image.png'); ?>" alt="About Us Image" class="about-image">
    </aside>
    <p><?php echo htmlspecialchars($settings['about_page_text_one'] ?? ''); ?></p>
    <p><?php echo htmlspecialchars($settings['about_page_text_two'] ?? ''); ?></p>
    <p><?php echo htmlspecialchars($settings['about_page_text_three'] ?? ''); ?></p>
    
  </aside>
</section>
<!-- END About Section -->
 
<?php require_once __DIR__ . '/footer.php'; ?>
