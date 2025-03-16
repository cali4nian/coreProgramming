<?php
namespace App\Controllers\Auth;

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../functions/email.php';

use App\Config\Database;
use PDO;

class RegisterController
{
    public function index()
    {
        // Prepare data for the register page
        $data = [
            // CSS file URL
            'page_css_url' => '/assets/css/register.css',
            // JS file URL
            'page_js_url' => '/assets/js/auth/register.js',
            // Header title for the page
            'header_title' => 'Create a New Account',
        ];
        renderTemplate('auth/register.php', $data);
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);

            if (empty($name) || empty($email) || empty($password)) {
                die("❌ All fields are required.");
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                die("❌ Invalid email format.");
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $verificationToken = bin2hex(random_bytes(32)); // Generate a unique token

            // Store user in database
            $db = Database::connect();
            $stmt = $db->prepare("INSERT INTO users (name, email, password, verification_token) VALUES (:name, :email, :password, :token)");
            $stmt->execute([
                'name' => $name,
                'email' => $email,
                'password' => $hashedPassword,
                'token' => $verificationToken
            ]);

            // Send verification email
            $verificationLink = "http://localhost:8000/verify-email?token=$verificationToken";
            $subject = "Verify Your Email";
            $body = "<p>Click <a href='$verificationLink'>here</a> to verify your email.</p>";

            if (sendEmail($email, $subject, $body)) {
                echo "✅ Registration successful! Please check your email to verify your account.";
                header("Location: /login");
            } else {
                echo "❌ Error sending verification email.";
            }
        }
    }
}
