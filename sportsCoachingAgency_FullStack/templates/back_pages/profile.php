<?php include 'header.php'; ?>

<!-- Update Profile -->
<section class="container">
    <h1>Update Profile</h1>
    <p>Here you can update your profile information.</p>

    <form action="/profile/update" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
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
    <h1>Change Password</h1>
    <p>Here you can update your password.</p>

    <form action="/profile/change-password" method="POST">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
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
 <!-- check if $_SESSION['user_role'] == admin -->
<?php if ($_SESSION['current_role'] != 'admin'): ?>
    <section class="container">
        <h2>Delete Account</h2>
        <p>After deleting your profile, all of your data will be lost forever.</p>
        <form action="/profile/delete" method="POST" onsubmit="return confirm('Are you sure? This cannot be undone.');">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
            <button type="submit" style="background-color: red; color: white;">Delete Account</button>
        </form>
    </section>
<?php endif; ?>
<!-- END Delete Account -->

<?php include 'footer.php'; ?>