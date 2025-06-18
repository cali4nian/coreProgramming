<?php
require_once __DIR__ . '/../config/database.php';

use App\Config\Database;

$db = Database::connect();

function getRandomName()
{
    $firstNames = ['John', 'Jane', 'Alice', 'Bob', 'Charlie', 'David', 'Eve', 'Frank', 'Grace', 'Hank'];
    $lastNames = ['Doe', 'Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Garcia', 'Miller', 'Davis', 'Rodriguez'];

    return $firstNames[array_rand($firstNames)] . ' ' . $lastNames[array_rand($lastNames)];
}

function getRandomEmail($name)
{
    $domains = ['example.com', 'test.com', 'mail.com', 'random.org'];
    return strtolower(str_replace(' ', '.', $name)) . rand(1, 1000) . '@' . $domains[array_rand($domains)];
}

function getRandomRole()
{
    $roles = ['admin', 'coach', 'client'];
    return $roles[array_rand($roles)];
}

// ✅ Seed 100 Users
echo "Seeding users...\n";
$usedEmails = []; // Store generated emails to prevent duplicates

for ($i = 0; $i < 100; $i++) {
    do {
        $name = getRandomName();
        $email = getRandomEmail($name);
    } while (in_array($email, $usedEmails)); // Ensure no duplicates

    $usedEmails[] = $email;
    $password = password_hash('password123', PASSWORD_DEFAULT);
    $role = getRandomRole();

    $stmt = $db->prepare("INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, :role)");
    $stmt->execute([
        'name' => $name,
        'email' => $email,
        'password' => $password,
        'role' => $role,
    ]);
}
echo "✅ 100 Users Inserted Successfully!\n";

// ✅ Seed 100 Unique Subscribers
echo "Seeding subscribers...\n";
$usedSubscriberEmails = [];

for ($i = 0; $i < 100; $i++) {
    do {
        $email = getRandomEmail('subscriber');
        
        // Ensure email is not used before
        $stmt = $db->prepare("SELECT COUNT(*) FROM subscribers WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $existsInDb = $stmt->fetchColumn() > 0;

    } while (in_array($email, $usedSubscriberEmails) || $existsInDb); // Ensure no duplicate emails

    $usedSubscriberEmails[] = $email;
    $isConfirmed = rand(0, 1); // 50% chance the subscriber is confirmed
    $confirmationToken = $isConfirmed ? NULL : bin2hex(random_bytes(16));

    $stmt = $db->prepare("INSERT INTO subscribers (email, confirmation_token, is_confirmed) VALUES (:email, :token, :confirmed)");
    $stmt->execute([
        'email' => $email,
        'token' => $confirmationToken,
        'confirmed' => $isConfirmed,
    ]);
}
echo "✅ 100 Unique Subscribers Inserted Successfully!\n";
