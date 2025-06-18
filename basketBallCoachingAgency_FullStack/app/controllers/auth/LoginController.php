<?php
namespace App\Controllers\Auth;

require_once __DIR__ . '/../../functions/csrf.php';
require_once __DIR__ . '/../../config/Database.php';

use App\Models\AuthModel;
use App\Controllers\BaseController;

class LoginController extends BaseController
{

    private AuthModel $authModel;

    // Constructor to initialize AuthModel
    public function __construct()
    {
        $this->authModel = new AuthModel();
    }

    // Render the login page
    public function index()
    {
        // Start session only if not already started
        $this->isSessionOrStart();

        // Redirect to dashboard if already logged in
        $this->isLoggedIn();

        // Generate CSRF token for the login form
        $csrf_token = $this->generateOrValidateCsrfToken();

        // Fetch settings using the BaseController method
        $settings = $this->fetchSettings();

        // Prepare data for the login page
        $data = [
            'csrf_token' => $csrf_token,
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

        // Validate CSRF token and redirect if invalid
        $this->generateOrValidateCsrfToken($_POST['csrf_token'], '/login?error=invalid_request', true);

        $ip = $_SERVER['REMOTE_ADDR'];
        $throttleLimit = $this->authModel->isThrottled($ip, 5, 15);
        if ($throttleLimit) $this->redirect('/login?error=too_many_attempts');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Check if email and password are set
            if (empty($_POST['email']) || empty($_POST['password'])) $this->redirect('/login?error=email_or_password_empty');

            // Assign email and password to variables
            $email = $this->sanitizeEmail($_POST['email']);
            $password = trim($_POST['password']);

            // Fetch user by email
            $user = $this->authModel->fetchUser($email);

            // Check if user exists and password is correct
            if ($user && password_verify($password, $user['password'])) {
                if (!$user['is_verified']) $this->redirect('/login?error=user_not_verified&email='.$user['email']);
                // Start session only if not already started
                $this->isSessionOrStart();
                // Store user data in session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['current_role'] = $user['current_role'];
                $this->authModel->clearLoginAttempts($ip);
                $this->redirect('/dashboard');
            } else {
                // Increment login attempts
                $this->authModel->recordLoginAttempt($ip);
                $this->redirect("/login?error=invalid_email_or_password");
            }
        }
    }

    // Destroy session
    public function logout()
    {
        $this->isNotLoggedIn();
        session_start();
        session_destroy();
        $this->redirect('/login');
    }
}
