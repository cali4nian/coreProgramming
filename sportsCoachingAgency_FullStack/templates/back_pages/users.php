<?php include 'header.php'; ?>

<h1>All Users</h1>

<div>
    <h1>Users</h1>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Confirmed</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['name']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo $user['is_verified'] ? 'Yes' : 'No'; ?></td>
                    <td><?php echo $user['is_active'] ? 'Yes' : 'No'; ?></td>
                    <td>
                        <form action="/users/edit" method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                            <input type="hidden" name="name" value="<?php echo htmlspecialchars($user['name']); ?>">
                            <input type="hidden" name="email" value="<?php echo htmlspecialchars($user['email']); ?>">
                            <button type="submit" class="edit-btn">Edit</button>
                        </form>
                        <?php if ($user['is_active']): ?>
                            <form action="/users/pause" method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                <button type="submit" class="pause-btn">Pause</button>
                            </form>
                        <?php else: ?>
                            <form action="/users/unpause" method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                <button type="submit" class="unpause-btn">Unpause</button>
                            </form>
                        <?php endif; ?>
                        <form action="/users/reset_password" method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                            <button type="submit" class="reset-btn">Reset Password</button>
                        </form>
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
    <!-- END Pagination Links -->
    
    <!-- Add User Form -->
    <aside class="add-user-form-container">
        <h2>Add User</h2>
        <form action="/add/user" method="POST">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" placeholder="Enter User Name" required />
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Enter User Email" required />
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Enter User Password" required />
            </div>
            <button type="submit">Add User</button>
        </form>
    </aside>
    <!-- END Add User Form -->
</div>

<?php include 'footer.php'; ?>