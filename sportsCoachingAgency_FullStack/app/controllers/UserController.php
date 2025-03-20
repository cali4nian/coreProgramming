<?php
namespace App\Controllers;

require_once __DIR__ . '/../functions/auth.php';
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../functions/email.php';

use App\Config\Database;
use PDO;

class UserController extends BaseController
{
    public function index()
    {
        requireAdmin();

        $db = Database::connect();

        $perPage = 10; // Number of users per page
        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $perPage;

        // Fetch users with pagination
        $stmt = $db->prepare("SELECT id, name, email, is_verified, is_active FROM users LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Get total number of users for pagination
        $stmt = $db->query("SELECT COUNT(*) FROM users");
        $totalUsers = $stmt->fetchColumn();
        $totalPages = ceil($totalUsers / $perPage);

        $data = [
            'users' => $users,
            'totalPages' => $totalPages,
            'currentPage' => $page,
            'header_title' => 'Users',
            'page_css_url' => '/assets/css/users.css',
            'page_js_url' => '/assets/js/backend/users/users.js'
        ];

        renderTemplate('back_pages/users.php', $data);
    }

    public function edit()
    {
        requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $id = $_POST['id'];

            $db = Database::connect();
            $stmt = $db->prepare("SELECT * FROM users WHERE id = :id");
            $stmt->execute(['id' => $id]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                $data = [
                    'user' => $user,
                    'header_title' => 'Edit User',
                    'page_css_url' => '/assets/css/edit-user.css',
                    'page_js_url' => '/assets/js/backend/edit_user/edit_user.js'
                ];
                renderTemplate('back_pages/edit_user.php', $data);
            } else {
                $this->redirect('/admin/users?error=user_not_found');
            }
        }
    }

    public function pause()
    {
        requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $id = $_POST['id'];

            // Debug: Check if the ID is being sent
            if (empty($id)) {
                $this->redirect('/admin/users?error=missing_id');
                return;
            }

            $db = Database::connect();
            $stmt = $db->prepare("UPDATE users SET is_active = 0 WHERE id = :id");
            $result = $stmt->execute(['id' => $id]);

            // Debug: Check if the query executed successfully
            if (!$result) {
                $this->redirect('/admin/users?error=query_failed');
                return;
            }

            $this->redirect('/admin/users?success=pause');
        } else {
            $this->redirect('/admin/users?error=invalid_request');
        }
    }

    public function unpause()
    {
        requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $id = $_POST['id'];

            // Debug: Check if the ID is being sent
            if (empty($id)) {
                $this->redirect('/admin/users?error=missing_id');
                return;
            }

            $db = Database::connect();
            $stmt = $db->prepare("UPDATE users SET is_active = 1 WHERE id = :id");
            $result = $stmt->execute(['id' => $id]);

            // Debug: Check if the query executed successfully
            if (!$result) {
                $this->redirect('/admin/users?error=query_failed');
                return;
            }

            $this->redirect('/admin/users?success=unpaused');
        } else {
            $this->redirect('/admin/users?error=invalid_request');
        }
    }

    public function reset_password()
    {
        requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $id = $_POST['id'];

            // Generate a temporary password
            $tempPassword = bin2hex(random_bytes(4)); // 8 characters long
            $hashedPassword = password_hash($tempPassword, PASSWORD_DEFAULT);

            $db = Database::connect();
            $stmt = $db->prepare("UPDATE users SET password = :password WHERE id = :id");
            $stmt->execute(['password' => $hashedPassword, 'id' => $id]);

            // Fetch the user's email
            $stmt = $db->prepare("SELECT email FROM users WHERE id = :id");
            $stmt->execute(['id' => $id]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // Send the temporary password to the user's email
                $to = $user['email'];
                $subject = "Your Temporary Password";
                $message = "Your temporary password is: $tempPassword, we strongly recommend you to change it after logging in.";
                $headers = "From: no-reply@sportscoachingagency.com";

                sendEmail($to, $subject, $message, $headers);
            }

            $this->redirect('/admin/users?success=reset_password');
        }
    }

    public function update()
    {
        requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $email = $_POST['email'];

            $db = Database::connect();
            $stmt = $db->prepare("UPDATE users SET name = :name, email = :email WHERE id = :id");
            $stmt->execute(['name' => $name, 'email' => $email, 'id' => $id]);

            $this->redirect('/admin/users?success=update');
        }
    }

    public function add()
    {
        requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'], $_POST['email'], $_POST['password'], $_POST['role'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $role = $_POST['role']; // Role selected by the admin (e.g., 'admin', 'coach', 'athlete')

            $db = Database::connect();

            try {
                // Start a transaction
                $db->beginTransaction();

                // Insert the user into the `users` table
                $stmt = $db->prepare("INSERT INTO users (name, email, password, current_role, is_verified, is_active) VALUES (:name, :email, :password, :current_role, 1, 1)");
                $stmt->execute([
                    'name' => $name,
                    'email' => $email,
                    'password' => $password,
                    'current_role' => $role, // Set the current_role
                ]);
                $userId = $db->lastInsertId();

                // Assign the role to the user in the `user_roles` table
                $stmt = $db->prepare("INSERT INTO user_roles (user_id, role_id) VALUES (:user_id, (SELECT id FROM roles WHERE name = :role))");
                $stmt->execute([
                    'user_id' => $userId,
                    'role' => $role,
                ]);

                // Commit the transaction
                $db->commit();

                // Send confirmation email to the user
                $to = $email;
                $subject = "Welcome to Sports Coaching Agency";
                $message = "Dear $name,\n\nYour account has been created successfully. You can log in with the following credentials:\n\nEmail: $email\nPassword: {$_POST['password']}\n\nPlease change your password after logging in.\n\nBest regards,\nSports Coaching Agency";
                $headers = "From: no-reply@sportscoachingagency.com";

                sendEmail($to, $subject, $message, $headers);

                $this->redirect('/admin/users?success=add');
            } catch (\Exception $e) {
                // Rollback the transaction in case of an error
                $db->rollBack();
                $this->redirect('/admin/users?error=add_failed');
            }
        } else {
            $this->redirect('/admin/users?error=invalid_request');
        }
    }
}
