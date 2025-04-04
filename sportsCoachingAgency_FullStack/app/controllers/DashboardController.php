<?php
namespace App\Controllers;

require_once __DIR__ . '/../functions/auth.php';
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/DashboardModel.php';

use App\Models\DashboardModel;

class DashboardController
{
    private DashboardModel $dashboardModel;

    public function __construct()
    {
        // Initialize the DashboardModel with the database connection
        $this->dashboardModel = new DashboardModel();
    }

    public function index()
    {
        // Ensure the user is logged in
        requireLogin();

        // Fetch the current user's role
        $userId = $_SESSION['user_id']; // Assuming user ID is stored in the session
        $currentRole = $this->dashboardModel->getUserRoleById($userId);

        // Prepare data for the dashboard
        $data = [
            'currentRole' => $currentRole, // Pass currentRole to the template
            'page_css_url' => '/assets/css/dashboard.css', // Dynamically set CSS file
            'page_js_url' => '/assets/js/dashboard/dashboard.js',
            'header_title' => 'Dashboard',
            'pageName' => 'Dashboard Overview',
            'pageDescription' => 'Welcome to your dashboard, ' . htmlspecialchars($_SESSION['user_name']) . '. Here you can view your activities and manage your account.',
        ];

        if(isAdminOrSuper()) {
            $data['isAdminOrSuper'] = true; // Set flag for admin or super user
            // Fetch total count of subscribers
            $data['totalSubscribers'] = $this->dashboardModel->getTotalSubscribers();
            // Fetch recent subscribers
            $data['recentSubscribers'] = $this->dashboardModel->getRecentSubscribers();
        } else {
            $data['isAdminOrSuper'] = false; // Set flag for non-admin users
        }

        // Render the dashboard template with the prepared data
        renderTemplate('back_pages/dashboard.php', $data);
    }
}
