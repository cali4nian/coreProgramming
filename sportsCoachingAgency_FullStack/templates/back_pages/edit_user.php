<?php include 'header.php'; ?>

<div class="container">
    <h1><?= htmlspecialchars($pageName) ?></h1>
    <p><?= htmlspecialchars($pageDescription) ?></p>

    <?php if ($user): ?>
        <form action="/admin/users/update" method="POST">
            <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']); ?>">
            
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?= htmlspecialchars($user['name']); ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" required>
            </div>

            <div class="form-group">
                <label for="role">Role:</label>
                <select id="role" name="role" required>
                    <option value="admin" <?= $user['current_role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                    <option value="coach" <?= $user['current_role'] === 'coach' ? 'selected' : ''; ?>>Coach</option>
                    <option value="athlete" <?= $user['current_role'] === 'athlete' ? 'selected' : ''; ?>>Athlete</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update User</button>
        </form>
    <?php else: ?>
        <p>User not found.</p>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>