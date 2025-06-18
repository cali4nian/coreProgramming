<?php
namespace App\Controllers\Auth;

require_once __DIR__ . '/../../config/Database.php';

use App\Models\AuthModel;
use App\Controllers\BaseController;

class VerifyEmailController extends BaseController
{
    private AuthModel $authModel;

    // Constructor to initialize the AuthModel
    public function __construct()
    {
        $this->authModel = new AuthModel();
    }

    // Method to handle the email verification process
    public function verify()
    {
        if (!isset($_GET['token'])) $this->redirect('/login?error=invalid_request');

        $token = $_GET['token'];

        // Check if the token exists and the user is not verified
        $user = $this->authModel->fetchUserVEC($token);

        if ($user) {
            // Update user to set as verified
            $this->authModel->updateUserToVerified($user['id']);

            // Automatically add the user to the subscribers table after email is verified
            // Check if the user already exists in the subscribers table
            $existingSubscriber = $this->authModel->fetchSubscriberByEmail($user['email']);

            if (!$existingSubscriber) $this->authModel->addSubscriber($user['email']);

            // Redirect to login page with a success message
            $this->redirect('/login?success=account_confirmed');

        } else {
            // Redirect to login page with an error message
            $this->redirect('/login?error=invalid_request');
        }
    }
}
