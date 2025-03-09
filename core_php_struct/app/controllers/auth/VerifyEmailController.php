<?php
namespace App\Controllers\Auth;

require_once __DIR__ . '/../../config/Database.php';

use App\Config\Database;
use PDO;

class VerifyEmailController
{
    public function verify()
    {
        if (!isset($_GET['token'])) {
            die("❌ Invalid verification link.");
        }

        $token = $_GET['token'];

        $db = Database::connect();
        $stmt = $db->prepare("SELECT id FROM users WHERE verification_token = :token AND is_verified = 0");
        $stmt->execute(['token' => $token]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Update user to set as verified
            $stmt = $db->prepare("UPDATE users SET is_verified = 1, verification_token = NULL WHERE id = :id");
            $stmt->execute(['id' => $user['id']]);

            echo "✅ Email verified! You can now <a href='/login'>login</a>.";
        } else {
            die("❌ Invalid or expired verification token.");
        }
    }
}
