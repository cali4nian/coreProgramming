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
                $this->redirect('/users?error=user_not_found');
            }
        }
    }

    public function pause()
    {
        requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $id = $_POST['id'];

            $db = Database::connect();
            $stmt = $db->prepare("UPDATE users SET is_active = 0 WHERE id = :id");
            $stmt->execute(['id' => $id]);

            $this->redirect('/users?success=pause');
        }
    }

    public function unpause()
    {
        requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $id = $_POST['id'];

            $db = Database::connect();
            $stmt = $db->prepare("UPDATE users SET is_active = 1 WHERE id = :id");
            $stmt->execute(['id' => $id]);

            $this->redirect('/users?success=unpaused');
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

            $this->redirect('/users?success=reset_password');
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

            $this->redirect('/users?success=update');
        }
    }

    public function add()
    {
        requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'], $_POST['email'], $_POST['password'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

            $db = Database::connect();
            $stmt = $db->prepare("INSERT INTO users (name, email, password, is_verified, is_active) VALUES (:name, :email, :password, 1, 1)");
            $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);

            // Send confirmation email to the user
            $to = $email;
            $subject = "Welcome to Sports Coaching Agency";
            $message = "Dear $name,\n\nYour account has been created successfully. You can log in with the following credentials:\n\nEmail: $email\nPassword: {$_POST['password']}\n\nPlease change your password after logging in.\n\nBest regards,\nSports Coaching Agency";
            $headers = "From: no-reply@sportscoachingagency.com";

            sendEmail($to, $subject, $message, $headers);

            $this->redirect('/users?success=add');
        }
    }

    
}
