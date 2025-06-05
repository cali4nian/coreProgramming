<?php
namespace App\Controllers\Auth;

require_once __DIR__ . '/../../functions/email.php';
require_once __DIR__ . '/../../config/Database.php';

use App\Models\AuthModel;
use App\Controllers\BaseController;

class ResendVerificationController extends BaseController
{
    private AuthModel $authModel;

    // Constructor to initialize the AuthModel
    public function __construct()
    {
        $this->authModel = new AuthModel();
    }

    // Method to handle the resend verification request
    public function resend()
    {
        if (!isset($_GET['email'])) $this->redirect('login?error=invalid_request');

        $email = $this->sanitizeEmail($_GET['email']);

        if (!$email) $this->redirect('login?error=invalid_email');

        // Fetch user by email
        $user = $this->authModel->fetchUserRVC($email);

        if (!$user) $this->redirect('login?error=not_found');
        
        if ($user['is_verified']) $this->redirect('login?success=account_confirmed');

        // Generate new verification token
        $newToken = bin2hex(random_bytes(32));

        // Store the new token in the database
        $this->authModel->restoreResetToken($newToken, $user['id']);

        // Send verification email
        $verificationLink = "http://localhost:8000/verify-email?token=$newToken";

        if (!file_exists(__DIR__ . '/../../../templates/email/confirm_email_template.html')) $this->redirect('forgot-password?error=system');

        $template = file_get_contents(__DIR__ . '/../../../templates/email/confirm_email_template.html');

        // Replace placeholder with actual link
        $subject = "Verify Your Email (Resent)";
        $emailBody = str_replace("{{verification_link}}", $verificationLink, $template);

        // Send email
        if (sendEmail($email, $subject, $emailBody)) $this->redirect('login?success=confirmation_email_sent');
        else $this->redirect('login?error=system_emailing_error');
    }
}
