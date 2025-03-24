<?php include 'header.php'; ?>

<!-- Update Profile -->
<section class="container">

    <h1>Update Profile</h1>
    <p>Here you can update your profile information.</p>

    <?php if (isset($_GET['success'])): ?>
        <p style="color: green;">✅ Profile updated successfully.</p>
    <?php endif; ?>

    <?php if (isset($_GET['password_changed'])): ?>
        <p style="color: green;">✅ Password changed successfully.</p>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <p style="color: red;">❌ <?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif; ?>

    <form action="/profile/update" method="POST" enctype="multipart/form-data">
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

        <label for="phone_number">Phone Number:</label>
        <input type="text" name="phone_number" value="<?= htmlspecialchars($user['phone_number'] ?? '') ?>">

        <label for="address">Address:</label>
        <input type="text" name="address" value="<?= htmlspecialchars($user['address'] ?? '') ?>">

        <label for="profile_image">Profile Image:</label>
        <?php if (!empty($user['profile_image'])): ?>
            <div>
                <img src="/uploads/profile_images/<?= htmlspecialchars($user['profile_image']) ?>" alt="Profile Image" style="max-width: 150px; max-height: 150px;">
            </div>
        <?php endif; ?>
        <input type="file" name="profile_image" accept="image/*">

        <button type="submit">Update Profile</button>
    </form>
</section>
<!-- END Update Profile -->

<!-- Update Password -->
<section class="container">
    <h2>Change Password</h2>
    <p>Here you can update your password.</p>
    <form action="/profile/change-password" method="POST">
        <label for="current_password">Current Password:</label>
        <input type="password" name="current_password" required>

        <label for="new_password">New Password:</label>
        <input type="password" name="new_password" required>

        <label for="confirm_password">Confirm New Password:</label>
        <input type="password" name="confirm_password" required>

        <button type="submit">Change Password</button>
    </form>
</section>
<!-- END Update Password -->

<!-- Delete Account -->
<section class="container">
    <h2>Delete Account</h2>
    <p>After deleting your profile, all of your data will be lost forever.</p>
    <form action="/profile/delete" method="POST" onsubmit="return confirm('Are you sure? This cannot be undone.');">
        <button type="submit" style="background-color: red; color: white;">Delete Account</button>
    </form>
</section>
<!-- END Delete Account -->

<?php include 'footer.php'; ?>