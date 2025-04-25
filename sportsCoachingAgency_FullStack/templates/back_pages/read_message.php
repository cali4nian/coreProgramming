<?php include 'header.php'; ?>
<!-- create read single message container with back and delete button -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Read Message</h2>
            <div class="message-container">
                <div class="message-header">
                    <p>From: <?php echo $message['name']; ?></p>
                    <p>Email: <?php echo $message['email']; ?></p>
                    <p>Date: <?php echo $message['created_at'] ?></p>
                </div>
                <div class="message-body">
                    <p><?php echo nl2br($message['message']); ?></p>
                </div>
                <div class="message-footer">
                    <a href="/admin/messages" class="btn btn-primary">Back to Messages</a>
                    <!-- Delete Button -->
                    <form action="/admin/messages/delete" method="POST" onsubmit="return confirm('Are you sure you want to delete this message?');">
                        <input type="hidden" name="id" value="<?php echo $message['id']; ?>">
                        <button type="submit" class="delete-btn">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>