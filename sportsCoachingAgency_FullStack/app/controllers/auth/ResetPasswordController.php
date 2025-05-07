<?php
namespace App\Controllers\Auth;

require_once __DIR__ . '/../../config/Database.php';

use App\Models\AuthModel;
use App\Controllers\BaseController;

class ResetPasswordController extends BaseController
{
    private AuthModel $authModel;

    // Constructor to initialize the AuthModel
    public function __construct()
    {
        $this->authModel = new AuthModel();
    }

    // Method to handle the password reset request
    public function index()
    {
        // Redirect to dashboard if user is logged in
        $this->isLoggedIn();

        if (!isset($_GET['token'])) $this->redirect('login?error=invalid_request');

        $token = $_GET['token'];

        // Verify token in database
        $user = $this->authModel->fetchUserRPC($token);

        if (!$user) $this->redirect('login?error=invalid_request');

        // Fetch settings using the BaseController method
        $settings = $this->fetchSettings();

        // Generate CSRF token for the form
        $csrfToken = $this->generateOrValidateCsrfToken();

        // Prepare data for the reset password page
        $data = [
            'csrf_token' => $csrfToken,
            'token' => $token,
            'page_css_url' => '/assets/css/reset-password.css',
            'page_js_url' => '/assets/js/auth/reset-password.js',
            'header_title' => 'Reset Your Password',
            'settings' => $settings,
        ];

        // Show the password reset form
        renderTemplate('auth/reset-password.php', $data);
    }

    // Method to handle the password reset form submission
    public function reset()
    {
        // Redirect to dashboard if user is logged in
        $this->isLoggedIn();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['token'];
            $newPassword = $_POST['password'];

            if (empty($newPassword) || strlen($newPassword) < 6) $this->redirect('reset-password?token=' . $token . '&error=password_too_short');

            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            $user = $this->authModel->fetchUserRPC($token);

            if (!$user) $this->redirect('login?error=invalid_request');

            // Update password & clear reset token
            $this->authModel->updatePassword($hashedPassword, $user['id']);
            $this->redirect('login?success=password_reset_successful');
        }
    }
}
