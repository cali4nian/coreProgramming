<?php
namespace App\Controllers;

class LegalPageController extends BaseController
{
    // Method to display the privacy policy page
    public function privacy_policy()
    {
        // Redirect if user is logged in
        $this->isLoggedIn();
        
        // Fetch settings using the BaseController method
        $settings = $this->fetchSettings();

        // Prepare data for the privacy policy page
        $data = [
            'page_css_url' => '/assets/css/privacy-policy.css',
            'page_js_url' => '/assets/js/contact/privacy-policy.js',
            'header_title' => $settings['site_name'] . ' Privacy Policy Agreement',
            'settings' => $settings,
        ];

        // Render the template and pass data
        renderTemplate('privacy-policy.php', $data);
    }

    // Method to display the terms of use page
    public function terms_of_use()
    {
        // Redirect if user is logged in
        $this->isLoggedIn();

        // Fetch settings using the BaseController method
        $settings = $this->fetchSettings();

        // Prepare data for the terms of use page
        $data = [
            'page_css_url' => '/assets/css/terms-of-use.css',
            'page_js_url' => '/assets/js/contact/terms-of-use.js',
            'header_title' => $settings['site_name'] . ' Terms Of Use Agreement',
            'settings' => $settings,
        ];

        // Render the template and pass data
        renderTemplate('terms-of-use.php', $data);
    }
}