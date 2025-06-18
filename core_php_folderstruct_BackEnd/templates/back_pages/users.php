<?php include 'header.php'; ?>

<h1>All Users</h1>

<ul>
    <?php foreach ($users as $user): ?>
        <li><?php echo htmlspecialchars($user['name']); ?> - <?php echo htmlspecialchars($user['email']); ?></li>
    <?php endforeach; ?>
</ul>

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

<?php include 'footer.php'; ?>
