<?php
class AuthController
{
    public function register()
    {
        // Prepare data for the home page
        $data = [];
        // Render the template and pass data
        renderTemplate('auth/register.php', $data);
    }

    public function login()
    {
        // Prepare data for the home page
        $data = [];
        // Render the template and pass data
        renderTemplate('auth/login.php', $data);
    }

    public function forgot_password()
    {
        // Prepare data for the home page
        $data = [];
        // Render the template and pass data
        renderTemplate('auth/forgot-password.php', $data);
    }
}
