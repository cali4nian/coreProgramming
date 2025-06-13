<?php
namespace App\Controllers;

require_once __DIR__ . '/../functions/auth.php';
require_once __DIR__ . '/../functions/email.php';
require_once __DIR__ . '/../models/UserModel.php';

use App\Models\UserModel;

class UserController extends BaseController
{
    private UserModel $userModel;

    // Constructor to initialize UserModel
    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // Method to handle user management
    public function index()
    {
        // Check if the user is logged in and session is started
        $this->isSessionOrStart();
        $this->isNotLoggedIn();
        isAdminOrSuper();

        // Generate CSRF token for the session
        $csrfToken = $this->generateOrValidateCsrfToken();

        $perPage = 10;
        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $perPage;

        $users = $this->userModel->getAllUsers($perPage, $offset);
        $totalUsers = $this->userModel->getTotalUsers();
        $totalPages = ceil($totalUsers / $perPage);

        $userId = $_SESSION['user_id'];
        $currentRole = $this->userModel->getUserRoleById($userId);

        $data = [
            'csrf_token' => $csrfToken,
            'currentRole' => $currentRole,
            'users' => $users,
            'totalPages' => $totalPages,
            'currentPage' => $page,
            'header_title' => 'Users',
            'page_css_url' => '/assets/css/users.css',
            'page_js_url' => '/assets/js/backend/users/users.js',
            'pageName' => 'User Management',
            'pageDescription' => 'Manage all users, including their roles, statuses, and account details.',
        ];

        renderTemplate('back_pages/users.php', $data);
    }

    // Method to handle deleting a user
    public function delete()
    {
        // Check if the user is logged in and session is started
        $this->isSessionOrStart();
        $this->isNotLoggedIn();
        isAdminOrSuper();

        // Validate CSRF token
        $this->generateOrValidateCsrfToken($_POST['csrf_token'], '/admin/users?error=invalid_request', true);

        $id = $_POST['id'] ?? null;
        if (!$id) $this->redirect('/admin/users?error=invalid_request');
        if ($this->userModel->deleteUser($id)) $this->redirect('/admin/users?success=user_deleted');
        else $this->redirect('/admin/users?error=cannot_delete_admin');
    }

    // Method to handle pausing a user (deactivating)
    public function pause()
    {
        // Check if the user is logged in and session is started
        $this->isSessionOrStart();
        $this->isNotLoggedIn();
        isAdminOrSuper();

        // Validate CSRF token
        $this->generateOrValidateCsrfToken($_POST['csrf_token'], '/admin/users?error=invalid_request', true);

        $id = $_POST['id'] ?? null;
        if (!$id) $this->redirect('/admin/users?error=invalid_request');
        if ($this->userModel->toggleUserStatus($id, false)) $this->redirect('/admin/users?success=user_paused');
        else $this->redirect('/admin/users?error=action_failed');
    }

    // Method to handle unpausing a user (activating)
    public function unpause()
    {
        // Check if the user is logged in and session is started
        $this->isSessionOrStart();
        $this->isNotLoggedIn();
        isAdminOrSuper();

        // Validate CSRF token
        $this->generateOrValidateCsrfToken($_POST['csrf_token'], '/admin/users?error=invalid_request', true);
        $id = $_POST['id'] ?? null;
        if (!$id) $this->redirect('/admin/users?error=invalid_request');
        if ($this->userModel->toggleUserStatus($id, true)) $this->redirect('/admin/users?success=user_unpaused');
        else $this->redirect('/admin/users?error=action_failed');
    }

    // Method to handle changing a user's role
    public function resetPassword()
    {
        // Check if the user is logged in and session is started
        $this->isSessionOrStart();
        $this->isNotLoggedIn();
        isAdminOrSuper();

        // Validate CSRF token
        $this->generateOrValidateCsrfToken($_POST['csrf_token'], '/admin/users?error=invalid_request', true);

        $id = $_POST['id'] ?? null;
        if (!$id) $this->redirect('/admin/users?error=invalid_request');

        $tempPassword = bin2hex(random_bytes(4)); // 8 characters long
        $hashedPassword = password_hash($tempPassword, PASSWORD_DEFAULT);

        if ($this->userModel->resetPassword($id, $hashedPassword)) {
            $user = $this->userModel->getUserById($id);
            if ($user) {
                sendEmail(
                    $user['email'],
                    "Your Temporary Password",
                    "Your temporary password is: $tempPassword. Please change it after logging in."
                );
            }
            $this->redirect('/admin/users?success=reset_password');
        } else {
            $this->redirect('/admin/users?error=reset_failed');
        }
    }

    // Method to handle adding a new super user
    public function add()
    {
        // Check if the user is logged in and session is started
        $this->isSessionOrStart();
        $this->isNotLoggedIn();
        isAdminOrSuper();

        // Validate CSRF token
        $this->generateOrValidateCsrfToken($_POST['csrf_token'], '/admin/users?error=invalid_request', true);

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'], $_POST['email'], $_POST['password'])) {
            $name = $this->sanitizeString($_POST['name']);
            $email = $this->sanitizeEmail($_POST['email']);
            $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
            $role = 'super user'; // Hardcoded role as 'super user'

            // Use UserModel to add the super user
            $userId = $this->userModel->addUser($name, $email, $password, $role);

            if ($userId) {
                // Send a welcome email to the new super user
                sendEmail(
                    $email,
                    "Welcome to Sports Coaching Agency",
                    "Dear $name,\n\nYour super user account has been created successfully. You can log in with the following credentials:\n\nEmail: $email\nPassword: {$_POST['password']}\n\nPlease change your password after logging in."
                );
                $this->redirect('/admin/users?success=added_super_user');
            } else {
                $this->redirect('/admin/users?error=add_failed');
            }
        } else {
            $this->redirect('/admin/users?error=invalid_request');
        }
    }

    // Method to handle editing a user
    public function edit()
    {
        // Check if the user is logged in and session is started
        $this->isSessionOrStart();
        $this->isNotLoggedIn();
        isAdminOrSuper();

        // Validate CSRF token
        $this->generateOrValidateCsrfToken($_POST['csrf_token'], '/admin/users?error=invalid_request', true);

        $id = $_POST['id'] ?? null;
        if (!$id) $this->redirect('/admin/users?error=invalid_request');

        $user = $this->userModel->getUserById($id);
        if (!$user) $this->redirect('/admin/users?error=user_not_found');

        renderTemplate('back_pages/edit_user.php', [
            'csrf_token' => $_SESSION['csrf_token'],
            'pageName' => 'Edit User',
            'pageDescription' => 'Edit user details and roles.',
            'header_title' => 'Edit User',
            'page_css_url' => '/assets/css/edit-user.css',
            'page_js_url' => '/assets/js/backend/edit_user/edit_user.js',
            'user' => $user,
            'currentRole' => $_SESSION['current_role'],
        ]);
    }

    // Method to handle updating a user
    public function update()
    {
        // Check if the user is logged in and session is started
        $this->isSessionOrStart();
        $this->isNotLoggedIn();
        isAdminOrSuper();

        // Validate CSRF token
        $this->generateOrValidateCsrfToken($_POST['csrf_token'], '/admin/users?error=invalid_request', true);

        $id = strip_tags($_POST['id']) ?? null;
        if (!$id) $this->redirect('/admin/users?error=invalid_request');

        $name = $this->sanitizeString($_POST['name']);
        $email = $this->sanitizeEmail($_POST['email']);
        $role = $_POST['role'] ?? null;

        if ($this->userModel->updateUser($id, $name, $email, $role)) {
            if ($role) {
                $this->userModel->updateUserRole($id, $role);
            }
            $this->redirect('/admin/users?success=user_updated');
        } else {
            $this->redirect('/admin/users?error=update_failed');
        }
    }
}
