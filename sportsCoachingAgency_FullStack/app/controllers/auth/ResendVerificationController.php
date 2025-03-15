<?php
namespace App\Controllers\Auth;

require_once __DIR__ . '/../../functions/email.php';
require_once __DIR__ . '/../../config/Database.php';

use App\Config\Database;
use PDO;

class ResendVerificationController
{
    public function resend()
    {
        if (!isset($_GET['email'])) {
            die("❌ Invalid request.");
        }

        $email = $_GET['email'];

        $db = Database::connect();
        $stmt = $db->prepare("SELECT id, is_verified FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            die("❌ No account found with this email.");
        }

        if ($user['is_verified']) {
            die("✅ Your email is already verified. You can <a href='/login'>login</a>.");
        }

        // Generate new verification token
        $newToken = bin2hex(random_bytes(32));

        // Store the new token in the database
        $stmt = $db->prepare("UPDATE users SET verification_token = :token WHERE id = :id");
        $stmt->execute([
            'token' => $newToken,
            'id' => $user['id']
        ]);

        // Send verification email
        $verificationLink = "http://localhost:8000/verify-email?token=$newToken";
        $subject = "Verify Your Email (Resent)";
        $body = "<p>Click <a href='$verificationLink'>here</a> to verify your email.</p>";

        if (sendEmail($email, $subject, $body)) {
            echo "✅ Verification email resent! Please check your inbox.";
        } else {
            echo "❌ Error sending email.";
        }
    }
}
