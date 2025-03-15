<?php
namespace App\Controllers;

require_once __DIR__ . '/../functions/auth.php';
require_once __DIR__ . '/../config/Database.php';

use App\Config\Database;
use PDO;

class UserController
{
    public function listUsers()
    {
        requireAdmin();

        $db = Database::connect();

        $perPage = 10; // Number of users per page
        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $perPage;

        // Fetch users with pagination
        $stmt = $db->prepare("SELECT name, email FROM users LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Get total number of users for pagination
        $stmt = $db->query("SELECT COUNT(*) FROM users");
        $totalUsers = $stmt->fetchColumn();
        $totalPages = ceil($totalUsers / $perPage);

        renderTemplate('back_pages/users.php', [
            'users' => $users,
            'totalPages' => $totalPages,
            'currentPage' => $page
        ]);
    }
}
