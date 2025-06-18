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
$roles = ['admin', 'super user', 'coach', 'trainer', 'athlete', 'subscriber'];
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
// Change password to a more secure hash when in production
$adminPassword = password_hash('password123', PASSWORD_DEFAULT);

$stmt = $db->prepare("INSERT INTO users (name, email, password, current_role, is_verified) VALUES (:name, :email, :password, :current_role, :is_verified)");
$stmt->execute([
    'name' => 'Admin User',
    'email' => $adminEmail,
    'password' => $adminPassword,
    'current_role' => 'admin', // Set current_role to admin
    'is_verified' => 1, // Mark as verified
]);
$adminId = $db->lastInsertId();

echo "✅ Static Admin User Inserted Successfully!\n";

// ✅ Seed Static Super User
echo "Seeding static super user...\n";
$superUserEmail = 'superuser@example.com';
// Change password to a more secure hash when in production
$superUserPassword = password_hash('password123', PASSWORD_DEFAULT);

$stmt = $db->prepare("INSERT INTO users (name, email, password, current_role, is_verified) VALUES (:name, :email, :password, :current_role, :is_verified)");
$stmt->execute([
    'name' => 'Super User',
    'email' => $superUserEmail,
    'password' => $superUserPassword,
    'current_role' => 'super user', // Set current_role to super user
    'is_verified' => 1, // Mark as verified
]);
$superUserId = $db->lastInsertId();

echo "✅ Static Super User Inserted Successfully!\n";

// ✅ Seed Static Subscriber User
echo "Seeding static subscriber user...\n";
$subscriberEmail = 'subscriber@example.com';
// Change password to a more secure hash when in production
$subscriberPassword = password_hash('password123', PASSWORD_DEFAULT);

$stmt = $db->prepare("INSERT INTO users (name, email, password, current_role, is_verified) VALUES (:name, :email, :password, :current_role, :is_verified)");
$stmt->execute([
    'name' => 'Subscriber User',
    'email' => $subscriberEmail,
    'password' => $subscriberPassword,
    'current_role' => 'subscriber', // Set current_role to subscriber
    'is_verified' => 1, // Mark as verified
]);
$subscriberId = $db->lastInsertId();

echo "✅ Static Subscriber User Inserted Successfully!\n";

// ✅ Seed 100 Random Users
echo "Seeding random users...\n";
$usedEmails = []; // Store generated emails to prevent duplicates

for ($i = 0; $i < 50; $i++) {
    do {
        $name = getRandomName();
        $email = getRandomEmail($name);
    } while (in_array($email, $usedEmails)); // Ensure no duplicates

    $usedEmails[] = $email;
    // Change password to a more secure hash when in production
    $password = password_hash('password123', PASSWORD_DEFAULT);

    // Assign a random role to the user
    $randomRole = array_rand($roles); // Randomly select a role
    $currentRole = $roles[$randomRole]; // Set current_role to match the assigned role

    $stmt = $db->prepare("INSERT INTO users (name, email, password, current_role, is_verified) VALUES (:name, :email, :password, :current_role, :is_verified)");
    $stmt->execute([
        'name' => $name,
        'email' => $email,
        'password' => $password,
        'current_role' => $currentRole, // Set current_role dynamically
        'is_verified' => rand(0, 1), // Randomly mark as verified or not
    ]);
}
echo "✅ 100 Random Users Inserted Successfully!\n";

// ✅ Seed 100 Unique Subscribers
echo "Seeding subscribers...\n";
$usedSubscriberEmails = [];

for ($i = 0; $i < 50; $i++) {
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
echo "✅ 50 Unique Subscribers Inserted Successfully!\n";

// ✅ Seed Default Settings
echo "Seeding default settings...\n";

$defaultSettings = [
    ['key_name' => 'site_name', 'value' => 'Basketball Coaching Agency'],
    ['key_name' => 'site_url', 'value' => 'https://basketball.sorianosoftware.com'],
    ['key_name' => 'business_phone', 'value' => '559-777-9705'],
    ['key_name' => 'twitter_card', 'value' => 'summary_large_image'],
    ['key_name' => 'customer_service_email', 'value' => 'support@basketballcoachingagency.com'],
    ['key_name' => 'facebook_url', 'value' => 'https://facebook.com/basketballcoachingagency'],
    ['key_name' => 'instagram_url', 'value' => 'https://instagram.com/basketballcoachingagency'],
    ['key_name' => 'linkedin_url', 'value' => null],
    ['key_name' => 'youtube_url', 'value' => 'https://youtube.com/basketballcoachingagency'],
    ['key_name' => 'tiktok_url', 'value' => 'https://tiktok.com/@basketballcoachingagency'],
    ['key_name' => 'site_logo', 'value' => '/assets/images/logo.png'],
    ['key_name' => 'site_favicon', 'value' => '/assets/images/favicon.ico'],
    ['key_name' => 'site_description', 'value' => 'Your go-to agency for basketball coaching and training.'],
    ['key_name' => 'site_keywords', 'value' => 'sports, coaching, training, agency'],
    ['key_name' => 'about_page_text_one', 'value' => 'Welcome to Our Website! We are dedicated to helping athletes of all ages reach their full potential. Our team brings years of experience, passion, and expertise to every training session.'],
    ['key_name' => 'about_page_text_two', 'value' => "Our mission is to provide top-notch coaching and resources to help you improve your game and achieve your goals. Whether you're just starting out or looking to take your skills to the next level, we have the tools and knowledge to help you succeed."],
    ['key_name' => 'about_page_text_three', 'value' => 'Join our community and start your journey towards excellence today!']
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

// ✅ Seed Top Players
$players = [
    [
        'first_name' => 'Jalen',
        'last_name' => 'King',
        'position' => 'Guard',
        'team' => 'Fresno Flames',
        'height_ft' => 6,
        'height_in' => 2,
        'weight_lbs' => 185,
        'age' => 20,
        'image_url' => null,
        'games_played' => 28,
        'points_per_game' => 22.4,
        'rebounds_per_game' => 4.5,
        'assists_per_game' => 6.2,
        'steals_per_game' => 2.1,
        'blocks_per_game' => 0.3,
        'field_goal_percentage' => 47.8,
        'three_point_percentage' => 38.5,
        'free_throw_percentage' => 81.2
    ],
    [
        'first_name' => 'Tyrese',
        'last_name' => 'Walker',
        'position' => 'Forward',
        'team' => 'Valley Vipers',
        'height_ft' => 6,
        'height_in' => 7,
        'weight_lbs' => 220,
        'age' => 22,
        'image_url' => null,
        'games_played' => 30,
        'points_per_game' => 18.9,
        'rebounds_per_game' => 8.3,
        'assists_per_game' => 3.1,
        'steals_per_game' => 1.4,
        'blocks_per_game' => 1.2,
        'field_goal_percentage' => 51.6,
        'three_point_percentage' => 35.4,
        'free_throw_percentage' => 76.0
    ],
    [
        'first_name' => 'Marcus',
        'last_name' => 'Lopez',
        'position' => 'Center',
        'team' => 'Kingsway Titans',
        'height_ft' => 6,
        'height_in' => 10,
        'weight_lbs' => 245,
        'age' => 23,
        'image_url' => null,
        'games_played' => 27,
        'points_per_game' => 15.1,
        'rebounds_per_game' => 11.2,
        'assists_per_game' => 2.0,
        'steals_per_game' => 0.8,
        'blocks_per_game' => 2.4,
        'field_goal_percentage' => 56.3,
        'three_point_percentage' => 12.5,
        'free_throw_percentage' => 68.9
    ],
    [
        'first_name' => 'Devon',
        'last_name' => 'Mitchell',
        'position' => 'Guard',
        'team' => 'Ridgecrest Raiders',
        'height_ft' => 5,
        'height_in' => 11,
        'weight_lbs' => 175,
        'age' => 19,
        'image_url' => null,
        'games_played' => 25,
        'points_per_game' => 14.7,
        'rebounds_per_game' => 3.9,
        'assists_per_game' => 7.6,
        'steals_per_game' => 2.5,
        'blocks_per_game' => 0.2,
        'field_goal_percentage' => 44.1,
        'three_point_percentage' => 40.8,
        'free_throw_percentage' => 87.5
    ],
    [
        'first_name' => 'Andre',
        'last_name' => 'Carter',
        'position' => 'Forward',
        'team' => 'Southside Spartans',
        'height_ft' => 6,
        'height_in' => 5,
        'weight_lbs' => 210,
        'age' => 21,
        'image_url' => null,
        'games_played' => 29,
        'points_per_game' => 19.8,
        'rebounds_per_game' => 6.7,
        'assists_per_game' => 4.4,
        'steals_per_game' => 1.9,
        'blocks_per_game' => 0.9,
        'field_goal_percentage' => 49.5,
        'three_point_percentage' => 34.6,
        'free_throw_percentage' => 79.3
    ],
];

$stmt = $db->prepare("
    INSERT INTO top_players (
        first_name, last_name, position, team,
        height_ft, height_in, weight_lbs, age, image_url,
        games_played, points_per_game, rebounds_per_game, assists_per_game,
        steals_per_game, blocks_per_game,
        field_goal_percentage, three_point_percentage, free_throw_percentage
    ) VALUES (
        :first_name, :last_name, :position, :team,
        :height_ft, :height_in, :weight_lbs, :age, :image_url,
        :games_played, :points_per_game, :rebounds_per_game, :assists_per_game,
        :steals_per_game, :blocks_per_game,
        :field_goal_percentage, :three_point_percentage, :free_throw_percentage
    )
");

foreach ($players as $player) $stmt->execute($player);

echo "✅ Seeded top_players table with 5 dummy records including image URLs.\n";

// ✅ Seed Messages
echo "Seeding messages...\n";

// create loop to insert 50 messages
for ($i = 0; $i < 50; $i++) {
    $stmt = $db->prepare("INSERT INTO messages (name, email, message) VALUES (:name, :email, :message)");
    $stmt->execute([
        'name' => getRandomName(),
        'email' => getRandomEmail('user'),
        'message' => 'This is a test message.',
    ]);
}

echo "✅ Messages Inserted Successfully!\n";