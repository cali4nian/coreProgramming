<?php
spl_autoload_register(function ($class) {
    // Convert namespace to file path
    $class = str_replace('App\\', '', $class); // Remove 'App\' namespace
    $class = str_replace('\\', '/', $class);   // Convert namespace separators to directory slashes

    // Define the base directory
    $baseDir = __DIR__ . '/';

    // Full path to the class file
    $file = $baseDir . $class . '.php';

    if (file_exists($file)) {
        require_once $file;
    } else {
        die("Autoload error: Class '$class' not found in expected directories.");
    }
});
