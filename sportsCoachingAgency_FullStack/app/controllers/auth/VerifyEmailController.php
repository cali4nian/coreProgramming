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
        
        // Check if the token exists and the user is not verified
        $stmt = $db->prepare("SELECT id, email, verification_token FROM users WHERE verification_token = :token AND is_verified = 0");
        $stmt->execute(['token' => $token]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Update user to set as verified
            $stmt = $db->prepare("UPDATE users SET is_verified = 1, verification_token = NULL WHERE id = :id");
            $stmt->execute(['id' => $user['id']]);

            // Automatically add the user to the subscribers table after email is verified
            // Check if the user already exists in the subscribers table
            $stmt = $db->prepare("SELECT id FROM subscribers WHERE email = :email");
            $stmt->execute(['email' => $user['email']]);
            $existingSubscriber = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$existingSubscriber) {
                // Insert the user into the subscribers table if not already present
                $stmt = $db->prepare("INSERT INTO subscribers (email, confirmation_token, is_confirmed) VALUES (:email, NULL, 1)");
                $stmt->execute(['email' => $user['email']]);

                echo "✅ Your email is verified, and you have been successfully added to the subscribers list!";
            } else {
                echo "✅ Your email is already in the subscribers list and verified!";
            }

        } else {
            die("❌ Invalid or expired verification token.");
        }
    }
}
