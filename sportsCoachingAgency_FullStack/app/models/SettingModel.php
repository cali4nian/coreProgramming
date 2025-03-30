<?php
namespace App\Models;

use PDO;
use App\Config\Database;

class SettingModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function getAllSettings(): array
    {
        $stmt = $this->db->query("SELECT key_name, value FROM settings");
        return $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    }

    
}