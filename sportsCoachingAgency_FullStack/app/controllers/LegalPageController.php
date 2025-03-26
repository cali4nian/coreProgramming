<?php
namespace App\Controllers;

class LegalPageController extends BaseController
{
    public function privacy_policy()
    {    
        // Fetch settings using the BaseController method
        $settings = $this->fetchSettings();

        // Prepare data for the privacy policy page
        $data = [
            // CSS file URL
            'page_css_url' => '/assets/css/privacy-policy.css',
            // JS file URL
            'page_js_url' => '/assets/js/contact/privacy-policy.js',
            // Header title for the page
            'header_title' => 'Williams Coaching Privacy Policy Agreement',
            // Settings data
            'settings' => $settings,
        ];

        // Render the template and pass data
        renderTemplate('privacy-policy.php', $data);
    }

    public function terms_of_use()
    {    
        // Fetch settings using the BaseController method
        $settings = $this->fetchSettings();

        // Prepare data for the terms of use page
        $data = [
            // CSS file URL
            'page_css_url' => '/assets/css/terms-of-use.css',
            // JS file URL
            'page_js_url' => '/assets/js/contact/terms-of-use.js',
            // Header title for the page
            'header_title' => 'Williams Coaching Terms Of Use Agreement',
            // Settings data
            'settings' => $settings,
        ];

        // Render the template and pass data
        renderTemplate('terms-of-use.php', $data);
    }
}