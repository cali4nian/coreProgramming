<?php
namespace App\Controllers;

require_once __DIR__ . '/../functions/auth.php';
require_once __DIR__ . '/../config/Database.php';

use App\Config\Database;

class DashboardController
{
    public function index()
    {
        requireLogin(); // Protect dashboard

        // Connect to the database
        $db = Database::connect();

        // Fetch total counts
        $totalUsers = $db->query("SELECT COUNT(*) AS count FROM users")->fetchColumn();
        $totalAthletes = $db->query("
            SELECT COUNT(*) AS count 
            FROM users 
            LEFT JOIN user_roles ON users.id = user_roles.user_id
            LEFT JOIN roles ON user_roles.role_id = roles.id
            WHERE roles.name = 'athlete'
        ")->fetchColumn();
        $totalCoaches = $db->query("
            SELECT COUNT(*) AS count 
            FROM users 
            LEFT JOIN user_roles ON users.id = user_roles.user_id
            LEFT JOIN roles ON user_roles.role_id = roles.id
            WHERE roles.name = 'coach'
        ")->fetchColumn();

        // Fetch recent users
        $stmt = $db->query("
            SELECT 
                users.id, 
                users.name, 
                users.email, 
                roles.name AS role, 
                users.created_at 
            FROM users
            LEFT JOIN user_roles ON users.id = user_roles.user_id
            LEFT JOIN roles ON user_roles.role_id = roles.id
            ORDER BY users.created_at DESC
            LIMIT 10
        ");
        $recentUsers = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Prepare data for the dashboard
        $data = [
            'page_css_url' => '/assets/css/dashboard.css',
            'page_js_url' => '/assets/js/dashboard/dashboard.js',
            'header_title' => 'Dashboard',
            'totalUsers' => $totalUsers,
            'totalAthletes' => $totalAthletes,
            'totalCoaches' => $totalCoaches,
            'recentUsers' => $recentUsers,
        ];

        renderTemplate('back_pages/dashboard.php', $data);
    }
}
