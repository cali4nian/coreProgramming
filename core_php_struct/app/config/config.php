<?php
require_once __DIR__ . '/../functions/loadEnv.php';

// Load the .env file
loadEnv(__DIR__ . '/../../.env');

// Access environment variables using getenv()
$dbHost = getenv('DB_HOST');
$dbName = getenv('DB_NAME');
$dbUser = getenv('DB_USER');
$dbPass = getenv('DB_PASS');

// Use the variables to configure your app (e.g., database connection)
return [
    'DB_HOST' => $dbHost,
    'DB_NAME' => $dbName,
    'DB_USER' => $dbUser,
    'DB_PASS' => $dbPass
];