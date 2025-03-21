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

// ✅ Seed Roles
echo "Seeding roles...\n";
$roles = ['admin', 'super user', 'subscriber'];
$roleIds = [];

foreach ($roles as $role) {
    $stmt = $db->prepare("INSERT INTO roles (name) VALUES (:name)");
    $stmt->execute(['name' => $role]);
    $roleIds[$role] = $db->lastInsertId(); // Store role IDs for later use
}
echo "✅ Roles Inserted Successfully!\n";

// ✅ Seed Static Admin User
echo "Seeding static admin user...\n";
$adminEmail = 'admin@example.com';
$adminPassword = password_hash('password123', PASSWORD_DEFAULT);

$stmt = $db->prepare("INSERT INTO users (name, email, password, current_role) VALUES (:name, :email, :password, :current_role)");
$stmt->execute([
    'name' => 'Admin User',
    'email' => $adminEmail,
    'password' => $adminPassword,
    'current_role' => 'admin', // Set current_role to admin
]);
$adminId = $db->lastInsertId();

echo "✅ Static Admin User Inserted Successfully!\n";

// ✅ Seed Static Super User
echo "Seeding static super user...\n";
$superUserEmail = 'superuser@example.com';
$superUserPassword = password_hash('password123', PASSWORD_DEFAULT);

$stmt = $db->prepare("INSERT INTO users (name, email, password, current_role) VALUES (:name, :email, :password, :current_role)");
$stmt->execute([
    'name' => 'Super User',
    'email' => $superUserEmail,
    'password' => $superUserPassword,
    'current_role' => 'super user', // Set current_role to super user
]);
$superUserId = $db->lastInsertId();

echo "✅ Static Super User Inserted Successfully!\n";

// ✅ Seed Static Subscriber User
echo "Seeding static subscriber user...\n";
$subscriberEmail = 'subscriber@example.com';
$subscriberPassword = password_hash('password123', PASSWORD_DEFAULT);

$stmt = $db->prepare("INSERT INTO users (name, email, password, current_role) VALUES (:name, :email, :password, :current_role)");
$stmt->execute([
    'name' => 'Subscriber User',
    'email' => $subscriberEmail,
    'password' => $subscriberPassword,
    'current_role' => 'subscriber', // Set current_role to subscriber
]);
$subscriberId = $db->lastInsertId();

echo "✅ Static Subscriber User Inserted Successfully!\n";

// ✅ Seed 100 Random Users
echo "Seeding random users...\n";
$usedEmails = []; // Store generated emails to prevent duplicates

for ($i = 0; $i < 100; $i++) {
    do {
        $name = getRandomName();
        $email = getRandomEmail($name);
    } while (in_array($email, $usedEmails)); // Ensure no duplicates

    $usedEmails[] = $email;
    $password = password_hash('password123', PASSWORD_DEFAULT);

    // Assign a random role to the user
    $randomRole = array_rand($roles); // Randomly select a role
    $currentRole = $roles[$randomRole]; // Set current_role to match the assigned role

    $stmt = $db->prepare("INSERT INTO users (name, email, password, current_role) VALUES (:name, :email, :password, :current_role)");
    $stmt->execute([
        'name' => $name,
        'email' => $email,
        'password' => $password,
        'current_role' => $currentRole, // Set current_role dynamically
    ]);
}
echo "✅ 100 Random Users Inserted Successfully!\n";

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

// ✅ Seed Default Settings
echo "Seeding default settings...\n";

$defaultSettings = [
    ['key_name' => 'site_name', 'value' => 'Sports Coaching Agency'],
    ['key_name' => 'customer_service_email', 'value' => 'support@sportscoachingagency.com'],
    ['key_name' => 'facebook_url', 'value' => 'https://facebook.com/sportscoachingagency'],
    ['key_name' => 'twitter_url', 'value' => 'https://twitter.com/sportscoachingagency'],
    ['key_name' => 'instagram_url', 'value' => 'https://instagram.com/sportscoachingagency'],
    ['key_name' => 'linkedin_url', 'value' => 'https://linkedin.com/company/sportscoachingagency'],
    ['key_name' => 'youtube_url', 'value' => 'https://youtube.com/sportscoachingagency'],
];

foreach ($defaultSettings as $setting) {
    $stmt = $db->prepare("INSERT INTO settings (key_name, value) VALUES (:key_name, :value)
                          ON DUPLICATE KEY UPDATE value = :value");
    $stmt->execute([
        'key_name' => $setting['key_name'],
        'value' => $setting['value'],
    ]);
}

echo "✅ Default Settings Inserted Successfully!\n";
