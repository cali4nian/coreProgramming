<?php
namespace App\Models;

use App\Config\Database;
use PDO;

abstract class BaseModel
{
    protected PDO $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }
}
