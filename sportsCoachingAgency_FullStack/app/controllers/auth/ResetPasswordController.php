<?php
namespace App\Controllers\Auth;

require_once __DIR__ . '/../../config/Database.php';

use App\Models\AuthModel;
use App\Controllers\BaseController;

class ResetPasswordController extends BaseController
{
    private AuthModel $authModel;

    public function __construct()
    {
        $this->authModel = new AuthModel();
    }

    public function index()
    {
        if (!isset($_GET['token'])) $this->redirect('login?error=invalid_request');

        $token = $_GET['token'];

        // Verify token in database
        $user = $this->authModel->fetchUserRPC($token);

        if (!$user) $this->redirect('login?error=invalid_request');

        // Fetch settings using the BaseController method
        $settings = $this->fetchSettings();

        // Prepare data for the reset password page
        $data = [
            'token' => $token,
            'page_css_url' => '/assets/css/reset-password.css',
            'page_js_url' => '/assets/js/auth/reset-password.js',
            'header_title' => 'Reset Your Password',
            'settings' => $settings,
        ];

        // Show the password reset form
        renderTemplate('auth/reset-password.php', $data);
    }

    public function reset()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // UPDATE VALIDATION BEFORE TESTING ON LIVE SERVER
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
