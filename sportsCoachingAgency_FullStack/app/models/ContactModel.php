<?php

namespace App\Models;

use PDO;
use App\Config\Database;

class ContactModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function saveMessage($name, $email, $message)
    {
        $stmt = $this->db->prepare("INSERT INTO messages (name, email, message) VALUES (:name, :email, :message)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':message', $message);
        return $stmt->execute();
    }


}