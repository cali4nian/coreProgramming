<?php include 'header.php'; ?>

<div class="container">
    <h1 class="page-title">Athletes</h1>
    <p class="page-description">Below is a list of all athletes in the system, including their contact information.</p>

    <table class="table table-striped table-bordered athletes-table">
        <thead class="table-header">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone Numbers</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($athletes)): ?>
                <?php foreach ($athletes as $athlete): ?>
                    <tr>
                        <td><?= htmlspecialchars($athlete['id']) ?></td>
                        <td><?= htmlspecialchars($athlete['name']) ?></td>
                        <td><?= htmlspecialchars($athlete['email']) ?></td>
                        <td>
                            <?php if (!empty($athlete['phone_numbers'])): ?>
                                <ul class="phone-list">
                                    <?php foreach ($athlete['phone_numbers'] as $phone): ?>
                                        <li>
                                            <?= htmlspecialchars($phone['phone_number']) ?> 
                                            <span class="phone-type">(<?= htmlspecialchars($phone['type']) ?>)</span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <span class="no-phone">No phone numbers</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center">No athletes found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>