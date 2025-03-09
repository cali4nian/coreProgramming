<?php
namespace App\Controllers\Auth;
require_once __DIR__ . '/../../functions/csrf.php';
require_once __DIR__ . '/../../config/Database.php';

use App\Config\Database;
use PDO;
use Exception;

class LoginController
{
  public function index() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start(); // Start session only if not already started
    }

    // Redirect to dashboard if already logged in
    if (isset($_SESSION['user_id'])) {
        header("Location: /dashboard"); // Redirect to dashboard if logged in
        exit();
    }

    // Render the template and pass data
    renderTemplate('auth/login.php');
  }
  
  public function login()
    {
        // Redirect to dashboard if already logged in
        if (isset($_SESSION['user_id'])) {
            header("Location: /dashboard"); // Redirect to dashboard if logged in
            exit();
        }

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['csrf_token']) || !validateCsrfToken($_POST['csrf_token'])) {
                die("CSRF token validation failed.");
            }

            $email = trim($_POST['email']);
            $password = trim($_POST['password']);

            if (empty($email) || empty($password)) {
                die("Email and password are required.");
            }

            $db = Database::connect();
            $stmt = $db->prepare("SELECT id, name, password, role, is_verified FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                if (!$user['is_verified']) {
                    echo "<a href='/login'>Back to Login</a>";
                    die("❌ Please verify your email before logging in.");
                }
                // Store user data in session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_role'] = $user['role']; // Store role for access control
                header("Location: /dashboard");
                exit();
            } else {
                die("Invalid email or password.");
            }
        }
    }

  public function logout()
    {
        session_start();
        session_destroy(); // Destroy session
        header("Location: /login");
        exit();
    }
}
