<?php include 'header.php'; ?>

<div class="container">
    <h1 class="page-title">Coaches</h1>
    <p class="page-description">Below is a list of all coaches in the system, including their contact information.</p>

    <table class="table table-striped table-bordered coaches-table">
        <thead class="table-header">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone Numbers</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($coaches)): ?>
                <?php foreach ($coaches as $coach): ?>
                    <tr>
                        <td><?= htmlspecialchars($coach['id']) ?></td>
                        <td><?= htmlspecialchars($coach['name']) ?></td>
                        <td><?= htmlspecialchars($coach['email']) ?></td>
                        <td>
                            <?php if (!empty($coach['phone_numbers'])): ?>
                                <ul class="phone-list">
                                    <?php foreach ($coach['phone_numbers'] as $phone): ?>
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
                    <td colspan="4" class="text-center">No coaches found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>