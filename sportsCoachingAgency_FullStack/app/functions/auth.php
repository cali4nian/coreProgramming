<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start(); // Ensure session is started
}

// Function to protect routes that require authentication
function requireLogin()
{
    if (!isset($_SESSION['user_id'])) {
        header("Location: /login");
        exit();
    }
}

// Function to protect admin-only routes
function requireAdmin()
{
    requireLogin(); // Ensure user is logged in first
    if (!isset($_SESSION['current_role']) || $_SESSION['current_role'] !== 'admin') {
        header("Location: /dashboard"); // Redirect unauthorized users to the dashboard
        exit();
    }
}

// Function to protect super-user-only routes
function requireSuper()
{
    requireLogin(); // Ensure user is logged in first
    if (!isset($_SESSION['current_role']) || $_SESSION['current_role'] !== 'super user') {
        header("Location: /dashboard"); // Redirect unauthorized users to the dashboard
        exit();
    }
}

// Function to protect admin-only routes
function requireAdminOrSuper()
{
    requireLogin(); // Ensure user is logged in first
    if (!isset($_SESSION['current_role']) || $_SESSION['current_role'] !== 'admin' || $_SESSION['current_role'] !== 'super user') {
        header("Location: /dashboard"); // Redirect unauthorized users to the dashboard
        exit();
    }
}

// Function to check if the user is Admin or Super User
function isAdminOrSuper()
{
    return isset($_SESSION['current_role']) && ($_SESSION['current_role'] === 'admin' || $_SESSION['current_role'] === 'super user');
}