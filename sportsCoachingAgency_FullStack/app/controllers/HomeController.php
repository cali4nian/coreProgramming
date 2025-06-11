<?php
namespace App\Controllers;

use App\Models\TopPlayerModel;

class HomeController extends BaseController
{
    private TopPlayerModel $topPlayerModel;

    // Constructor to initialize the TopPlayerModel
    public function __construct()
    {
        $this->topPlayerModel = new TopPlayerModel();
    }

    // Method to handle the home page request
    public function index()
    {
        // Start session
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        // Generate CSRF token
        $_SESSION['csrf_token'] = $this->generateOrValidateCsrfToken();

        // Redirect if user is logged in
        $this->isLoggedIn();
        // Fetch settings using the BaseController method
        $settings = $this->fetchSettings();

        // Prepare data for the home page
        $data = [
            'players' => $this->topPlayerModel->getAllTopPlayers() ?? [],
            'page_css_url' => '/assets/css/index.css',
            'page_js_url' => '/assets/js/index/index.js',
            'header_title' => 'Welcome to ' . $settings['site_name'],
            'settings' => $settings ?? [],
            'csrf_token' => $_SESSION['csrf_token'] ?? '',
        ];

        // Render the template and pass data
        renderTemplate('home.php', $data);
    }
}
