<?php

use App\Config\Database;

return function (PDO $db) {
    // Drop the top_players table if it exists
    $db->exec("DROP TABLE IF EXISTS top_players;");

    // Create the top_players table with player info, stats, and image
    $sql = "CREATE TABLE top_players (
        id INT AUTO_INCREMENT PRIMARY KEY,
        first_name VARCHAR(50) NOT NULL,
        last_name VARCHAR(50) NOT NULL,
        position VARCHAR(20),
        team VARCHAR(100),
        height_ft TINYINT,
        height_in TINYINT,
        weight_lbs INT,
        age INT,
        image_url VARCHAR(255),
        games_played INT DEFAULT 0,
        points_per_game DECIMAL(5,2) DEFAULT 0.00,
        rebounds_per_game DECIMAL(5,2) DEFAULT 0.00,
        assists_per_game DECIMAL(5,2) DEFAULT 0.00,
        steals_per_game DECIMAL(5,2) DEFAULT 0.00,
        blocks_per_game DECIMAL(5,2) DEFAULT 0.00,
        field_goal_percentage DECIMAL(5,2) DEFAULT 0.00,
        three_point_percentage DECIMAL(5,2) DEFAULT 0.00,
        free_throw_percentage DECIMAL(5,2) DEFAULT 0.00,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB;";

    $db->exec($sql);

    echo "✅ top_players table created with image field.\n";
};
