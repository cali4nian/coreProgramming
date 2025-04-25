<?php
require_once __DIR__ . '/autoload.php'; // Load the autoloader
require_once __DIR__ . '/../app/functions/template.php'; // Include helper function

$routes = [
    // Frontend
    '/'                                => 'App\Controllers\HomeController@index',
    '/about'                           => 'App\Controllers\AboutController@index',
    '/contact'                         => 'App\Controllers\ContactController@index',
    '/contact/message'                 => 'App\Controllers\ContactController@sendMessage',
    '/privacy-policy'                  => 'App\Controllers\LegalPageController@privacy_policy',
    '/terms-of-use'                    => 'App\Controllers\LegalPageController@terms_of_use',
    '/subscribe'                       => 'App\Controllers\SubscriberController@subscribe',
    '/confirm-subscription'            => 'App\Controllers\SubscriberController@confirm',
    'resend-subscription-verification' => 'App\Controllers\auth\SubscriberController@resendToSubscriber',
    // Auth
    '/login'                           => 'App\Controllers\Auth\LoginController@index',
    '/login/request'                   => 'App\Controllers\Auth\LoginController@login',
    '/logout'                          => 'App\Controllers\Auth\LoginController@logout',
    '/forgot-password'                 => 'App\Controllers\Auth\ForgotPasswordController@index',
    '/forgot-password/request'         => 'App\Controllers\Auth\ForgotPasswordController@requestReset',
    '/reset-password'                  => 'App\Controllers\Auth\ResetPasswordController@index',
    '/reset-password/request'          => 'App\Controllers\Auth\ResetPasswordController@reset',
    '/resend-verification'             => 'App\Controllers\Auth\ResendVerificationController@resend',
    '/verify-email'                    => 'App\Controllers\Auth\VerifyEmailController@verify',
    #########################################################################################################################
    // Backend Routes
    '/dashboard'         => 'App\Controllers\DashboardController@index',
    // Profile Management
    '/profile' => 'App\Controllers\ProfileController@index',
    '/profile/update' => 'App\Controllers\ProfileController@updateProfile',
    '/profile/change-password' => 'App\Controllers\ProfileController@changePassword',
    '/profile/delete' => 'App\Controllers\ProfileController@deleteProfile',
    // User Management
    '/admin/users' => 'App\Controllers\UserController@index',
    '/admin/users/edit' => 'App\Controllers\UserController@edit',
    '/admin/users/pause' => 'App\Controllers\UserController@pause',
    '/admin/users/unpause' => 'App\Controllers\UserController@unpause',
    '/admin/users/update' => 'App\Controllers\UserController@update',
    '/admin/users/reset_password' => 'App\Controllers\UserController@resetPassword',
    '/admin/users/add' => 'App\Controllers\UserController@add',
    '/admin/users/delete' => 'App\Controllers\UserController@delete',
    // Subscriber Management
    '/admin/subscribers' => 'App\Controllers\SubscriberController@index',
    '/admin/delete-subscriber' => 'App\Controllers\SubscriberController@deleteSubscriber',
    // Download routes for Subscribers
    '/admin/download-all-subscribers' => 'App\Controllers\SubscriberController@downloadAllSubscribers',
    '/admin/download-confirmed-subscribers' => 'App\Controllers\SubscriberController@downloadConfirmedSubscribers',
    '/admin/download-unconfirmed-subscribers' => 'App\Controllers\SubscriberController@downloadUnconfirmedSubscribers',
    // Settings Management
    '/admin/settings' => 'App\Controllers\SettingController@index',
    '/admin/update-site-settings' => 'App\Controllers\SettingController@updateSiteSettings',
    '/admin/update-social-media-settings' => 'App\Controllers\SettingController@updateSocialMediaSettings',
    '/admin/update-home-page-settings' => 'App\Controllers\SettingController@updateHomePageSettings',
    '/admin/update-about-page-settings' => 'App\Controllers\SettingController@updateAboutPageSettings',
    // Top Players Management
    '/admin/top-players' => 'App\Controllers\TopPlayerController@index',
    '/admin/top-players/create' => 'App\Controllers\TopPlayerController@create',
    '/admin/top-players/edit' => 'App\Controllers\TopPlayerController@edit',
    '/admin/top-players/update' => 'App\Controllers\TopPlayerController@update',
    '/admin/top-players/delete' => 'App\Controllers\TopPlayerController@delete',
    // Message Management
    '/admin/messages' => 'App\Controllers\MessageController@index',
    '/admin/messages/delete' => 'App\Controllers\MessageController@delete',
    '/admin/messages/read' => 'App\Controllers\MessageController@read',
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
