<?php require_once __DIR__ . '/header.php'; ?>

<a href="/admin/download-all-subscribers" class="btn">⬇ Download All Subscribers</a>
<a href="/admin/download-confirmed-subscribers" class="btn">⬇ Download Confirmed Subscribers</a>
<a href="/admin/download-unconfirmed-subscribers" class="btn">⬇ Download Unconfirmed Subscribers</a>

<?php if (isset($_GET['deleted'])): ?>
    <p style="color: red;">Subscriber deleted successfully.</p>
<?php endif; ?>

<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Email</th>
            <th>Confirmed</th>
            <th>Subscribed At</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($subscribers as $subscriber): ?>
            <tr>
                <td><?= htmlspecialchars($subscriber['id']) ?></td>
                <td><?= htmlspecialchars($subscriber['email']) ?></td>
                <td><?= $subscriber['is_confirmed'] ? '✅ Yes' : '❌ No' ?></td>
                <td><?= $subscriber['subscribed_at'] ?></td>
                <td>
                    <form action="/admin/delete-subscriber" method="POST" style="display: inline-block;">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($subscriber['id']) ?>">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
                        <button type="submit" class="delete-btn" onclick="return confirm('Are you sure you want to delete this subscriber?')">🗑 Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<aside class="pagination-links">
    <?php if ($currentPage > 1): ?>
        <a href="?page=<?= $currentPage - 1 ?>">⬅ Previous</a>
    <?php endif; ?>
    
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="?page=<?= $i ?>" <?= $i === $currentPage ? 'style="font-weight: bold;"' : '' ?>><?= $i ?></a>
    <?php endfor; ?>

    <?php if ($currentPage < $totalPages): ?>
        <a href="?page=<?= $currentPage + 1 ?>">Next ➡</a>
    <?php endif; ?>
</aside>

<?php require_once __DIR__ . '/../back_pages/flash_messages/subscribers.php'; ?>
<?php require_once __DIR__ . '/footer.php'; ?>
