<?php if ($currentRole === 'athlete' && isset($profile)): ?>
    <h2>Your Profile</h2>
    <div class="profile-card">
        <p><strong>Name:</strong> <?= htmlspecialchars($profile['name']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($profile['email']) ?></p>
        <?php if (!empty($profile['phone_numbers'])): ?>
            <p><strong>Phone Numbers:</strong></p>
            <ul>
                <?php foreach ($profile['phone_numbers'] as $phone): ?>
                    <li><?= htmlspecialchars($phone['phone_number']) ?> (<?= htmlspecialchars($phone['type']) ?>)</li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No phone numbers available.</p>
        <?php endif; ?>
    </div>
<?php endif; ?>