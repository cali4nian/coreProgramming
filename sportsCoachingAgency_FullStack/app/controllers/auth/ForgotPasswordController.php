<?php
namespace App\Controllers\Auth;

require_once __DIR__ . '/../../functions/email.php';
require_once __DIR__ . '/../../config/Database.php';

use App\Models\AuthModel;
use App\Controllers\BaseController;

class ForgotPasswordController extends BaseController
{
    private AuthModel $authModel;

    // Constructor to initialize the AuthModel
    public function __construct()
    {
        $this->authModel = new AuthModel();
    }

    // Method to render the forgot password page
    public function index()
    {
        // Check if session is started, if not, start it
        $this->isSessionOrStart();
        
        // Redirect to dashboard if user is logged in
        $this->isLoggedIn();

        // Get CSRF token
        $csrfToken = $this->generateOrValidateCsrfToken();

        // Fetch settings using the BaseController method
        $settings = $this->fetchSettings();

        // Prepare data for the forgot password page
        $data = [
            'csrf_token' => $csrfToken,
            'page_css_url' => '/assets/css/forgot-password.css',
            'page_js_url' => '/assets/js/auth/forgot-password.js',
            'header_title' => 'Forgot Your Password?',
            'settings' => $settings,
        ];

        renderTemplate('auth/forgot-password.php', $data);
    }

    // Method to handle the password reset request
    public function requestReset()
    {
        // Redirect to dashboard if user is logged in
        $this->isLoggedIn();
        
        // Check CSRF token
        $this->generateOrValidateCsrfToken($_POST['csrf_token'], '/forgot-password?error=invalid_csrf_token', true);

        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $email = $this->sanitizeEmail($_POST['email']);
            
            if (!$email) $this->redirect('/forgot-password?error=invalid_email');
            
            $user = $this->authModel->fetchUserIdByEmail($email);
            
            if (!$user) $this->redirect('/forgot-password?error=invalid_email');

            // Generate reset token & expiration
            $resetToken = bin2hex(random_bytes(32));
            $expiresAt = date('Y-m-d H:i:s', strtotime('+1 hour'));

            // Store reset token
            $this->authModel->storeResetToken($resetToken, $expiresAt, $email);

            // Generate signed reset link
            $resetLink = "http://localhost:8000/reset-password?token=$resetToken";

            if (!file_exists(__DIR__ . '/../../../templates/email/forgot_password_template.html')) $this->redirect('forgot-password?error=system_error_file_not_found');

            $template = file_get_contents(__DIR__ . '/../../../templates/email/forgot_password_template.html');

            // Replace placeholder with actual link
            $emailBody = str_replace("{{reset_link}}", $resetLink, $template);

            // Send email
            $subject = "Reset Your Password";

            // Send email using the sendEmail function from functions/email.php
            if (sendEmail($email, $subject, $emailBody)) $this->redirect('/forgot-password?success=password_reset_email_sent');
            else $this->redirect('/forgot-password?error=system_emailing_error');

        }
    }
}
