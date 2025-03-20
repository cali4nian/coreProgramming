<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ADMIN | <?php echo $header_title; ?></title>
    <link rel="stylesheet" href="/assets/css/back-global.css" />
    <link rel="stylesheet" href=<?php echo $page_css_url; ?> />
    <script type="module" src=<?php echo $page_js_url; ?>></script>
  </head>
  <body>
    <section class="main-grid-container">
    <!-- Sidebar -->
    <?php require_once "partials/sidebar.php" ?>
    <!-- Main Content -->
    <main class="main-content">


    <?php
      // Set default values for page name and description if not provided
      $pageName = $pageName ?? 'Default Page Title';
      $pageDescription = $pageDescription ?? 'Welcome to the page.';
      require_once 'partials/page-header.php';
    ?>