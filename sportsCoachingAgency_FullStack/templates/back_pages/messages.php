<?php include 'header.php'; ?>

<!-- create container and table for messages -->
<section class="messages-container">
    <h1>Messages</h1>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Message</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($messages as $message): ?>
                <tr>
                    <td><?php echo htmlspecialchars($message['name']); ?></td>
                    <td><?php echo htmlspecialchars($message['email']); ?></td>
                    <td><?php echo htmlspecialchars($message['message']); ?></td>
                    <td><?php echo htmlspecialchars($message['created_at']); ?></td>
                    <td>
                        <!-- Delete Button -->
                        <form action="/admin/messages/delete" method="POST" onsubmit="return confirm('Are you sure you want to delete this message?');">
                            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">
                            <input type="hidden" name="id" value="<?php echo $message['id']; ?>">
                            <button type="submit" class="delete-btn">Delete</button>
                        </form>
                        <!-- Read Button -->
                        <a href="/admin/messages/read?id=<?php echo $message['id']; ?>"><button class="read-btn">Read</button></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Pagination Links -->
    <div class="pagination">
        <?php if ($currentPage > 1): ?>
            <a href="?page=<?= $currentPage - 1 ?>">⬅ Previous</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?= $i ?>" <?= $i === $currentPage ? 'style="font-weight: bold;"' : '' ?>><?= $i ?></a>
        <?php endfor; ?>

        <?php if ($currentPage < $totalPages): ?>
            <a href="?page=<?= $currentPage + 1 ?>">Next ➡</a>
        <?php endif; ?>
    </div>
    <!-- END Pagination Links -->
</section>
<!-- END create container and table for messages -->

<?php include 'footer.php'; ?>