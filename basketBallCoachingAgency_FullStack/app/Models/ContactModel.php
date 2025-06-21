<?php

namespace App\Models;

use PDO;
use App\Config\Database;

class ContactModel
{
    private $db;

    // Constructor to initialize the database connection
    public function __construct()
    {
        $this->db = Database::connect();
    }

    // Save message to the database
    public function saveMessage($name, $email, $message)
    {
        $stmt = $this->db->prepare("INSERT INTO messages (name, email, message) VALUES (:name, :email, :message)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':message', $message);
        return $stmt->execute();
    }

    public function sendEmailNotification($name, $email, $message)
    {
        // Implement email sending logic here (e.g., using PHPMailer or similar library)
        // This is optional and can be customized as per your requirements
    }


}