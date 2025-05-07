<?php
namespace App\Controllers;

class AboutController extends BaseController
{
    // Method to display the about page
    public function index()
    {
        // Redirect to dashboard if user is logged in
        $this->isLoggedIn();
        
        // Fetch settings using the BaseController method
        $settings = $this->fetchSettings();

        // Prepare data for the about page
        $data = [
            'page_css_url' => '/assets/css/about.css',
            'page_js_url' => '/assets/js/about/about.js',
            'header_title' => 'About ' . $settings['site_name'],
            'settings' => $settings,
        ];

        // Render the template and pass data
        renderTemplate('about.php', $data);
    }
}
