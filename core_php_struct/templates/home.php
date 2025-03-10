<?php include 'header.php'; ?>

<h1><?php echo $title; ?></h1>
<p><?php echo $message; ?></p>

<form action="/subscribe" method="POST">
    <label for="email">Subscribe to our mailing list:</label>
    <input type="email" name="email" required placeholder="Enter your email">
    <button type="submit">Subscribe</button>
</form>

<?php if (isset($_GET['pending'])): ?>
    <p>✅ A confirmation email has been sent. Please check your inbox.</p>
<?php endif; ?>


<?php include 'footer.php'; ?>
