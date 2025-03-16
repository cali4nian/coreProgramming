<?php
namespace App\Controllers;
class AboutController
{
    public function index()
    {   
        // Prepare data for the home page
        $data = [
            // CSS file URL
            'page_css_url' => '/assets/css/about.css',
            // JS file URL
            'page_js_url' => '/assets/js/about/about.js',
            // Header title for the page
            'header_title' => 'About Williams Coaching',
        ];

        // Render the template and pass data
        renderTemplate('about.php', $data);
    }
}
