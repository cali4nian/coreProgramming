<?php
namespace App\Controllers;

class ContactController extends BaseController
{
    public function index()
    {    
        // Fetch settings using the BaseController method
        $settings = $this->fetchSettings();

        // Prepare data for the contact page
        $data = [
            // CSS file URL
            'page_css_url' => '/assets/css/contact.css',
            // JS file URL
            'page_js_url' => '/assets/js/contact/contact.js',
            // Header title for the page
            'header_title' => 'Contact Williams Coaching',
            // Settings data
            'settings' => $settings,
        ];

        // Render the template and pass data
        renderTemplate('contact.php', $data);
    }
}
