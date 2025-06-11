<?php
// Check if a session is already active before starting
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

/**
 * Generate CSRF Token
 */
function generateCsrfToken()
{
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // Generate CSRF token
    return $_SESSION['csrf_token'];
}

/**
 * Validate CSRF Token
 */
function validateCsrfToken($token)
{
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}
