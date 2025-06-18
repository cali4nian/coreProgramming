<?php
namespace App\Controllers;

require_once __DIR__ . '/../functions/auth.php';

class DashboardController
{
    public function index()
    {
        requireLogin(); // Protect dashboard

        renderTemplate('back_pages/dashboard.php');
    }
}
