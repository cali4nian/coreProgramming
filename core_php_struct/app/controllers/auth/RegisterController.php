<?php
namespace App\Controllers\Auth;

require_once __DIR__ . '/../../functions/csrf.php';
require_once __DIR__ . '/../../config/Database.php';

use App\Config\Database;
use PDO;

class RegisterController
{
    public function index()
    {
        // Redirect to dashboard if already logged in
        if (isset($_SESSION['user_id'])) {
            header("Location: /dashboard"); // Redirect to dashboard if logged in
            exit();
        }

        // Prepare data for the home page
        $data = [];
        
        // Render the template and pass data
        renderTemplate('auth/register.php', $data);
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate CSRF token
            if (!isset($_POST['csrf_token'])) {
                die("CSRF token missing.");
            }
            validateCsrfToken($_POST['csrf_token']);

            // Get database connection
            $db = Database::connect();

            // Validate user input
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);

            if (empty($name) || empty($email) || empty($password)) {
                die("All fields are required.");
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                die("Invalid email format.");
            }

            if (strlen($password) < 6) {
                die("Password must be at least 6 characters long.");
            }

            // Check if email already exists
            $stmt = $db->prepare("SELECT id FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            if ($stmt->fetch()) {
                die("Email is already registered.");
            }

            // Hash password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert new user
            $stmt = $db->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
            $stmt->execute([
                'name' => $name,
                'email' => $email,
                'password' => $hashedPassword
            ]);

            echo "✅ Registration successful! You can now login.";
        }
    }
}
