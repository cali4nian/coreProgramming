<?php

use App\Config\Database;

return function (PDO $db) {
    $db->exec("DROP TABLE IF EXISTS subscribers");

    $sql = "CREATE TABLE subscribers (
        id INT AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(150) UNIQUE NOT NULL,
        confirmation_token VARCHAR(64) DEFAULT NULL,
        is_confirmed TINYINT(1) DEFAULT 0,
        subscribed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB;";

    $db->exec($sql);
    echo "✅ subscribers table created successfully.\n";
};
