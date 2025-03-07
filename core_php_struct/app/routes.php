<?php
require_once __DIR__ . '/../app/functions/template.php'; // Include helper function

// Include the controllers
require_once __DIR__ . '/../app/controllers/HomeController.php';
require_once __DIR__ . '/../app/controllers/AboutController.php';
require_once __DIR__ . '/../app/controllers/ContactController.php';

// Auth Controller
require_once __DIR__ . '/../app/controllers/auth/AuthController.php';

$routes = [
    '/'         => 'HomeController@index',    // Call the HomeController's index method
    '/about'    => 'AboutController@index',  // Call the AboutController's index method
    '/contact'  => 'ContactController@index', // Call the ContactController's index method
    // Auth Routes
    '/register' => 'AuthController@register',
    '/login' => 'AuthController@login',
    '/forgot-password' => 'AuthController@forgot_password'
];

// Get the requested URL path
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
// Handle the home route separately
if ($request === '/') {
    $request = '/';
} else {
    $request = rtrim($request, '/'); // Remove trailing slash for other routes
}

// Handle the route by calling the respective controller method
if (array_key_exists($request, $routes)) {
    // Extract controller and method from the route (e.g., 'HomeController@index')
    list($controller, $method) = explode('@', $routes[$request]);

    // Instantiate the controller class and call the method
    $controllerObj = new $controller();
    $controllerObj->$method();
} else {
    // If the route doesn't exist, show a 404 error page
    http_response_code(404);
    renderTemplate('404.php', ['title' => 'Page Not Found']);
}
