<?php

namespace App\Models;

use PDO;
use App\Config\Database;

class SubscriberModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function deleteSubscriber($id) {
      $stmt = $this->db->prepare("DELETE FROM subscribers WHERE id = :id");
      $stmt->execute(['id' => $id]);
    }

    public function setNewToken($newToken, $id) {
      $stmt = $this->db->prepare("UPDATE subscribers SET confirmation_token = :token WHERE id = :id");
        $stmt->execute([
            'token' => $newToken,
            'id' => $id
        ]);
    }

    public function getSubscriberByEmail($email) {
      $stmt = $this->db->prepare("SELECT id, confirmation_token, is_confirmed FROM subscribers WHERE email = :email");
      $stmt->execute(['email' => $email]);
      return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addSubscriber($email)
    {
        // Insert a new subscriber into the database
        $stmt = $this->db->prepare("INSERT INTO subscribers (email, is_confirmed, subscribed_at) VALUES (:email, 0, NOW())");
        $stmt->bindParam(':email', $email);
        return $stmt->execute();
    }

    public function getAllSubscribersWithPagination($perPage, $offset)
    {
        // Fetch subscribers with pagination
        $stmt = $this->db->prepare("SELECT id, email, is_confirmed, subscribed_at FROM subscribers LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalSubscribers()
    {
        // Get the total number of subscribers
        $stmt = $this->db->query("SELECT COUNT(*) FROM subscribers");
        return $stmt->fetchColumn();
    }

    public function getAllSubscribers() {
        $stmt = $this->db->query("SELECT * FROM subscribers");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllConfirmedSubscribers() {
        $stmt = $this->db->prepare("SELECT id, email, is_confirmed, subscribed_at FROM subscribers WHERE is_confirmed = 1");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllUnconfirmedSubscribers() {
        $stmt = $this->db->prepare("SELECT id, email, is_confirmed, subscribed_at FROM subscribers WHERE is_confirmed = 0");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function confirmSubscriber($email) {
        $stmt = $this->db->prepare("UPDATE subscribers SET is_confirmed = 1 WHERE email = :email");
        $stmt->execute(['email' => $email]);
    }

}