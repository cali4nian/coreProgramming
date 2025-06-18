<?php
namespace App\Models;

use App\Config\Database;
use PDO;

class DashboardModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    /**
     * Get the total count of subscribers.
     *
     * @return int
     */
    public function getTotalSubscribers(): int
    {
        $stmt = $this->db->query("SELECT COUNT(*) AS count FROM subscribers");
        return (int) $stmt->fetchColumn();
    }

    /**
     * Get the most recent subscribers.
     *
     * @param int $limit
     * @return array
     */
    public function getRecentSubscribers(int $limit = 10): array
    {
        $stmt = $this->db->prepare("
            SELECT 
                id, 
                email, 
                is_confirmed, 
                is_active, 
                name, 
                subscribed_at, 
                unsubscribed_at, 
                updated_at
            FROM subscribers
            ORDER BY subscribed_at DESC
            LIMIT :limit
        ");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get the current role of a user by their ID.
     *
     * @param int $userId
     * @return string|null
     */
    public function getUserRoleById(int $userId): ?string
    {
        $stmt = $this->db->prepare("SELECT current_role FROM users WHERE id = :id");
        $stmt->execute(['id' => $userId]);
        return $stmt->fetchColumn() ?: null;
    }
}