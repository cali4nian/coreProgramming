<?php
namespace App\Models;

use PDO;
use App\Config\Database;

class AuthModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function fetchUserIdByEmail($email) {
        $stmt = $this->db->prepare("SELECT id FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // store reset token
    public function storeResetToken($resetToken, $expiresAt, $email) {
        $stmt = $this->db->prepare("UPDATE users SET reset_token = :token, reset_token_expires = :expires WHERE email = :email");
        $stmt->execute([
            'token' => $resetToken,
            'expires' => $expiresAt,
            'email' => $email
        ]);
    }
}