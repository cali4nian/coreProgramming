<?php
namespace App\Controllers;
class HomeController
{
    public function index()
    {   
        // Prepare data for the home page
        $data = [
            // CSS file URL
            'page_css_url' => '/assets/css/index.css',
            // JS file URL
            'page_js_url' => '/assets/js/index/index.js',
            // Header title for the page
            'header_title' => 'Welcome to Williams Coaching',
        ];

        // Render the template and pass data
        renderTemplate('home.php', $data);
    }
}
