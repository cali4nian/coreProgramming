<?php

use App\Config\Database;

return function (PDO $db) {
  // Drop the login_attempts table
  $db->exec("DROP TABLE IF EXISTS login_attempts");

  // Create the users table
  $sql = "CREATE TABLE login_attempts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ip_address VARCHAR(45) NOT NULL,
    attempt_time DATETIME NOT NULL
  ) ENGINE=InnoDB;";

  $db->exec($sql);

  echo "✅ login_attempts table created successfully.\n";

};
