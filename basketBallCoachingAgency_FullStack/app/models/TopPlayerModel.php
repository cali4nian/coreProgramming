<?php

namespace App\Models;

use PDO;
use App\Config\Database;

class TopPlayerModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function getAllTopPlayers()
    {
        $stmt = $this->db->prepare("SELECT * FROM top_players ORDER BY points_per_game DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get a single player by ID
    public function getTopPlayerById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM top_players WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addTopPlayer($data)
    {
        $stmt = $this->db->prepare("INSERT INTO top_players (first_name, last_name, position, team, height_ft, height_in, weight_lbs, points_per_game, assists_per_game, rebounds_per_game, field_goal_percentage, three_point_percentage, image_url) VALUES (:first_name, :last_name, :position, :team, :height_ft, :height_in, :weight_lbs, :points_per_game, :assists_per_game, :rebounds_per_game, :field_goal_percentage, :three_point_percentage, :image_url)");
        return $stmt->execute($data);
    }

    // Update a player by ID
    public function updateTopPlayer($id, $data)
    {
        $stmt = $this->db->prepare("UPDATE top_players SET first_name = :first_name, last_name = :last_name, position = :position, team = :team, height_ft = :height_ft, height_in = :height_in, weight_lbs = :weight_lbs, points_per_game = :points_per_game, assists_per_game = :assists_per_game, rebounds_per_game = :rebounds_per_game, field_goal_percentage = :field_goal_percentage, three_point_percentage = :three_point_percentage, image_url = :image_url WHERE id = :id");
        $data[':id'] = $id;
        return $stmt->execute($data);
    }

    // Delete a player by ID
    public function deleteTopPlayer($id)
    {
        $stmt = $this->db->prepare("DELETE FROM top_players WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

}