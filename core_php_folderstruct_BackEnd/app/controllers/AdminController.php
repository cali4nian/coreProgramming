<?php
namespace App\Controllers;

require_once __DIR__ . '/../functions/auth.php';

class AdminController
{
    public function index()
    {
        requireAdmin(); // Only admins can access this page

        echo "Welcome to the Admin Panel!";
        echo "<br><a href='/logout'>Logout</a>";
    }
}
