<?php
namespace App\Controllers;

require_once __DIR__ . '/../functions/auth.php';
require_once __DIR__ . '/../config/Database.php';

use App\Config\Database;
use PDO;

class UserController
{
    public function index()
    {
        requireAdmin();

        $db = Database::connect();

        $perPage = 10; // Number of users per page
        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $perPage;

        // Fetch users with pagination
        $stmt = $db->prepare("SELECT name, email, is_verified FROM users LIMIT :limit OFFSET :offset");
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
}
