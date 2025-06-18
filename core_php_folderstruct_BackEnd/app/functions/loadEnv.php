<?php
// loadEnv.php
function loadEnv($path)
{
    if (!file_exists($path)) {
        die(".env file not found at $path");
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        // Skip comments and empty lines
        if (strpos($line, '#') === 0) {
            continue;
        }

        // Split line into key-value pairs
        list($key, $value) = explode('=', $line, 2);
        
        // Remove any surrounding whitespace
        $key = trim($key);
        $value = trim($value);

        // Set the environment variable
        putenv("$key=$value");
    }
}
