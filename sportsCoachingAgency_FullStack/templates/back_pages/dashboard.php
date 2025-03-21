<!-- filepath: c:\Users\danie\Documents\github\coreProgramming\sportsCoachingAgency_FullStack\templates\back_pages\dashboard.php -->
<?php include 'header.php'; ?>

<section class="container">

    <!-- Dashboard Stats -->
    <aside class="dashboard-stats">
        <?php if (isset($totalUsers) && ($currentRole === 'admin' || $currentRole === 'super user')): ?>
            <div class="stat-card">
                <h2>Total Users</h2>
                <p><?= htmlspecialchars($totalUsers) ?></p>
            </div>
        <?php endif; ?>

        <?php if (isset($totalSubscribers)): ?>
            <div class="stat-card">
                <h2>Total Subscribers</h2>
                <p><?= htmlspecialchars($totalSubscribers) ?></p>
            </div>
        <?php endif; ?>

        <?php if (isset($totalAdmins) && $currentRole === 'admin'): ?>
            <div class="stat-card">
                <h2>Total Admins</h2>
                <p><?= htmlspecialchars($totalAdmins) ?></p>
            </div>
        <?php endif; ?>

        <?php if (isset($totalSuperUsers) && $currentRole === 'admin'): ?>
            <div class="stat-card">
                <h2>Total Super Users</h2>
                <p><?= htmlspecialchars($totalSuperUsers) ?></p>
            </div>
        <?php endif; ?>
    </aside>

    <!-- Recent Users -->
    <?php if (isset($recentUsers) && ($currentRole === 'admin' || $currentRole === 'super user')): ?>
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
    <?php endif; ?>

    <!-- Recent Subscribers -->
    <?php if (isset($recentSubscribers)): ?>
        <h2>Recent Subscribers</h2>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Confirmed</th>
                    <th>Active</th>
                    <th>Subscribed At</th>
                    <th>Unsubscribed At</th>
                    <th>Last Updated</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($recentSubscribers)): ?>
                    <?php foreach ($recentSubscribers as $subscriber): ?>
                        <tr>
                            <td><?= htmlspecialchars($subscriber['id'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($subscriber['email'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($subscriber['is_confirmed'] ? 'Yes' : 'No') ?></td>
                            <td><?= htmlspecialchars($subscriber['is_active'] ? 'Yes' : 'No') ?></td>
                            <td><?= htmlspecialchars($subscriber['subscribed_at'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($subscriber['unsubscribed_at'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($subscriber['updated_at'] ?? 'N/A') ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center">No recent subscribers found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <!-- Error Handling -->
    <?php if (isset($error)): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

</section>

<?php include 'footer.php'; ?>