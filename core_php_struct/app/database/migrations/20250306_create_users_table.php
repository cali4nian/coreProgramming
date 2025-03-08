<?php

use App\Config\Database;

return function (PDO $db) {
    // Drop the existing users table if it exists
    $db->exec("DROP TABLE IF EXISTS users");

    // Create the users table
    $sql = "CREATE TABLE users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(150) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        role VARCHAR(50) NOT NULL DEFAULT 'user',  -- Change ENUM to VARCHAR
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB;";

    $db->exec($sql);
    echo "✅ users table created successfully.\n";
};
