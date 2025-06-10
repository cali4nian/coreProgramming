<?php

use App\Config\Database;

return function (PDO $db) {
    $db->exec("DROP TABLE IF EXISTS settings");

    $sql = "CREATE TABLE settings (
        id INT AUTO_INCREMENT PRIMARY KEY,
        key_name VARCHAR(100) NOT NULL UNIQUE,
        value TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB;";

    $db->exec($sql);
    echo "✅ settings table created successfully.\n";
};