<?php
namespace App\Controllers;

class AboutController extends BaseController
{
    public function index()
    {   
        // Fetch settings using the BaseController method
        $settings = $this->fetchSettings();

        // Prepare data for the about page
        $data = [
            // CSS file URL
            'page_css_url' => '/assets/css/about.css',
            // JS file URL
            'page_js_url' => '/assets/js/about/about.js',
            // Header title for the page
            'header_title' => 'About Williams Coaching',
            // Settings data
            'settings' => $settings,
        ];

        // Render the template and pass data
        renderTemplate('about.php', $data);
    }
}
