<?php
namespace App\Models;

use App\Config\Database;
use PDO;

class ProfileModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    /**
     * Get user details by ID.
     *
     * @param int $id
     * @return array|null
     */
    public function getUserById(int $id): ?array
    {
        $stmt = $this->db->prepare("
            SELECT 
                id, 
                name, 
                email, 
                current_role, 
                profile_image, 
                phone_number, 
                address, 
                created_at, 
                updated_at 
            FROM users 
            WHERE id = :id
        ");
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }

    /**
     * Check if an email is already taken by another user.
     *
     * @param string $email
     * @param int $excludeId
     * @return bool
     */
    public function isEmailTaken(string $email, int $excludeId): bool
    {
        $stmt = $this->db->prepare("SELECT id FROM users WHERE email = :email AND id != :id");
        $stmt->execute(['email' => $email, 'id' => $excludeId]);
        return (bool) $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Update user details.
     *
     * @param int $id
     * @param string $name
     * @param string $email
     * @param string|null $profileImage
     * @param string|null $phoneNumber
     * @param string|null $address
     * @return void
     */
    public function updateUser(int $id, string $name, string $email, ?string $profileImage, ?string $phoneNumber, ?string $address): void
    {
        $stmt = $this->db->prepare("
            UPDATE users 
            SET 
                name = :name, 
                email = :email, 
                profile_image = :profile_image, 
                phone_number = :phone_number, 
                address = :address 
            WHERE id = :id
        ");
        $stmt->execute([
            'name' => $name,
            'email' => $email,
            'profile_image' => $profileImage,
            'phone_number' => $phoneNumber,
            'address' => $address,
            'id' => $id
        ]);
    }

    /**
     * Get the hashed password of a user by ID.
     *
     * @param int $id
     * @return string|null
     */
    public function getPasswordById(int $id): ?string
    {
        $stmt = $this->db->prepare("SELECT password FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetchColumn() ?: null;
    }

    /**
     * Update the password of a user.
     *
     * @param int $id
     * @param string $hashedPassword
     * @return void
     */
    public function updatePassword(int $id, string $hashedPassword): void
    {
        $stmt = $this->db->prepare("UPDATE users SET password = :password WHERE id = :id");
        $stmt->execute([
            'password' => $hashedPassword,
            'id' => $id
        ]);
    }

    /**
     * Delete a user by ID.
     *
     * @param int $id
     * @return void
     */
    public function deleteUser(int $id): void
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
}