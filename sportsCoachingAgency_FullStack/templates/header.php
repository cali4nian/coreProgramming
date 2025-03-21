<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="/assets/img/basketballLogo.webp" type="image/x-icon" />
    <link rel="stylesheet" href="/assets/css/front-global.css" />
    <link rel="stylesheet" href="<?php echo $page_css_url; ?>" />
    <script type="module" src="/assets/js/frontend/global.js"></script>
    <script type="module" src="<?php echo $page_js_url; ?>"></script>
    <title><?php echo $header_title; ?> | <?= htmlspecialchars($settings['site_name'] ?? 'Welcome to Our Website') ?></title>
  </head>
  <body>
    <!-- Navigation -->
    <nav class="mainNavigation">
      <span class="logo"><?= htmlspecialchars($settings['site_name'] ?? 'Welcome to Our Website') ?></span>
      <div class="hamburger">
        <div></div>
        <div></div>
        <div></div>
      </div>
      <ul>
        <li><a href="/">Home</a></li>
        <li><a href="/about">About</a></li>
        <li><a href="/contact">Contact</a></li>
        <li><a href="/login">Login</a></li>
        <div class="social-links-container">
          <li>
            <a href="https://www.youtube.com" target="_blank"><img src="/assets/img/youtube_social_squircle_red.png" class="icon" alt="YouTube" /></a>
          </li>
          <li>
            <a href="https://www.instagram.com" target="_blank"><img src="/assets/img/Instagram_Glyph_Gradient.png" class="icon" alt="Instagram" /></a>
          </li>
          <li>
            <a href="https://www.facebook.com" target="_blank"><img src="/assets/img/Facebook_Logo_Primary.png" class="icon" alt="Facebook" /></a>
          </li>
        </div>
      </ul>
    </nav>
    <!-- END Navigation -->
  </body>
</html>