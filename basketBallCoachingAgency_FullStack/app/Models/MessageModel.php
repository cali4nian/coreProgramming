<?php

namespace App\Models;

use PDO;
use App\Config\Database;

class MessageModel
{
    private $db;

    // Constructor to initialize the database connection
    public function __construct()
    {
        $this->db = Database::connect();
    }

    // Method to get all messages
    public function getAllMessages()
    {
        $stmt = $this->db->query("SELECT * FROM messages ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Method to get a message by ID
    public function getMessageById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM messages WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Method to delete a message by ID
    public function deleteMessageById($id)
    {
        $stmt = $this->db->prepare("DELETE FROM messages WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

}