<?php include __DIR__ . '/header.php'; ?>

<section class="player-profile-container">
    
    <!-- Player Form Section -->
    <section class="player-form-section">
        <h1>Editing <?php echo $player['first_name'] . "'s"; ?> Stat Card</h1>
        <form action="/admin/top-players/update" method="POST" enctype="multipart/form-data" class="player-form">
            <input type="hidden" name="id" value="<?= htmlspecialchars($player['id'] ?? '') ?>">
            <!-- First Name -->
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" name="first_name" id="first_name" value="<?= htmlspecialchars($player['first_name'] ?? '') ?>" required>
                <?= isset($errors['first_name']) ? '<p class="error">'.$errors['first_name'].'</p>' : '' ?>
            </div>

            <!-- Last Name -->
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" name="last_name" id="last_name" value="<?= htmlspecialchars($player['last_name'] ?? '') ?>" required>
                <?= isset($errors['last_name']) ? '<p class="error">'.$errors['last_name'].'</p>' : '' ?>
            </div>

            <!-- Position -->
            <div class="form-group">
                <label for="position">Position</label>
                <input type="text" name="position" id="position" value="<?= htmlspecialchars($player['position'] ?? '') ?>" required>
                <?= isset($errors['position']) ? '<p class="error">'.$errors['position'].'</p>' : '' ?>
            </div>

            <!-- Team -->
            <div class="form-group">
                <label for="team">Team</label>
                <input type="text" name="team" id="team" value="<?= htmlspecialchars($player['team'] ?? '') ?>" required>
                <?= isset($errors['team']) ? '<p class="error">'.$errors['team'].'</p>' : '' ?>
            </div>

            <!-- Height (cm) -->
            <div class="form-group">
                <label for="height_ft">Height (feet)</label>
                <input type="number" name="height_ft" id="height_ft" step="1" min="1" max="9" value="<?= htmlspecialchars($player['height_ft'] ?? '') ?>" required>
                <?= isset($errors['height_ft']) ? '<p class="error">'.$errors['height_ft'].'</p>' : '' ?>
            </div>

            <!-- Height (inches) -->
            <div class="form-group">
                <label for="height_in">Height (inches)</label>
                <input type="number" name="height_in" id="height_in" step="1" min="0" max="12" value="<?= htmlspecialchars($player['height_in'] ?? '') ?>" required>
                <?= isset($errors['height_in']) ? '<p class="error">'.$errors['height_in'].'</p>' : '' ?>
            </div>

            <!-- Weight (kg) -->
            <div class="form-group">
                <label for="weight_lbs">Weight (lb)</label>
                <input type="number" name="weight_lbs" id="weight_lbs" step="0.1" min="0" max="400" value="<?= htmlspecialchars($player['weight_lbs'] ?? '') ?>" required>
                <?= isset($errors['weight_lbs']) ? '<p class="error">'.$errors['weight_lbs'].'</p>' : '' ?>
            </div>

            <!-- Points Per Game -->
            <div class="form-group">
                <label for="points_per_game">Points Per Game</label>
                <input type="number" name="points_per_game" id="points_per_game" step="0.1" min="0" max="200" value="<?= htmlspecialchars($player['points_per_game'] ?? '') ?>" required>
                <?= isset($errors['points_per_game']) ? '<p class="error">'.$errors['points_per_game'].'</p>' : '' ?>
            </div>

            <!-- Assists Per Game -->
            <div class="form-group">
                <label for="assists_per_game">Assists Per Game</label>
                <input type="number" name="assists_per_game" id="assists_per_game" step="0.1" min="0" max="200" value="<?= htmlspecialchars($player['assists_per_game'] ?? '') ?>" required>
                <?= isset($errors['assists_per_game']) ? '<p class="error">'.$errors['assists_per_game'].'</p>' : '' ?>
            </div>

            <!-- Rebounds Per Game -->
            <div class="form-group">
                <label for="rebounds_per_game">Rebounds Per Game</label>
                <input type="number" name="rebounds_per_game" id="rebounds_per_game" step="0.1" min="0" max="200" value="<?= htmlspecialchars($player['rebounds_per_game'] ?? '') ?>" required>
                <?= isset($errors['rebounds_per_game']) ? '<p class="error">'.$errors['rebounds_per_game'].'</p>' : '' ?>
            </div>

            <!-- Field Goal Percentage -->
            <div class="form-group">
                <label for="field_goal_percentage">FG %</label>
                <input type="number" name="field_goal_percentage" id="field_goal_percentage" step="0.1" min="0" max="100" value="<?= htmlspecialchars($player['field_goal_percentage'] ?? '') ?>" required>
                <?= isset($errors['field_goal_percentage']) ? '<p class="error">'.$errors['field_goal_percentage'].'</p>' : '' ?>
            </div>

            <!-- Three Point Percentage -->
            <div class="form-group">
                <label for="three_point_percentage">3P %</label>
                <input type="number" name="three_point_percentage" id="three_point_percentage" step="0.1" min="0" max="100" value="<?= htmlspecialchars($player['three_point_percentage'] ?? '') ?>" required>
                <?= isset($errors['three_point_percentage']) ? '<p class="error">'.$errors['three_point_percentage'].'</p>' : '' ?>
            </div>

            <!-- Player Image -->
            <div class="form-group">
                <label for="image">Player Image</label>
                <input type="file" name="image" id="image" accept="image/*" required>
                <?= isset($errors['image']) ? '<p class="error">'.$errors['image'].'</p>' : '' ?>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="submit-button">Update Player</button>
        </form>
    </section>
    <!-- END Player Form Section -->

</section>

<?php require_once __DIR__ . 'flash_messages/edit_top_player.php'; ?>
<?php include __DIR__ . '/footer.php'; ?>
