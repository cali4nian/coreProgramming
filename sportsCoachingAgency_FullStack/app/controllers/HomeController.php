<?php
namespace App\Controllers;

use PDO;

class HomeController extends BaseController
{
    public function index()
    {   
        // Fetch settings using the BaseController method
        $settings = $this->fetchSettings();

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
