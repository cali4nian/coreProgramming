<?php

use App\Config\Database;

return function (PDO $db) {
    // Drop the user_roles table because it references the users table
    $db->exec("DROP TABLE IF EXISTS user_roles");

    // Drop the users table
    $db->exec("DROP TABLE IF EXISTS users");

    // Create the users table
    $sql = "CREATE TABLE users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(150) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        current_role VARCHAR(50) NOT NULL DEFAULT 'subscriber',
        is_verified TINYINT(1) NOT NULL DEFAULT 0,
        is_active TINYINT(1) NOT NULL DEFAULT 1,
        verification_token VARCHAR(64) NULL,
        reset_token VARCHAR(64) NULL,
        reset_token_expires TIMESTAMP NULL,
        profile_image VARCHAR(255) NULL,
        phone_number VARCHAR(15) NULL,
        address TEXT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB;";

    $db->exec($sql);

    echo "✅ users table created successfully.\n";
};
