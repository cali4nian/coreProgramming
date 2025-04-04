<?php
namespace App\Controllers;

require_once __DIR__ . '/../functions/auth.php';
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/ProfileModel.php';

use App\Models\ProfileModel;
use App\Controllers\BaseController;

class ProfileController extends BaseController
{
    private ProfileModel $profileModel;

    public function __construct()
    {
        $this->profileModel = new ProfileModel();
    }

    /**
     * Display the profile page.
     */
    public function index()
    {
        requireLogin();

        $user = $this->profileModel->getUserById($_SESSION['user_id']);

        if (!$user) $this->redirect('/logout');

        $data = [
            'user' => $user,
            'header_title' => 'Profile',
            'page_css_url' => '/assets/css/profile.css',
            'page_js_url' => '/assets/js/backend/profile/profile.js',
            'pageName' => 'Profile Information',
            'pageDescription' => 'Welcome ' . htmlspecialchars($_SESSION['user_name']) . '. Here you can update your personal information.',
        ];

        renderTemplate('back_pages/profile.php', $data);
    }

    /**
     * Update the user's profile information.
     */
    public function updateProfile()
    {
        requireLogin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $this->sanitizeString($_POST['name']);
            $email = $this->sanitizeEmail($_POST['email']);
            $phoneNumber = $this->sanitizePhoneNumber($_POST['phone_number'] ?? '');
            $address = $this->sanitizeString($_POST['address'] ?? '');
            $profileImage = $_FILES['profile_image']['name'] ?? null;

            // Validate inputs
            if (empty($name) || empty($email)) $this->redirect('/profile?error=empty_fields');

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $this->redirect('/profile?error=invalid_email');

            if ($this->profileModel->isEmailTaken($email, $_SESSION['user_id'])) $this->redirect('/profile?error=email_taken');

            // Handle profile image upload
            if ($profileImage) {
                $targetDir = __DIR__ . "/../../public_html/uploads/profile_images/";
                $targetFile = $targetDir . basename($profileImage);
                $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

                // Validate file type
                $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
                if (!in_array($fileType, $allowedTypes)) $this->redirect('/profile?error=invalid_file_type');

                // Validate file size (e.g., max 2MB)
                if ($_FILES['profile_image']['size'] > 2 * 1024 * 1024) $this->redirect('/profile?error=file_too_large');

                // Delete the existing profile image if it exists
                $currentUser = $this->profileModel->getUserById($_SESSION['user_id']);
                if (!empty($currentUser['profile_image'])) {
                    $existingFile = $targetDir . $currentUser['profile_image'];
                    if (file_exists($existingFile)) {
                        unlink($existingFile); // Delete the existing file
                    }
                }

                // Move the uploaded file
                if (!move_uploaded_file($_FILES['profile_image']['tmp_name'], $targetFile)) $this->redirect('/profile?error=upload_failed');
            }

            // Update user in the database
            $this->profileModel->updateUser(
                $_SESSION['user_id'],
                $name,
                $email,
                $profileImage,
                $phoneNumber,
                $address
            );

            // Update session
            $_SESSION['user_name'] = $name;

            $this->redirect('/profile?success=profile_updated');
        }
    }

    /**
     * Change the user's password.
     */
    public function changePassword()
    {
        requireLogin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // UPDATE TO CLEAN PASSWORD
            $currentPassword = $_POST['current_password'];
            $newPassword = $_POST['new_password'];
            $confirmPassword = $_POST['confirm_password'];

            // Validate inputs
            if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) $this->redirect('/profile?error=empty_fields');

            if ($newPassword !== $confirmPassword) $this->redirect('/profile?error=password_mismatch');

            if (strlen($newPassword) < 6) $this->redirect('/profile?error=password_too_short');

            // Verify current password
            $hashedPassword = $this->profileModel->getPasswordById($_SESSION['user_id']);
            if (!password_verify($currentPassword, $hashedPassword)) $this->redirect('/profile?error=incorrect_password');

            // Update password
            $this->profileModel->updatePassword($_SESSION['user_id'], password_hash($newPassword, PASSWORD_DEFAULT));

            $this->redirect('/profile?success=password_changed');
        }
    }

    /**
     * Delete the user's profile.
     */
    public function deleteProfile()
    {
        requireLogin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->profileModel->deleteUser($_SESSION['user_id']);

            // Destroy session
            session_destroy();

            $this->redirect('/logout');
        }
    }
}
