<?php
namespace App\Controllers;

require_once __DIR__ . '/../functions/auth.php';
require_once __DIR__ . '/../config/Database.php';

use App\Config\Database;

class DashboardController
{
    public function index()
    {
        // Ensure the user is logged in
        requireLogin();

        // Connect to the database
        $db = Database::connect();

        // Fetch the current user's role
        $userId = $_SESSION['user_id']; // Assuming user ID is stored in the session
        $stmt = $db->prepare("SELECT current_role FROM users WHERE id = :id");
        $stmt->execute(['id' => $userId]);
        $currentRole = $stmt->fetchColumn();

        // Prepare data for the dashboard
        $data = [
            'currentRole' => $currentRole, // Pass currentRole to the template
            'page_css_url' => '/assets/css/dashboard.css', // Dynamically set CSS file
            'page_js_url' => '/assets/js/dashboard/dashboard.js',
            'header_title' => 'Dashboard',
            'pageName' => 'Dashboard Overview',
            'pageDescription' => 'Welcome to your dashboard, ' . htmlspecialchars($_SESSION['user_name']) . '. Here you can view your activities and manage your account.',
        ];

        // Fetch total count of subscribers
        $data['totalSubscribers'] = $db->query("SELECT COUNT(*) AS count FROM subscribers")->fetchColumn();

        // Fetch all fields for recent subscribers
        $stmt = $db->prepare("
            SELECT 
                id, 
                email, 
                is_confirmed, 
                is_active, 
                name, 
                subscribed_at, 
                unsubscribed_at, 
                updated_at
            FROM subscribers
            ORDER BY subscribed_at DESC
            LIMIT 10
        ");
        $stmt->execute();
        $data['recentSubscribers'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Render the dashboard template with the prepared data
        renderTemplate('back_pages/dashboard.php', $data);
    }
}
