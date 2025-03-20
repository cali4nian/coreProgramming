<?php if ($currentRole === 'coach' && isset($athletes)): ?>
    <h2>Your Athletes</h2>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone Numbers</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($athletes as $athlete): ?>
                <tr>
                    <td><?= htmlspecialchars($athlete['id']) ?></td>
                    <td><?= htmlspecialchars($athlete['name']) ?></td>
                    <td><?= htmlspecialchars($athlete['email']) ?></td>
                    <td>
                        <?php if (!empty($athlete['phone_numbers'])): ?>
                            <ul>
                                <?php foreach ($athlete['phone_numbers'] as $phone): ?>
                                    <li><?= htmlspecialchars($phone['phone_number']) ?> (<?= htmlspecialchars($phone['type']) ?>)</li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            No phone numbers available.
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>