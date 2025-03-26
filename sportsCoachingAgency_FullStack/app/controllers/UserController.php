<?php
namespace App\Controllers;

require_once __DIR__ . '/../functions/auth.php';
require_once __DIR__ . '/../models/UserModel.php';

use App\Models\UserModel;

class UserController extends BaseController
{
    private UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        requireAdmin();

        $perPage = 10;
        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $perPage;

        $users = $this->userModel->getAllUsers($perPage, $offset);
        $totalUsers = $this->userModel->getTotalUsers();
        $totalPages = ceil($totalUsers / $perPage);

        $data = [
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

    public function delete(int $id)
    {
        requireAdmin();

        if ($this->userModel->deleteUser($id)) {
            $this->redirect('/admin/users?success=delete');
        } else {
            $this->redirect('/admin/users?error=cannot_delete_admin');
        }
    }

    public function pause(int $id)
    {
        requireAdmin();

        if ($this->userModel->toggleUserStatus($id, false)) {
            $this->redirect('/admin/users?success=pause');
        } else {
            $this->redirect('/admin/users?error=action_failed');
        }
    }

    public function unpause(int $id)
    {
        requireAdmin();

        if ($this->userModel->toggleUserStatus($id, true)) {
            $this->redirect('/admin/users?success=unpause');
        } else {
            $this->redirect('/admin/users?error=action_failed');
        }
    }

    public function resetPassword(int $id)
    {
        requireAdmin();

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

    public function add()
    {
        requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'], $_POST['email'], $_POST['password'])) {
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
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
                $this->redirect('/admin/users?success=add_super_user');
            } else {
                $this->redirect('/admin/users?error=add_failed');
            }
        } else {
            $this->redirect('/admin/users?error=invalid_request');
        }
    }
}
