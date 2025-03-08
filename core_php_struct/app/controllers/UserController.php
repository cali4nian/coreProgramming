<?php
namespace App\Controllers;

use App\Models\UserModel;

class UserController
{
    public function index()
    {
        requireAdmin(); // Only admins can access this page
        
        $userModel = new UserModel();
        $users = $userModel->getAllUsers();

        // Pass data to the view
        renderTemplate('users.php', ['users' => $users]);
    }
}
