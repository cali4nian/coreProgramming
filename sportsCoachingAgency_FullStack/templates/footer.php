<footer class="footer">
      <div class="footer-content">
        <a href="/" class="logo"><?= htmlspecialchars($settings['site_name'] ?? 'Welcome to Our Website') ?></a>
        <ul class="social-links">
          <?php if (!empty($settings['youtube_url'])): ?>
            <li>
              <a href="<?php echo htmlspecialchars($settings['youtube_url']) ?? 'https://www.youtube.com'; ?>" target="_blank"><img src="/assets/img/youtube_social_squircle_red.png" class="icon" alt="YouTube" /></a>
            </li>
          <?php endif; ?>
          <?php if (!empty($settings['tiktok_url'])): ?>
            <li>
              <a href="<?php echo htmlspecialchars($settings['tiktok_url']) ?? 'https://www.tiktok.com'; ?>" target="_blank"><img src="/assets/img/TikTok_Icon.png" class="icon" alt="TikTok" /></a>
            </li>
          <?php endif; ?>
          <?php if (!empty($settings['linkedin_url'])): ?>
            <li>
              <a href="<?php echo htmlspecialchars($settings['linkedin_url']) ?? 'https://www.linkedin.com'; ?>" target="_blank"><img src="/assets/img/LinkedIn_Logo.png" class="icon" alt="LinkedIn" /></a>
            </li>
          <?php endif; ?>
          <?php if (!empty($settings['instagram_url'])): ?>
            <li>
              <a href="<?php echo htmlspecialchars($settings['instagram_url']) ?? 'https://www.instagram.com'; ?>" target="_blank"><img src="/assets/img/Instagram_Glyph_Gradient.png" class="icon" alt="Instagram" /></a>
            </li>
          <?php endif; ?>
          <?php if (!empty($settings['facebook_url'])): ?>
            <li>
              <a href="<?php echo htmlspecialchars($settings['facebook_url']) ?? 'https://www.facebook.com'; ?>" target="_blank"><img src="/assets/img/Facebook_Logo_Primary.png" class="icon" alt="Facebook" /></a>
            </li>
          <?php endif; ?>
        </ul>
      </div>
      <nav class="footer-links">
        <span>&copy; 2025 <?= htmlspecialchars($settings['site_name'] ?? 'Welcome to Our Website') ?></span> | <a href="/about">About</a> | <a href="/contact">Contact</a> | <a href="/terms-of-use">Terms of Use</a> |
        <a href="/privacy-policy">Privacy Policy</a>
      </nav>
    </footer>
    <button id="backToTop" class="hidden">&#9650;</button>
</body>
</html>