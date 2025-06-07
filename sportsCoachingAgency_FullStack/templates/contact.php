<?php require_once __DIR__ . '/header.php'; ?>

<section class="contact-section">
  <aside class="content">
    <h1>Contact Us</h1>
    <p>If you have any questions or need assistance, please feel free to reach out to our customer service team. We're here to help!</p>
    <form class="contact-form" action="/contact/message" method="post">
      <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>" />
      <p class="form-group">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required />
      </p>
      <p class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required />
      </p>
      <p class="form-group">
        <label for="message">Message:</label>
        <textarea id="message" name="message" rows="5" required></textarea>
      </p>
      <button type="submit">Send Message</button>
    </form>
  </aside>
</section>
 
<?php require_once __DIR__ . '/flash_messages/contact.php'; ?>
<?php require_once __DIR__ . '/footer.php'; ?>

