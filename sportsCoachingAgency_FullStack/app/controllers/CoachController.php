<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Config\Database;

class CoachController extends BaseController
{
    public function index()
    {
        // Connect to the database
        $db = Database::connect();

        // Fetch all coaches with their phone numbers
        $stmt = $db->query("
            SELECT 
                users.id AS user_id, 
                users.name, 
                users.email, 
                roles.name AS role, 
                phone_numbers.phone_number, 
                phone_numbers.type AS phone_type 
            FROM users
            LEFT JOIN user_roles ON users.id = user_roles.user_id
            LEFT JOIN roles ON user_roles.role_id = roles.id
            LEFT JOIN phone_numbers ON users.id = phone_numbers.user_id
            WHERE roles.name = 'coach'
        ");
        $coaches = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Group phone numbers by coach
        $groupedCoaches = [];
        foreach ($coaches as $coach) {
            $userId = $coach['user_id'];
            if (!isset($groupedCoaches[$userId])) {
                $groupedCoaches[$userId] = [
                    'id' => $coach['user_id'],
                    'name' => $coach['name'],
                    'email' => $coach['email'],
                    'role' => $coach['role'],
                    'phone_numbers' => [],
                ];
            }
            if ($coach['phone_number']) {
                $groupedCoaches[$userId]['phone_numbers'][] = [
                    'phone_number' => $coach['phone_number'],
                    'type' => $coach['phone_type'],
                ];
            }
        }

        // Pass data to the template
        $data = [
            'header_title' => 'Coaches',
            'page_css_url' => '/assets/css/coaches.css',
            'page_js_url' => '/assets/js/coaches.js',
            'coaches' => array_values($groupedCoaches), // Pass grouped coaches data to the template
        ];

        renderTemplate('back_pages/coaches.php', $data);
    }
}