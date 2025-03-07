<?php
session_start(); // Ensure session is started

/**
 * Generate and store CSRF token in session
 */
function generateCsrfToken()
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // Generate secure random token
    }
    return $_SESSION['csrf_token'];
}

/**
 * Validate CSRF token submitted via form
 */
function validateCsrfToken($token)
{
    if (!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
        die("CSRF token validation failed.");
    }
}
