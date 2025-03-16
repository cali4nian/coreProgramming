<?php
namespace App\Controllers\Auth;

require_once __DIR__ . '/../../functions/email.php';
require_once __DIR__ . '/../../config/Database.php';

use App\Config\Database;
use PDO;

class ForgotPasswordController
{
    public function index()
    {
        if (isset($_SESSION['user_id'])) {
            header("Location: /dashboard");
            exit();
        }
        // Prepare data for the forgot password page
        $data = [
            // CSS file URL
            'page_css_url' => '/assets/css/forgot-password.css',
            // JS file URL
            'page_js_url' => '/assets/js/auth/forgot-password.js',
            // Header title for the page
            'header_title' => 'Forgot Your Password?',
        ];

        renderTemplate('auth/forgot-password.php', $data);
    }

    public function requestReset()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                die("❌ Invalid email format.");
            }

            $db = Database::connect();
            $stmt = $db->prepare("SELECT id FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                die("❌ No account found with this email.");
            }

            // Generate reset token & expiration
            $resetToken = bin2hex(random_bytes(32));
            $expiresAt = date('Y-m-d H:i:s', strtotime('+1 hour'));

            // Store reset token
            $stmt = $db->prepare("UPDATE users SET reset_token = :token, reset_token_expires = :expires WHERE email = :email");
            $stmt->execute([
                'token' => $resetToken,
                'expires' => $expiresAt,
                'email' => $email
            ]);

            // Generate signed reset link
            $resetLink = "http://localhost:8000/reset-password?token=$resetToken";

            // Send email
            $subject = "Reset Your Password";
            $body = "<p>Click <a href='$resetLink'>here</a> to reset your password. This link expires in 1 hour.</p>";

            if (sendEmail($email, $subject, $body)) {
                echo "✅ Password reset email sent!";
            } else {
                echo "❌ Error sending email.";
            }
        }
    }
}
