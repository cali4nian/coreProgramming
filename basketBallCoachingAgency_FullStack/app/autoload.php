<?php
spl_autoload_register(function ($class) {
    // Remove 'App\' namespace prefix if present
    $class = str_replace('App\\', '', $class);
    // Convert namespace to path
    $class = str_replace('\\', '/', $class);
    // Full file path
    $file = __DIR__ . '/' . $class . '.php';
    if (file_exists($file)) {
        // Enforce case-sensitive match
        $realFile = realpath($file);
        if (basename($realFile) !== basename($file)) {
            die("Autoload error: Case mismatch for class '$class'. Expected file: '$file', found: '$realFile'");
        }
        require_once $file;
    } else {
        die("Autoload error: Class '$class' not found at '$file'");
    }
});
