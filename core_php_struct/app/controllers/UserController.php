<?php
namespace App\Controllers;

use App\Models\UserModel;

require_once __DIR__ . '/../functions/auth.php'; // Include auth helper file

class UserController
{
    public function index()
    {
        requireAdmin(); // Only admins can access this page
        
        $userModel = new UserModel();
        $users = $userModel->getAllUsers();

        // Pass data to the view
        renderTemplate('back_pages/users.php', ['users' => $users]);
    }
}
