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

    // Fetch user by email
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

    // restore reset token
    public function restoreResetToken($newToken, $id) {
        $stmt = $this->db->prepare("UPDATE users SET verification_token = :token WHERE id = :id");
        $stmt->execute([
            'token' => $newToken,
            'id' => $id
        ]);
    }

    // fetch user
    public function fetchUser($email) {
        // Fetch user and their current role
        $stmt = $this->db->prepare("
        SELECT 
            id, 
            name, 
            email, 
            password, 
            is_verified, 
            current_role 
            FROM users
            WHERE email = :email
            LIMIT 1
        ");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // fetch user for ResendVerificationController
    public function fetchUserRVC($email) {
        $stmt = $this->db->prepare("SELECT id, is_verified FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // fetch user for ResetPasswordController
    public function fetchUserRPC($token) {
        $stmt = $this->db->prepare("SELECT id FROM users WHERE reset_token = :token AND reset_token_expires > NOW()");
        $stmt->execute(['token' => $token]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // update password and clear reset token
    public function updatePassword($password, $id) {
        $stmt = $this->db->prepare("UPDATE users SET password = :password, reset_token = NULL, reset_token_expires = NULL WHERE id = :id");
        $stmt->execute([
            'password' => $password,
            'id' => $id
        ]);
    }

    // Fetch user VerifiyEmailController
    public function fetchUserVEC($token) {
        $stmt = $this->db->prepare("SELECT id, email, verification_token FROM users WHERE verification_token = :token AND is_verified = 0");
        $stmt->execute(['token' => $token]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update user to set as verified
    public function updateUserToVerified($id) {
        $stmt = $this->db->prepare("UPDATE users SET is_verified = 1, verification_token = NULL WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }

    // Fetch subscriber by email
    public function fetchSubscriberByEmail($email) {
        $stmt = $this->db->prepare("SELECT id FROM subscribers WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Add subscriber
    public function addSubscriber($email) {
        $stmt = $this->db->prepare("INSERT INTO subscribers (email, confirmation_token, is_confirmed) VALUES (:email, NULL, 1)");
        $stmt->execute(['email' => $email]);
    }

    // Check throttle for login attempts
    function isThrottled($ip, $limit = 5, $minutes = 15): bool {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM login_attempts 
                               WHERE ip_address = ? AND attempt_time > NOW() - INTERVAL ? MINUTE");
        $stmt->execute([$ip, $minutes]);
        return $stmt->fetchColumn() >= $limit;
    }
    
    // Record login attempt
    function recordLoginAttempt($ip): void {
        $stmt = $this->db->prepare("INSERT INTO login_attempts (ip_address, attempt_time) VALUES (?, NOW())");
        $stmt->execute([$ip]);
    }

    // Clear login attempts
    function clearLoginAttempts($ip): void {
        $stmt = $this->db->prepare("DELETE FROM login_attempts WHERE ip_address = ?");
        $stmt->execute([$ip]);
    }
    
}