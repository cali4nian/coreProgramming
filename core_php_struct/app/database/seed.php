<?php
require_once __DIR__ . '/../config/database.php'; // Adjusted path

use App\Config\Database;

$db = Database::connect();

// Define dummy users with roles
$users = [
    ['name' => 'John Doe', 'email' => 'john@example.com', 'password' => password_hash('password123', PASSWORD_DEFAULT), 'role' => 'admin'],
    ['name' => 'Jane Smith', 'email' => 'jane@example.com', 'password' => password_hash('password123', PASSWORD_DEFAULT), 'role' => 'coach'],
    ['name' => 'Alice Johnson', 'email' => 'alice@example.com', 'password' => password_hash('password123', PASSWORD_DEFAULT), 'role' => 'client'],
    ['name' => 'Bob Williams', 'email' => 'bob@example.com', 'password' => password_hash('password123', PASSWORD_DEFAULT), 'role' => 'client'],
];

// Insert users into the database
foreach ($users as $user) {
    $stmt = $db->prepare("INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, :role)");
    $stmt->execute([
        'name' => $user['name'],
        'email' => $user['email'],
        'password' => $user['password'],
        'role' => $user['role'],
    ]);
}

echo "✅ Dummy users inserted successfully!\n";
