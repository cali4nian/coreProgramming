<?php
namespace App\Controllers;
class ContactController
{
    public function index()
    {    
        // Prepare data for the home page
        $data = [
            // CSS file URL
            'page_css_url' => '/assets/css/contact.css',
            // JS file URL
            'page_js_url' => '/assets/js/contact/contact.js',
            // Header title for the page
            'header_title' => 'Contact Williams Coaching',
        ];

        // Render the template and pass data
        renderTemplate('contact.php', $data);
    }
}
