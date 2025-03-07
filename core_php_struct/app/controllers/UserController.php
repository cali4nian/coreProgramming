<?php
namespace App\Controllers;

use App\Models\UserModel;

class UserController
{
    public function index()
    {
        $userModel = new UserModel();
        $users = $userModel->getAllUsers();

        // Pass data to the view
        renderTemplate('users.php', ['users' => $users]);
    }
}
