<?php
namespace App\Models;

class UserModel extends BaseModel
{
    private string $table = "users"; // Set the table name

    public function getAllUsers(int $limit, int $offset): array
    {
        $stmt = $this->db->prepare("SELECT id, name, email, is_verified, is_active FROM {$this->table} LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getTotalUsers(): int
    {
        $stmt = $this->db->query("SELECT COUNT(*) FROM {$this->table}");
        return (int) $stmt->fetchColumn();
    }

    public function getUserById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public function updateUser(int $id, string $name, string $email, string $role): bool
    {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET name = :name, email = :email, current_role = :role WHERE id = :id");
        return $stmt->execute([
            'name' => $name,
            'email' => $email,
            'role' => $role,
            'id' => $id,
        ]);
    }

    public function updateUserRole(int $userId, string $role): bool
    {
        $stmt = $this->db->prepare("UPDATE user_roles SET role_id = (SELECT id FROM roles WHERE name = :role) WHERE user_id = :user_id");
        return $stmt->execute([
            'role' => $role,
            'user_id' => $userId,
        ]);
    }

    public function deleteUser(int $id): bool
    {
        $stmt = $this->db->prepare("SELECT current_role FROM {$this->table} WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch();

        if ($user && $user['current_role'] === 'admin') {
            return false; // Prevent deletion of admin users
        }

        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function toggleUserStatus(int $id, bool $isActive): bool
    {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET is_active = :is_active WHERE id = :id");
        return $stmt->execute([
            'is_active' => $isActive ? 1 : 0,
            'id' => $id,
        ]);
    }

    public function resetPassword(int $id, string $hashedPassword): bool
    {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET password = :password WHERE id = :id");
        return $stmt->execute([
            'password' => $hashedPassword,
            'id' => $id,
        ]);
    }

    public function addUser(string $name, string $email, string $password, string $role): int
    {
        $stmt = $this->db->prepare("INSERT INTO {$this->table} (name, email, password, current_role, is_verified, is_active) VALUES (:name, :email, :password, :role, 1, 1)");
        $stmt->execute([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'role' => $role,
        ]);
        return (int) $this->db->lastInsertId();
    }
}
