<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="<?php echo htmlspecialchars($settings['site_description'] ?? 'Personal athletic training and nutrition coaching in Fresno, CA. Get fit with personalized plans and expert guidance.'); ?>">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?php echo htmlspecialchars($settings['site_url']) ?? 'https://basketball.sorianosoftware.com'?>" />
    <link rel="alternate" hreflang="en-us" href="<?php echo htmlspecialchars($settings['site_url']) ?? 'https://basketball.sorianosoftware.com'?>">
    <meta property="og:title" content="<?php echo htmlspecialchars($header_title ?? 'Personalized Athletic Training in Fresno, CA'); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($settings['site_description'] ?? 'Personal athletic training and nutrition coaching in Fresno, CA. Get fit with personalized plans and expert guidance.'); ?>">
    <meta property="og:image" content="<?php echo htmlspecialchars($settings['site_image'] ?? 'https://basketball.sorianosoftware.com/image.jpg'); ?>">
    <meta property="og:url" content="<?php echo htmlspecialchars($settings['site_url']) ?? 'https://basketball.sorianosoftware.com'; ?>">
    <meta name="twitter:card" content="<?php echo htmlspecialchars($settings['twitter_card'] ?? 'summary_large_image'); ?>">
    <meta name="twitter:title" content="<?php echo htmlspecialchars($header_title ?? 'Personalized Athletic Training in Fresno, CA'); ?>">
    <meta name="twitter:description" content="<?php echo htmlspecialchars($settings['site_description'] ?? 'Personal athletic training and nutrition coaching in Fresno, CA. Get fit with personalized plans and expert guidance.'); ?>">
    <meta name="twitter:image" content="<?php echo htmlspecialchars($settings['site_image'] ?? 'https://basketball.sorianosoftware.com/image.jpg'); ?>">
    <link rel="shortcut icon" href="/assets/img/default_logo.webp" type="image/x-icon" />
    <link rel="stylesheet" href="/assets/css/front-global.css" />
    <link rel="stylesheet" href="<?php echo $page_css_url ?? ''; ?>" />
    <script type="module" src="/assets/js/frontend/global.js"></script>
    <script type="module" src="<?php echo $page_js_url ?? ''; ?>"></script>
    <title><?php echo htmlspecialchars($header_title ?? 'Personalized Athletic Training in Fresno, CA'); ?></title>
  </head>
  <body>
    <nav class="mainNavigation">
      <a href="/" class="logo"><?= htmlspecialchars($settings['site_name'] ?? 'Welcome to Our Website') ?></a>
      <aside class="hamburger">
        <span></span>
        <span></span>
        <span></span>
      </aside>
      <ul class="nav-links">
        <li><a href="/">Home</a></li>
        <li><a href="/about">About</a></li>
        <li><a href="/contact">Contact</a></li>
        <li><a href="/login">Login</a></li>
        <ul class="social-links-container">
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
      </ul>
    </nav>