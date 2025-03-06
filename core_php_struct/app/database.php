<?php
$config = include(__DIR__ . '/config.php');

$conn = new mysqli($config['DB_HOST'], $config['DB_USER'], $config['DB_PASS'], $config['DB_NAME']);

if ($conn->connect_error) {
    error_log("Database connection failed: " . $conn->connect_error);
    die("Service unavailable.");
}
// if($conn) echo "working";
// else echo "not working";