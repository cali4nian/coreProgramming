<?php
require_once __DIR__ . '/../config/database.php'; // Adjusted path

use App\Config\Database;

$db = Database::connect();

// Define dummy users
$users = [
    ['name' => 'John Doe', 'email' => 'john@example.com', 'password' => password_hash('password123', PASSWORD_DEFAULT)],
    ['name' => 'Jane Smith', 'email' => 'jane@example.com', 'password' => password_hash('password123', PASSWORD_DEFAULT)],
    ['name' => 'Alice Johnson', 'email' => 'alice@example.com', 'password' => password_hash('password123', PASSWORD_DEFAULT)],
    ['name' => 'Bob Williams', 'email' => 'bob@example.com', 'password' => password_hash('password123', PASSWORD_DEFAULT)],
];

// Insert users into the database
foreach ($users as $user) {
    $stmt = $db->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
    $stmt->execute([
        'name' => $user['name'],
        'email' => $user['email'],
        'password' => $user['password'],
    ]);
}

echo "✅ Dummy users inserted successfully!\n";
