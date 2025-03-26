<?php
namespace App\Controllers\Auth;

require_once __DIR__ . '/../../functions/csrf.php';
require_once __DIR__ . '/../../config/Database.php';

use App\Config\Database;
use App\Controllers\BaseController; // Extend BaseController
use PDO;
use Exception;

class LoginController extends BaseController
{
    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start(); // Start session only if not already started
        }

        // Redirect to dashboard if already logged in
        if (isset($_SESSION['user_id'])) {
            $this->redirect('/dashboard'); // Use BaseController's redirect method
        }

        // Fetch settings using the BaseController method
        $settings = $this->fetchSettings();

        // Prepare data for the login page
        $data = [
            // CSS file URL
            'page_css_url' => '/assets/css/login.css',
            // JS file URL
            'page_js_url' => '/assets/js/auth/login.js',
            // Header title for the page
            'header_title' => 'Login to Your Account',
            // Settings data
            'settings' => $settings,
        ];

        // Render the template and pass data
        renderTemplate('auth/login.php', $data);
    }

    public function login()
    {
        // Redirect to dashboard if already logged in
        if (isset($_SESSION['user_id'])) {
            $this->redirect('/dashboard'); // Use BaseController's redirect method
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

            // Fetch user and their current role
            $stmt = $db->prepare("
                SELECT 
                    id, 
                    name, 
                    email, 
                    password, 
                    is_verified, 
                    current_role 
                FROM users
                WHERE email = :email
                LIMIT 1
            ");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                if (!$user['is_verified']) {
                    echo "❌ Please verify your email before logging in.";
                    echo "<br><a href='/resend-verification?email=" . urlencode($user['email']) . "'>Resend Verification Email</a>";
                    echo "<br><a href='/login'>Back to Login</a>";
                    exit();
                }
            
                // Store user data in session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['current_role'] = $user['current_role']; // Store the current role for access control
                $this->redirect('/dashboard'); // Use BaseController's redirect method
            } else {
                die("Invalid email or password.");
            }
        }
    }

    public function logout()
    {
        session_start();
        session_destroy(); // Destroy session
        $this->redirect('/login'); // Use BaseController's redirect method
    }
}
