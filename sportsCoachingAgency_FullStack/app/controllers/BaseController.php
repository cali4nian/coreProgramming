<?php
namespace App\Controllers;

use App\Config\Database;
use PDO;

class BaseController
{
  // Method to redirect to a different URL
  protected function redirect($url)
  {
      header('Location: ' . $url);
      exit();
  }

    protected function fetchSettings(): array
    {
        // Connect to the database
        $db = Database::connect();

        // Fetch all settings
        $stmt = $db->query("SELECT key_name, value FROM settings");
        return $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    }
}