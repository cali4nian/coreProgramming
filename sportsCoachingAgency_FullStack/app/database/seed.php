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

function getRandomPhoneNumber()
{
    $areaCode = rand(200, 999);
    $prefix = rand(200, 999);
    $lineNumber = rand(1000, 9999);
    return "+1-$areaCode-$prefix-$lineNumber";
}

function getRandomPhoneType()
{
    $types = ['home', 'business', 'cell', 'fax', 'other'];
    return $types[array_rand($types)];
}

// ✅ Seed Roles
echo "Seeding roles...\n";
$roles = ['admin', 'coach', 'athlete', 'client'];
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

// Assign admin role to the user
$stmt = $db->prepare("INSERT INTO user_roles (user_id, role_id) VALUES (:user_id, :role_id)");
$stmt->execute([
    'user_id' => $adminId,
    'role_id' => $roleIds['admin'],
]);

echo "✅ Static Admin User Inserted Successfully!\n";

// Add phone numbers for admin
$stmt = $db->prepare("INSERT INTO phone_numbers (user_id, phone_number, type) VALUES (:user_id, :phone_number, :type)");
$stmt->execute([
    'user_id' => $adminId,
    'phone_number' => getRandomPhoneNumber(),
    'type' => getRandomPhoneType(),
]);

// ✅ Seed Static Coach User
echo "Seeding static coach user...\n";
$coachEmail = 'coach@example.com';
$coachPassword = password_hash('password123', PASSWORD_DEFAULT);

$stmt = $db->prepare("INSERT INTO users (name, email, password, current_role) VALUES (:name, :email, :password, :current_role)");
$stmt->execute([
    'name' => 'Coach User',
    'email' => $coachEmail,
    'password' => $coachPassword,
    'current_role' => 'coach', // Set current_role to coach
]);
$coachId = $db->lastInsertId();

// Assign coach role to the user
$stmt = $db->prepare("INSERT INTO user_roles (user_id, role_id) VALUES (:user_id, :role_id)");
$stmt->execute([
    'user_id' => $coachId,
    'role_id' => $roleIds['coach'],
]);

echo "✅ Static Coach User Inserted Successfully!\n";

// Add phone numbers for coach
$stmt = $db->prepare("INSERT INTO phone_numbers (user_id, phone_number, type) VALUES (:user_id, :phone_number, :type)");
$stmt->execute([
    'user_id' => $coachId,
    'phone_number' => getRandomPhoneNumber(),
    'type' => getRandomPhoneType(),
]);

// ✅ Seed Static Athlete User
echo "Seeding static athlete user...\n";
$athleteEmail = 'athlete@example.com';
$athletePassword = password_hash('password123', PASSWORD_DEFAULT);

$stmt = $db->prepare("INSERT INTO users (name, email, password, current_role) VALUES (:name, :email, :password, :current_role)");
$stmt->execute([
    'name' => 'Athlete User',
    'email' => $athleteEmail,
    'password' => $athletePassword,
    'current_role' => 'athlete', // Set current_role to athlete
]);
$athleteId = $db->lastInsertId();

// Assign athlete role to the user
$stmt = $db->prepare("INSERT INTO user_roles (user_id, role_id) VALUES (:user_id, :role_id)");
$stmt->execute([
    'user_id' => $athleteId,
    'role_id' => $roleIds['athlete'],
]);

echo "✅ Static Athlete User Inserted Successfully!\n";

// Add phone numbers for athlete
$stmt = $db->prepare("INSERT INTO phone_numbers (user_id, phone_number, type) VALUES (:user_id, :phone_number, :type)");
$stmt->execute([
    'user_id' => $athleteId,
    'phone_number' => getRandomPhoneNumber(),
    'type' => getRandomPhoneType(),
]);

// ✅ Seed Static Client User
echo "Seeding static client user...\n";
$clientEmail = 'client@example.com';
$clientPassword = password_hash('password123', PASSWORD_DEFAULT);

$stmt = $db->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
$stmt->execute([
    'name' => 'Client User',
    'email' => $clientEmail,
    'password' => $clientPassword,
]);
$clientId = $db->lastInsertId();

// Assign client role to the user
$stmt = $db->prepare("INSERT INTO user_roles (user_id, role_id) VALUES (:user_id, :role_id)");
$stmt->execute([
    'user_id' => $clientId,
    'role_id' => $roleIds['client'],
]);

echo "✅ Static Client User Inserted Successfully!\n";

// Add phone numbers for client
$stmt = $db->prepare("INSERT INTO phone_numbers (user_id, phone_number, type) VALUES (:user_id, :phone_number, :type)");
$stmt->execute([
    'user_id' => $clientId,
    'phone_number' => getRandomPhoneNumber(),
    'type' => getRandomPhoneType(),
]);

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

    // Assign a random role to the user
    $randomRole = array_rand($roleIds); // Randomly select a role
    $currentRole = $randomRole; // Set current_role to match the assigned role

    $stmt = $db->prepare("INSERT INTO users (name, email, password, current_role) VALUES (:name, :email, :password, :current_role)");
    $stmt->execute([
        'name' => $name,
        'email' => $email,
        'password' => $password,
        'current_role' => $currentRole, // Set current_role dynamically
    ]);
    $userId = $db->lastInsertId();

    $stmt = $db->prepare("INSERT INTO user_roles (user_id, role_id) VALUES (:user_id, :role_id)");
    $stmt->execute([
        'user_id' => $userId,
        'role_id' => $roleIds[$randomRole], // Ensure this matches the role ID
    ]);

    // Add 1-3 phone numbers for each user
    $phoneCount = rand(1, 3);
    for ($j = 0; $j < $phoneCount; $j++) {
        $stmt = $db->prepare("INSERT INTO phone_numbers (user_id, phone_number, type) VALUES (:user_id, :phone_number, :type)");
        $stmt->execute([
            'user_id' => $userId,
            'phone_number' => getRandomPhoneNumber(),
            'type' => getRandomPhoneType(),
        ]);
    }
}
echo "✅ 100 Users and Associated Phone Numbers Inserted Successfully!\n";

// Assign a random role to the user
$randomRole = array_rand($roleIds); // Randomly select a role key
$roleId = $roleIds[$randomRole]; // Get the corresponding role ID

$stmt = $db->prepare("INSERT INTO user_roles (user_id, role_id) VALUES (:user_id, :role_id)");
$stmt->execute([
    'user_id' => $userId,
    'role_id' => $roleId, // Now $roleId is defined
]);

echo "✅ Role assigned to user successfully.\n";

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
    ['key_name' => 'tiktok_url', 'value' => 'https://tiktok.com/@sportscoachingagency'],
    ['key_name' => 'youtube_url', 'value' => 'https://youtube.com/sportscoachingagency'],
    ['key_name' => 'snapchat_url', 'value' => 'https://snapchat.com/add/sportscoachingagency'],
    ['key_name' => 'call_now_phone', 'value' => '+1234567890'],
    ['key_name' => 'background_image', 'value' => '/uploads/default_background.jpg'],
    ['key_name' => 'hero_image', 'value' => '/uploads/default_hero.jpg'],
    ['key_name' => 'head_coach_image', 'value' => '/uploads/default_head_coach.jpg'], // Added Head Coach Image
    ['key_name' => 'where_to_start_video', 'value' => 'https://youtube.com/watch?v=example1'],
    ['key_name' => 'main_youtube_video', 'value' => 'https://youtube.com/watch?v=example2'],
    ['key_name' => 'main_instagram_photo', 'value' => '/uploads/default_instagram.jpg'],
    ['key_name' => 'main_facebook_photo', 'value' => '/uploads/default_facebook.jpg'],
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
