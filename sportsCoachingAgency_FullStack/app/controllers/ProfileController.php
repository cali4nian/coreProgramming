<?php
namespace App\Controllers;

require_once __DIR__ . '/../functions/auth.php';
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/ProfileModel.php';

use App\Config\Database;
use App\Models\ProfileModel;

class ProfileController
{
    private ProfileModel $profileModel;

    public function __construct()
    {
        $this->profileModel = new ProfileModel(Database::connect());
    }

    /**
     * Display the profile page.
     */
    public function index()
    {
        requireLogin();

        $user = $this->profileModel->getUserById($_SESSION['user_id']);

        if (!$user) {
            header("Location: /errors/404.php");
            exit();
        }

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
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $phoneNumber = trim($_POST['phone_number'] ?? '');
            $address = trim($_POST['address'] ?? '');
            $profileImage = $_FILES['profile_image']['name'] ?? null;

            // Validate inputs
            if (empty($name) || empty($email)) {
                header("Location: /profile?error=Name and email cannot be empty.");
                exit();
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                header("Location: /profile?error=Invalid email format.");
                exit();
            }

            if ($this->profileModel->isEmailTaken($email, $_SESSION['user_id'])) {
                header("Location: /profile?error=Email is already in use.");
                exit();
            }

            // Handle profile image upload
            if ($profileImage) {
                $targetDir = __DIR__ . "/../../public_html/uploads/profile_images/";
                $targetFile = $targetDir . basename($profileImage);
                $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

                // Validate file type
                $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
                if (!in_array($fileType, $allowedTypes)) {
                    header("Location: /profile?error=Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.");
                    exit();
                }

                // Validate file size (e.g., max 2MB)
                if ($_FILES['profile_image']['size'] > 2 * 1024 * 1024) {
                    header("Location: /profile?error=File size exceeds the 2MB limit.");
                    exit();
                }

                // Delete the existing profile image if it exists
                $currentUser = $this->profileModel->getUserById($_SESSION['user_id']);
                if (!empty($currentUser['profile_image'])) {
                    $existingFile = $targetDir . $currentUser['profile_image'];
                    if (file_exists($existingFile)) {
                        unlink($existingFile); // Delete the existing file
                    }
                }

                // Move the uploaded file
                if (!move_uploaded_file($_FILES['profile_image']['tmp_name'], $targetFile)) {
                    header("Location: /profile?error=Failed to upload the profile image.");
                    exit();
                }
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

            header("Location: /profile?success=1");
            exit();
        }
    }

    /**
     * Change the user's password.
     */
    public function changePassword()
    {
        requireLogin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $currentPassword = $_POST['current_password'];
            $newPassword = $_POST['new_password'];
            $confirmPassword = $_POST['confirm_password'];

            // Validate inputs
            if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
                header("Location: /profile?error=All fields are required.");
                exit();
            }

            if ($newPassword !== $confirmPassword) {
                header("Location: /profile?error=New passwords do not match.");
                exit();
            }

            if (strlen($newPassword) < 6) {
                header("Location: /profile?error=Password must be at least 6 characters.");
                exit();
            }

            // Verify current password
            $hashedPassword = $this->profileModel->getPasswordById($_SESSION['user_id']);
            if (!password_verify($currentPassword, $hashedPassword)) {
                header("Location: /profile?error=Current password is incorrect.");
                exit();
            }

            // Update password
            $this->profileModel->updatePassword($_SESSION['user_id'], password_hash($newPassword, PASSWORD_DEFAULT));

            header("Location: /profile?password_changed=1");
            exit();
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

            header("Location: /logout");
            exit();
        }
    }
}
