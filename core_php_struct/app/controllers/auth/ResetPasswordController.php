<?php
namespace App\Controllers\Auth;

require_once __DIR__ . '/../../config/Database.php';

use App\Config\Database;
use PDO;

class ResetPasswordController
{
    public function index()
    {
        if (!isset($_GET['token'])) {
            die("❌ Invalid or expired reset token.");
        }

        $token = $_GET['token'];

        // Verify token in database
        $db = Database::connect();
        $stmt = $db->prepare("SELECT id FROM users WHERE reset_token = :token AND reset_token_expires > NOW()");
        $stmt->execute(['token' => $token]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            die("❌ Invalid or expired reset token.");
        }

        // Show the password reset form
        renderTemplate('auth/reset-password.php', ['token' => $token]);
    }

    public function reset()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['token'];
            $newPassword = $_POST['password'];

            if (empty($newPassword) || strlen($newPassword) < 6) {
                die("❌ Password must be at least 6 characters.");
            }

            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            $db = Database::connect();
            $stmt = $db->prepare("SELECT id FROM users WHERE reset_token = :token AND reset_token_expires > NOW()");
            $stmt->execute(['token' => $token]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                die("❌ Invalid or expired reset token.");
            }

            // Update password & clear reset token
            $stmt = $db->prepare("UPDATE users SET password = :password, reset_token = NULL, reset_token_expires = NULL WHERE id = :id");
            $stmt->execute([
                'password' => $hashedPassword,
                'id' => $user['id']
            ]);

            echo "✅ Password has been reset! <a href='/login'>Login</a>";
        }
    }
}
