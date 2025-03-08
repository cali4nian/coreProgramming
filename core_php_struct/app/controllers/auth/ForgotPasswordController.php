<?php
namespace App\Controllers\Auth;

require_once __DIR__ . '/../../functions/csrf.php';
require_once __DIR__ . '/../../config/Database.php';

class ForgotPasswordController
{
  public function index()
  {
    // Redirect to dashboard if already logged in
    if (isset($_SESSION['user_id'])) {
      header("Location: /dashboard"); // Redirect to dashboard if logged in
      exit();
    }
    
    // Prepare data for the home page
    $data = [];
    // Render the template and pass data
    renderTemplate('auth/forgot-password.php', $data);
  }
}
