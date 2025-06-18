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

    // Drop the user_roles table if it exists
    $db->exec("DROP TABLE IF EXISTS user_roles");

    // Create the user_roles table
    $sql = "CREATE TABLE user_roles (
        user_id INT NOT NULL,
        role_id INT NOT NULL,
        PRIMARY KEY (user_id, role_id),
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
        FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE
    ) ENGINE=InnoDB;";

    $db->exec($sql);

    echo "✅ user_roles table created successfully.\n";
};