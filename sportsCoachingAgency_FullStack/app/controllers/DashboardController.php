<?php
namespace App\Controllers;

require_once __DIR__ . '/../functions/auth.php';

class DashboardController
{
    public function index()
    {
        requireLogin(); // Protect dashboard

        // Prepare data for the home page
        $data = [
            // CSS file URL
            'page_css_url' => '/assets/css/dashboard.css',
            // JS file URL
            'page_js_url' => '/assets/js/dashboard/dashboard.js',
            // Header title for the page
            'header_title' => 'Dashboard',
        ];

        renderTemplate('back_pages/dashboard.php', $data);
    }
}
