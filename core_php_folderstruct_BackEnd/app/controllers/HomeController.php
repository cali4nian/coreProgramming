<?php
namespace App\Controllers;
class HomeController
{
    public function index()
    {   
        // Prepare data for the home page
        $data = [
            'title'   => 'Home Page',
            'message' => 'Welcome to the home page!'
        ];

        // Render the template and pass data
        renderTemplate('home.php', $data);
    }
}
