<?php
namespace App\Controllers;

use App\Config\Database;
use PDO;

class BaseController
{
    // Method to redirect to a different URL
    protected function redirect($url)
    {
        header('Location: ' . $url);
        exit();
    }

    // Method to check if session is started, if not, start it
    protected function isSessionOrStart() {
        if (session_status() === PHP_SESSION_NONE) session_start();
    }

    // Check if user is logged in
    protected function isLoggedIn() 
    {
        if (isset($_SESSION['user_id'])) $this->redirect('/dashboard');
    }

    // Fetch all settings from database
    protected function fetchSettings(): array
    {
        // connect to the database
        $db = Database::connect();
        // Fetch all settings
        $stmt = $db->query("SELECT key_name, value FROM settings");
        return $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    }

    // Sanitize email
    protected function sanitizeEmail($email) {
        $email = trim(strtolower($email));
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        return filter_var($email, FILTER_VALIDATE_EMAIL) ? $email : false;
    }

    // Sanitize string
    protected function sanitizeString($input) {
        $input = trim(strip_tags($input));
        $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
        return $input;
    }

    // Sanitize Integer
    protected function sanitizeInteger($input) {
        $input = trim(strip_tags($input));
        $input = filter_var($input, FILTER_SANITIZE_NUMBER_INT);
        return filter_var($input, FILTER_VALIDATE_INT) ? (int)$input : false;
    }

    // Sanitize float
    protected function sanitizeFloat($input) {
        $input = trim(strip_tags($input));
        $input = filter_var($input, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        return filter_var($input, FILTER_VALIDATE_FLOAT) ? (float)$input : false;
    }

    // Sanitize phone number
    protected function sanitizePhoneNumber($phone) {
        $phone = trim(strip_tags($phone));
        $phone = preg_replace('/[^\d\+\-]/', '', $phone); // Allow only digits, +, and -
        return $phone;
    }
       
}