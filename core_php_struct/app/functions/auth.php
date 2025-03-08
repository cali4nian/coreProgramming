<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start(); // Start session only if not already started
}
// Protect pages by ensuring the user is logged in
function requireLogin()
{
    if (!isset($_SESSION['user_id'])) {
        header("Location: /login");
        exit();
    }
}

// Protect admin-only pages
function requireAdmin()
{
    requireLogin();
    if ($_SESSION['user_role'] !== 'admin') {
        die("Access denied. Admins only.");
    }
}
