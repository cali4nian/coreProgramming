<?php
namespace App\Controllers;

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../functions/email.php';

use App\Config\Database;
use PDO;

class SubscriberController
{
    public function subscribe()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);

            // Validate email format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                die("❌ Invalid email format.");
            }

            $db = Database::connect();

            // Check if email already exists
            $stmt = $db->prepare("SELECT id, is_confirmed FROM subscribers WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $existingSubscriber = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($existingSubscriber) {
                if ($existingSubscriber['is_confirmed']) {
                    die("✅ You are already subscribed!");
                } else {
                    die("⚠ You have already signed up but need to confirm your email.");
                }
            }

            // Generate confirmation token
            $confirmationToken = bin2hex(random_bytes(32));

            if (!$confirmationToken) {
                die("❌ Error: Token generation failed.");
            }


            // Insert subscriber with token
            $stmt = $db->prepare("INSERT INTO subscribers (email, confirmation_token) VALUES (:email, :token)");
            $stmt->execute([
                'email' => $email,
                'token' => $confirmationToken
            ]);

            // Generate confirmation link
            $confirmationLink = "http://localhost:8000/confirm-subscription?token=$confirmationToken";

            // Send confirmation email
            $subject = "Confirm Your Subscription";
            $body = "<p>Click <a href='$confirmationLink'>here</a> to confirm your subscription.</p>";

            if (sendEmail($email, $subject, $body)) {
                echo "✅ Subscription request received! Please check your email to confirm.";
            } else {
                echo "❌ Subscription request received, but email could not be sent.";
            }
        }
    }

    public function confirm()
    {
        if (!isset($_GET['token'])) {
            die("❌ Invalid confirmation link.");
        }

        $token = $_GET['token'];

        $db = Database::connect();
        $stmt = $db->prepare("SELECT id FROM subscribers WHERE confirmation_token = :token AND is_confirmed = 0");
        $stmt->execute(['token' => $token]);
        $subscriber = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$subscriber) {
            die("❌ Invalid or expired confirmation link.");
        }

        // Mark the subscriber as confirmed
        $stmt = $db->prepare("UPDATE subscribers SET is_confirmed = 1, confirmation_token = NULL WHERE id = :id");
        $stmt->execute(['id' => $subscriber['id']]);

        echo "✅ Your subscription is confirmed! Thank you.";
    }
}
