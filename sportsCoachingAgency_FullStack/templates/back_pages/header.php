<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Add Meta Tags -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ADMIN | <?php echo $header_title; ?></title>
    <link rel="stylesheet" href="/assets/css/back-global.css" />
    <link rel="stylesheet" href=<?php echo $page_css_url; ?> />
    <script type="module" src=<?php echo $page_js_url; ?>></script>
  </head>
  <body>
    <section class="main-grid-container">
      <?php require_once __DIR__ . "/sidebar.php" ?>
      <main class="main-content">
        <section class="page-header">
          <h1><?= htmlspecialchars($pageName ?? 'Default Page Title') ?></h1>
          <p><?= htmlspecialchars($pageDescription ?? 'Default Page Description') ?></p>
        </section>