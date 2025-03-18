<?php
namespace App\Controllers;

use App\Config\Database;
use PDO;

class HomeController
{
    public function index()
    {   
        // Connect to the database
        $db = Database::connect();

        // Fetch all settings
        $stmt = $db->query("SELECT key_name, value FROM settings");
        $settings = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

        // Prepare data for the home page
        $data = [
            // CSS file URL
            'page_css_url' => '/assets/css/index.css',
            // JS file URL
            'page_js_url' => '/assets/js/index/index.js',
            // Header title for the page
            'header_title' => 'Welcome to Williams Coaching',
            // Settings data
            'settings' => $settings,
        ];

        // Render the template and pass data
        renderTemplate('home.php', $data);
    }
}
