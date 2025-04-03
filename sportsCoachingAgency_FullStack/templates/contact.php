<?php include 'header.php'; ?>

<!-- Contact Section -->
<section class="contact-section">
  <div class="content">
    <h1>Contact Us</h1>
    <p>If you have any questions or need assistance, please feel free to reach out to our customer service team. We're here to help!</p>
    <form class="contact-form" action="send_message.php" method="post">
      <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required />
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required />
      </div>
      <div class="form-group">
        <label for="message">Message:</label>
        <textarea id="message" name="message" rows="5" required></textarea>
      </div>
      <button type="submit">Send Message</button>
    </form>
  </div>
</section>
<!-- END Contact Section -->
 
<?php include 'partials/confirmation_messages.php'; ?>
<?php include 'footer.php'; ?>
