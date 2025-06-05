<?php include __DIR__ . '/header.php'; ?>

<section class="player-profile-container">
    <!-- Player Profiles Section -->
    <section class="player-profiles">
        <div class="profiles-container" style="display: flex; flex-wrap: wrap; gap: 1.5rem;">
            <?php foreach ($players as $player): ?>
                <div class="player-card" style="width: 250px; border: 1px solid #ddd; border-radius: 8px; padding: 1rem; background-color: #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                    <img 
                    src="<?= !empty($player['image_url']) ? htmlspecialchars($player['image_url']) : '/assets/img/default_athlete_image.jpg' ?>" 
                    alt="<?= htmlspecialchars((string)($player['first_name'] ?? '') . ' ' . ($player['last_name'] ?? '')) ?>" 
                    style="width: 100%; height: auto; border-radius: 6px;" 
                    />
                    <h2><?= htmlspecialchars((string)($player['first_name'] ?? '') . ' ' . ($player['last_name'] ?? '')) ?></h2>
                    <p><strong><?= htmlspecialchars((string)($player['position'] ?? '')) ?></strong> — <?= htmlspecialchars((string)($player['team'] ?? '')) ?></p>
                    <p>🏀 <strong><?= $player['points_per_game'] ?></strong> PPG</p>
                    <p>🎯 FG%: <?= $player['field_goal_percentage'] ?>%</p>
                    <p>🎯 3P%: <?= $player['three_point_percentage'] ?>%</p>
                    <p>💪 REB: <?= $player['rebounds_per_game'] ?> | 🎯 AST: <?= $player['assists_per_game'] ?></p>
                    <!-- Add edit and delete forms -->
                    <form action="/admin/top-players/edit" method="POST" style="display: inline-block;">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($player['id']) ?>">
                        <button type="submit" class="edit-button">Edit</button>
                    </form>
                    <form action="/admin/top-players/delete" method="POST" style="display: inline-block;">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($player['id']) ?>">
                        <button type="submit" class="delete-button">Delete</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
    <!-- END Player Profiles Section -->

    <!-- Player Form Section -->
    <section class="player-form-section">
        <h1>Add New Top Player</h1>
        <form action="/admin/top-players/create" method="POST" enctype="multipart/form-data" class="player-form">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
            <!-- First Name -->
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" name="first_name" id="first_name" value="<?= htmlspecialchars($formData['first_name'] ?? '') ?>" required>
                <?= isset($errors['first_name']) ? '<p class="error">'.$errors['first_name'].'</p>' : '' ?>
            </div>

            <!-- Last Name -->
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" name="last_name" id="last_name" value="<?= htmlspecialchars($formData['last_name'] ?? '') ?>" required>
                <?= isset($errors['last_name']) ? '<p class="error">'.$errors['last_name'].'</p>' : '' ?>
            </div>

            <!-- Position -->
            <div class="form-group">
                <label for="position">Position</label>
                <input type="text" name="position" id="position" value="<?= htmlspecialchars($formData['position'] ?? '') ?>" required>
                <?= isset($errors['position']) ? '<p class="error">'.$errors['position'].'</p>' : '' ?>
            </div>

            <!-- Team -->
            <div class="form-group">
                <label for="team">Team</label>
                <input type="text" name="team" id="team" value="<?= htmlspecialchars($formData['team'] ?? '') ?>" required>
                <?= isset($errors['team']) ? '<p class="error">'.$errors['team'].'</p>' : '' ?>
            </div>

            <!-- Height (cm) -->
            <p class="form-group">
                <label for="height_ft">Height (feet)</label>
                <input type="number" name="height_ft" id="height_ft" step="1" min="1" max="9" value="<?= htmlspecialchars($formData['height_ft'] ?? '') ?>" required>
                <?= isset($errors['height_ft']) ? '<p class="error">'.$errors['height_ft'].'</p>' : '' ?>
            </p>

            <!-- Height (inches) -->
            <div class="form-group">
                <label for="height_in">Height (inches)</label>
                <input type="number" name="height_in" id="height_in" step="1" min="0" max="12" value="<?= htmlspecialchars($formData['height_in'] ?? '') ?>" required>
                <?= isset($errors['height_in']) ? '<p class="error">'.$errors['height_in'].'</p>' : '' ?>
            </div>

            <!-- Weight (kg) -->
            <div class="form-group">
                <label for="weight_lbs">Weight (lb)</label>
                <input type="number" name="weight_lbs" id="weight_lbs" step="0.1" min="0" max="400" value="<?= htmlspecialchars($formData['weight_lbs'] ?? '') ?>" required>
                <?= isset($errors['weight_lbs']) ? '<p class="error">'.$errors['weight_lbs'].'</p>' : '' ?>
            </div>

            <!-- Points Per Game -->
            <div class="form-group">
                <label for="points_per_game">Points Per Game</label>
                <input type="number" name="points_per_game" id="points_per_game" step="0.1" min="0" max="200" value="<?= htmlspecialchars($formData['points_per_game'] ?? '') ?>" required>
                <?= isset($errors['points_per_game']) ? '<p class="error">'.$errors['points_per_game'].'</p>' : '' ?>
            </div>

            <!-- Assists Per Game -->
            <div class="form-group">
                <label for="assists_per_game">Assists Per Game</label>
                <input type="number" name="assists_per_game" id="assists_per_game" step="0.1" min="0" max="200" value="<?= htmlspecialchars($formData['assists_per_game'] ?? '') ?>" required>
                <?= isset($errors['assists_per_game']) ? '<p class="error">'.$errors['assists_per_game'].'</p>' : '' ?>
            </div>

            <!-- Rebounds Per Game -->
            <div class="form-group">
                <label for="rebounds_per_game">Rebounds Per Game</label>
                <input type="number" name="rebounds_per_game" id="rebounds_per_game" step="0.1" min="0" max="200" value="<?= htmlspecialchars($formData['rebounds_per_game'] ?? '') ?>" required>
                <?= isset($errors['rebounds_per_game']) ? '<p class="error">'.$errors['rebounds_per_game'].'</p>' : '' ?>
            </div>

            <!-- Field Goal Percentage -->
            <div class="form-group">
                <label for="field_goal_percentage">FG %</label>
                <input type="number" name="field_goal_percentage" id="field_goal_percentage" step="0.1" min="0" max="100" value="<?= htmlspecialchars($formData['field_goal_percentage'] ?? '') ?>" required>
                <?= isset($errors['field_goal_percentage']) ? '<p class="error">'.$errors['field_goal_percentage'].'</p>' : '' ?>
            </div>

            <!-- Three Point Percentage -->
            <div class="form-group">
                <label for="three_point_percentage">3P %</label>
                <input type="number" name="three_point_percentage" id="three_point_percentage" step="0.1" min="0" max="100" value="<?= htmlspecialchars($formData['three_point_percentage'] ?? '') ?>" required>
                <?= isset($errors['three_point_percentage']) ? '<p class="error">'.$errors['three_point_percentage'].'</p>' : '' ?>
            </div>

            <!-- Player Image -->
            <div class="form-group">
                <label for="image">Player Image</label>
                <input type="file" name="image" id="image" accept="image/*" required>
                <?= isset($errors['image']) ? '<p class="error">'.$errors['image'].'</p>' : '' ?>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="submit-button">Add Player</button>
        </form>
    </section>
    <!-- END Player Form Section -->

</section>

<?php require_once __DIR__ . 'flash_messages/top_players.php'; ?>
<?php include __DIR__ . '/footer.php'; ?>
