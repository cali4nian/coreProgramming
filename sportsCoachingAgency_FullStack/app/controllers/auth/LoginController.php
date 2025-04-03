<?php
namespace App\Controllers\Auth;

require_once __DIR__ . '/../../functions/csrf.php';
require_once __DIR__ . '/../../config/Database.php';

use App\Models\AuthModel;
use App\Controllers\BaseController;

class LoginController extends BaseController
{

    private AuthModel $authModel;

    public function __construct()
    {
        $this->authModel = new AuthModel();
    }

    public function index()
    {
        // Start session only if not already started
        $this->isLoggedIn();
        $this->isSessionOrStart();

        // Fetch settings using the BaseController method
        $settings = $this->fetchSettings();

        // Prepare data for the login page
        $data = [
            'page_css_url' => '/assets/css/login.css',
            'page_js_url' => '/assets/js/auth/login.js',
            'header_title' => 'Login to Your Account',
            'settings' => $settings,
        ];

        // Render the template and pass data
        renderTemplate('auth/login.php', $data);
    }

    // Login user if authenticated
    public function login()
    {
        // Redirect to dashboard if already logged in
        $this->isLoggedIn();
        $this->isSessionOrStart();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['csrf_token']) || !validateCsrfToken($_POST['csrf_token'])) $this->redirect('login?error=invalid_request');

            $email = $this->sanitizeEmail($_POST['email']);
            $password = trim($_POST['password']);

            if (empty($email) || empty($password)) $this->redirect('login?error=email_or_password_empty');

            $user = $this->authModel->fetchUser($email);

            if ($user && password_verify($password, $user['password'])) {
                if (!$user['is_verified']) $this->redirect('login?error=user_not_verified&email='.$user['email']);
                // Store user data in session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['current_role'] = $user['current_role'];
                $this->redirect('/dashboard');
            } else {
                $this->redirect("login?error=invalid_email_or_password");
            }
        }
    }

    // Destroy session
    public function logout()
    {
        session_start();
        session_destroy();
        $this->redirect('/login');
    }
}
