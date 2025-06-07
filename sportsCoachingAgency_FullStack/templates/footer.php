<footer class="footer">
      <div class="footer-content">
        <span class="logo"><?= htmlspecialchars($settings['site_name'] ?? 'Welcome to Our Website') ?></span>
        <ul class="social-links">
          <li>
            <a href="https://www.youtube.com" target="_blank">
              <img src="/assets/img/youtube_social_squircle_red.png" class="icon" alt="YouTube" />
            </a>
          </li>
          <li>
            <a href="https://www.instagram.com" target="_blank">
              <img src="/assets/img/Instagram_Glyph_Gradient.png" class="icon" alt="Instagram" />
            </a>
          </li>
          <li>
            <a href="https://www.facebook.com" target="_blank">
              <img src="/assets/img/Facebook_Logo_Primary.png" class="icon" alt="Facebook" />
            </a>
          </li>
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