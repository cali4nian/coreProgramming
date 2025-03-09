<?php
require_once __DIR__ . '/autoload.php'; // Load the autoloader
require_once __DIR__ . '/../app/functions/template.php'; // Include helper function

$routes = [
    // Frontend
    '/'                  => 'App\Controllers\HomeController@index',  // Handle home route
    '/about'             => 'App\Controllers\AboutController@index',
    '/contact'           => 'App\Controllers\ContactController@index',

    // Auth
    '/register'          => 'App\Controllers\Auth\RegisterController@index',
    '/register/request'  => 'App\Controllers\Auth\RegisterController@register',
    '/login'             => 'App\Controllers\Auth\LoginController@index',
    '/login/request'     => 'App\Controllers\Auth\LoginController@login',
    '/logout'            => 'App\Controllers\Auth\LoginController@logout',
    '/forgot-password'   => 'App\Controllers\Auth\ForgotPasswordController@index',
    '/reset-password'    => 'App\Controllers\Auth\ResetPasswordController@index',
    // Email Verification Route
    '/verify-email' => 'App\Controllers\Auth\VerifyEmailController@verify',


    // Backend
    '/dashboard'         => 'App\Controllers\DashboardController@index',
    '/profile'           => 'App\Controllers\ProfileController@index',

    // Admin
    '/users'             => 'App\Controllers\UserController@index',
];

// Get the requested URL path
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Special handling for home route `/`
if ($request === '/') {
    $request = '/';
} else {
    $request = rtrim($request, '/'); // Normalize other routes by removing trailing slash
}

// Handle the route by calling the respective controller method
if (array_key_exists($request, $routes)) {
    list($controller, $method) = explode('@', $routes[$request]);

    if (!class_exists($controller)) {
        die("Error: Controller '$controller' not found.");
    }

    $controllerObj = new $controller();
    
    if (!method_exists($controllerObj, $method)) {
        die("Error: Method '$method' not found in $controller.");
    }

    $controllerObj->$method();
} else {
    // If route does not exist, render 404 page
    http_response_code(404);
    renderTemplate('404.php', ['title' => 'Page Not Found']);
}
