<?php
namespace App\Controllers;

require_once __DIR__ . '/../functions/auth.php';
require_once __DIR__ . '/../config/Database.php';

use App\Config\Database;
use PDO;

class ProfileController
{
    public function profile()
    {
        requireLogin();

        $db = Database::connect();
        $stmt = $db->prepare("SELECT id, name, email FROM users WHERE id = :id");
        $stmt->execute(['id' => $_SESSION['user_id']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        renderTemplate('back_pages/profile.php', ['user' => $user]);
    }

    public function updateProfile()
    {
        requireLogin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);

            if (empty($name) || empty($email)) {
                die("❌ Name and email cannot be empty.");
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                die("❌ Invalid email format.");
            }

            $db = Database::connect();

            // Check if email is already taken by another user
            $stmt = $db->prepare("SELECT id FROM users WHERE email = :email AND id != :id");
            $stmt->execute(['email' => $email, 'id' => $_SESSION['user_id']]);
            if ($stmt->fetch(PDO::FETCH_ASSOC)) {
                die("❌ Email is already in use.");
            }

            // Update user details
            $stmt = $db->prepare("UPDATE users SET name = :name, email = :email WHERE id = :id");
            $stmt->execute([
                'name' => $name,
                'email' => $email,
                'id' => $_SESSION['user_id']
            ]);

            // Update session
            $_SESSION['user_name'] = $name;

            header("Location: /profile?success=1");
            exit();
        }
    }

    public function changePassword()
    {
        requireLogin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $currentPassword = $_POST['current_password'];
            $newPassword = $_POST['new_password'];
            $confirmPassword = $_POST['confirm_password'];

            if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
                die("❌ All fields are required.");
            }

            if ($newPassword !== $confirmPassword) {
                die("❌ New passwords do not match.");
            }

            if (strlen($newPassword) < 6) {
                die("❌ Password must be at least 6 characters.");
            }

            $db = Database::connect();
            $stmt = $db->prepare("SELECT password FROM users WHERE id = :id");
            $stmt->execute(['id' => $_SESSION['user_id']]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!password_verify($currentPassword, $user['password'])) {
                die("❌ Current password is incorrect.");
            }

            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt = $db->prepare("UPDATE users SET password = :password WHERE id = :id");
            $stmt->execute([
                'password' => $hashedPassword,
                'id' => $_SESSION['user_id']
            ]);

            echo "✅ Password updated successfully!";
            header("Location: /profile?password_changed=1");
            exit();
        }
    }

    public function deleteProfile()
    {
        requireLogin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $db = Database::connect();

            // Delete user from database
            $stmt = $db->prepare("DELETE FROM users WHERE id = :id");
            $stmt->execute(['id' => $_SESSION['user_id']]);

            // Destroy session
            session_destroy();

            echo "✅ Account deleted successfully.";
            header("Location: /logout");
            exit();
        }
    }
}
