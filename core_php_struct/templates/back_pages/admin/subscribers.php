<?php include __DIR__ . '/../header.php'; ?>

<h1>Subscribers List</h1>

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
                    <a href="/admin/delete-subscriber?id=<?= $subscriber['id'] ?>" onclick="return confirm('Are you sure you want to delete this subscriber?')">🗑 Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Pagination Links -->
<div>
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

<?php include __DIR__ . '/../footer.php'; ?>
