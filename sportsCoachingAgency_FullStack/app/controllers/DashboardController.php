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

        // Fetch the current user's role
        $userId = $_SESSION['user_id']; // Assuming user ID is stored in the session
        $stmt = $db->prepare("SELECT current_role FROM users WHERE id = :id");
        $stmt->execute(['id' => $userId]);
        $currentRole = $stmt->fetchColumn();

        // Prepare data based on the user's role
        $data = [
            'currentRole' => $currentRole, // Pass currentRole to the template
            'page_css_url' => '/assets/css/dashboard.css',
            'page_js_url' => '/assets/js/dashboard/dashboard.js',
            'header_title' => 'Dashboard',
            'pageName' => 'Dashboard Overview', // Added pageName
            'pageDescription' => 'Welcome to your dashboard, ' . htmlspecialchars($_SESSION['user_name']) . '. Here you can view your activities and manage your account.', // Added pageDescription
        ];

        switch ($currentRole) {
            case 'admin':
                // Fetch total counts for admin
                $data['totalUsers'] = $db->query("SELECT COUNT(*) AS count FROM users")->fetchColumn();
                $data['totalAthletes'] = $db->query("
                    SELECT COUNT(*) AS count 
                    FROM users 
                    LEFT JOIN user_roles ON users.id = user_roles.user_id
                    LEFT JOIN roles ON user_roles.role_id = roles.id
                    WHERE roles.name = 'athlete'
                ")->fetchColumn();
                $data['totalCoaches'] = $db->query("
                    SELECT COUNT(*) AS count 
                    FROM users 
                    LEFT JOIN user_roles ON users.id = user_roles.user_id
                    LEFT JOIN roles ON user_roles.role_id = roles.id
                    WHERE roles.name = 'coach'
                ")->fetchColumn();

                // Fetch recent users
                $stmt = $db->prepare("
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
                $stmt->execute();
                $data['recentUsers'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                break;

            case 'coach':
                // Fetch data specific to coaches
                $stmt = $db->prepare("
                    SELECT 
                        users.id, 
                        users.name, 
                        users.email, 
                        phone_numbers.phone_number, 
                        phone_numbers.type AS phone_type 
                    FROM users
                    LEFT JOIN user_roles ON users.id = user_roles.user_id
                    LEFT JOIN roles ON user_roles.role_id = roles.id
                    LEFT JOIN phone_numbers ON users.id = phone_numbers.user_id
                    WHERE roles.name = 'athlete'
                ");
                $stmt->execute();
                $data['athletes'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                break;

            case 'athlete':
                // Fetch data specific to athletes
                $stmt = $db->prepare("
                    SELECT 
                        users.id, 
                        users.name, 
                        users.email, 
                        phone_numbers.phone_number, 
                        phone_numbers.type AS phone_type 
                    FROM users
                    LEFT JOIN phone_numbers ON users.id = phone_numbers.user_id
                    WHERE users.id = :id
                ");
                $stmt->execute(['id' => $userId]);
                $data['profile'] = $stmt->fetch(\PDO::FETCH_ASSOC);
                break;

            default:
                // Handle unknown roles
                $data['error'] = 'Unknown role. Please contact the administrator.';
                break;
        }

        // Render the dashboard template with the prepared data
        renderTemplate('back_pages/dashboard.php', $data);
    }
}
