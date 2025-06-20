<?php
spl_autoload_register(function ($class) {
    // Remove 'App\' namespace prefix if present
    $class = str_replace('App\\', '', $class);

    // Convert namespace to path
    $class = str_replace('\\', '/', $class);

    // Lowercase only 'Controllers' part of the path
    // $class = preg_replace_callback('/(^|\/)(Controllers|Models|Config|Database)(\/|$)/', function ($matches) {
    //     return $matches[1] . strtolower($matches[2]) . $matches[3];
    // }, $class);

    // Full file path
    $file = __DIR__ . '/' . $class . '.php';

    if (file_exists($file)) {
        require_once $file;
    } else {
        die("Autoload error: Class '$class' not found at '$file'");
    }
});
