<?php

use App\Config\Database;

return function (PDO $db) {
    // Drop the phone_numbers table if it exists
    $db->exec("DROP TABLE IF EXISTS phone_numbers");

    // Create the phone_numbers table
    $sql = "CREATE TABLE phone_numbers (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        phone_number VARCHAR(20) NOT NULL,
        type VARCHAR(20) NOT NULL DEFAULT 'cell', -- Changed from ENUM to VARCHAR
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB;";

    $db->exec($sql);
};