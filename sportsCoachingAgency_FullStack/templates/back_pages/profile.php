<?php include 'header.php'; ?>
<h1><?php echo $_SESSION['user_name']; ?>'s Profile Page</h1>

<h1>Update Profile</h1>

<?php if (isset($_GET['success'])): ?>
    <p style="color: green;">✅ Profile updated successfully.</p>
<?php endif; ?>

<?php if (isset($_GET['password_changed'])): ?>
    <p style="color: green;">✅ Password changed successfully.</p>
<?php endif; ?>

<form action="/profile/update" method="POST">
    <label for="name">Name:</label>
    <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>

    <label for="email">Email:</label>
    <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

    <button type="submit">Update Profile</button>
</form>

<h2>Change Password</h2>
<form action="/profile/change-password" method="POST">
    <label for="current_password">Current Password:</label>
    <input type="password" name="current_password" required>

    <label for="new_password">New Password:</label>
    <input type="password" name="new_password" required>

    <label for="confirm_password">Confirm New Password:</label>
    <input type="password" name="confirm_password" required>

    <button type="submit">Change Password</button>
</form>

<h2>Delete Account</h2>
<form action="/profile/delete" method="POST" onsubmit="return confirm('Are you sure? This cannot be undone.');">
    <button type="submit" style="background-color: red; color: white;">Delete Account</button>
</form>


<?php include 'footer.php'; ?>