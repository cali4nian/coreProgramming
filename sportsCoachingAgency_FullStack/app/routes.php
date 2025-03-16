<?php
require_once __DIR__ . '/autoload.php'; // Load the autoloader
require_once __DIR__ . '/../app/functions/template.php'; // Include helper function

$routes = [
    // Frontend
    '/'                  => 'App\Controllers\HomeController@index',
    '/privacy-policy'    => 'App\Controllers\LegalPagesController@privacy_policy',
    '/terms-of-use'      => 'App\Controllers\LegalPagesController@terms_of_use',
    '/about'             => 'App\Controllers\AboutController@index',
    '/contact'           => 'App\Controllers\ContactController@index',
    '/subscribe' => 'App\Controllers\SubscriberController@subscribe',
    '/confirm-subscription' => 'App\Controllers\SubscriberController@confirm',
    // Auth
    '/register'          => 'App\Controllers\Auth\RegisterController@index',
    '/register/request'  => 'App\Controllers\Auth\RegisterController@register',
    '/login'             => 'App\Controllers\Auth\LoginController@index',
    '/login/request'     => 'App\Controllers\Auth\LoginController@login',
    '/logout'            => 'App\Controllers\Auth\LoginController@logout',
    '/forgot-password'   => 'App\Controllers\Auth\ForgotPasswordController@index',
    '/reset-password'    => 'App\Controllers\Auth\ResetPasswordController@index',
    '/forgot-password' => 'App\Controllers\Auth\ForgotPasswordController@index',
    '/forgot-password/request' => 'App\Controllers\Auth\ForgotPasswordController@requestReset',
    '/reset-password' => 'App\Controllers\Auth\ResetPasswordController@index',
    '/reset-password/request' => 'App\Controllers\Auth\ResetPasswordController@reset',
    '/resend-verification' => 'App\Controllers\Auth\ResendVerificationController@resend',
    // Email Verification Route
    '/verify-email' => 'App\Controllers\Auth\VerifyEmailController@verify',
    // Backend
    '/dashboard'         => 'App\Controllers\DashboardController@index',
    // User Profile Management
    '/profile' => 'App\Controllers\ProfileController@profile',
    '/profile/update' => 'App\Controllers\ProfileController@updateProfile',
    '/profile/change-password' => 'App\Controllers\ProfileController@changePassword',
    '/profile/delete' => 'App\Controllers\ProfileController@deleteProfile',
    // Admin User Management
    '/users' => 'App\Controllers\UserController@index',
    // Admin Subscriber Management
    '/admin/subscribers' => 'App\Controllers\SubscriberController@listSubscribers',
    '/admin/delete-subscriber' => 'App\Controllers\SubscriberController@deleteSubscriber',
    // Download routes for Subscribers
    '/admin/download-all-subscribers' => 'App\Controllers\SubscriberController@downloadAllSubscribers',
    '/admin/download-confirmed-subscribers' => 'App\Controllers\SubscriberController@downloadConfirmedSubscribers',
    '/admin/download-unconfirmed-subscribers' => 'App\Controllers\SubscriberController@downloadUnconfirmedSubscribers',
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
