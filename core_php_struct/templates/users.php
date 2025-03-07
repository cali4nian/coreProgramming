<?php include 'header.php'; ?>

<h1>All Users</h1>
<ul>
    <?php foreach ($users as $user): ?>
        <li><?php echo $user['name']; ?> - <?php echo $user['email']; ?></li>
    <?php endforeach; ?>
</ul>

<?php include 'footer.php'; ?>
