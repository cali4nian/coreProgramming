<?php

use App\Config\Database;

return function (PDO $db) {
    // Drop the roles table if it exists
    $db->exec("DROP TABLE IF EXISTS roles");

    // Create the roles table
    $sql = "CREATE TABLE roles (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(50) UNIQUE NOT NULL
    ) ENGINE=InnoDB;";

    $db->exec($sql);

    echo "✅ roles table created successfully.\n";
};