<?php include 'header.php'; ?>

<div class="container">
    <h1 class="page-title">Admin Dashboard</h1>
    <p class="page-description">Welcome to the Admin Dashboard. Below is an overview of the system's key statistics.</p>

    <div class="dashboard-stats">
        <div class="stat-card">
            <h2>Total Users</h2>
            <p><?= htmlspecialchars($totalUsers) ?></p>
        </div>
        <div class="stat-card">
            <h2>Total Athletes</h2>
            <p><?= htmlspecialchars($totalAthletes) ?></p>
        </div>
        <div class="stat-card">
            <h2>Total Coaches</h2>
            <p><?= htmlspecialchars($totalCoaches) ?></p>
        </div>
    </div>

    <h2>Recent Users</h2>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($recentUsers)): ?>
                <?php foreach ($recentUsers as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['id']) ?></td>
                        <td><?= htmlspecialchars($user['name']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= htmlspecialchars($user['role']) ?></td>
                        <td><?= htmlspecialchars($user['created_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">No recent users found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>