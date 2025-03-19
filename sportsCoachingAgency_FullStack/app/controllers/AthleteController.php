<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Config\Database;

class AthleteController extends BaseController
{
    public function index()
    {
        // Connect to the database
        $db = Database::connect();

        // Fetch all athletes with their phone numbers
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
            WHERE roles.name = 'athlete'
        ");
        $athletes = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Group phone numbers by athlete
        $groupedAthletes = [];
        foreach ($athletes as $athlete) {
            $userId = $athlete['user_id'];
            if (!isset($groupedAthletes[$userId])) {
                $groupedAthletes[$userId] = [
                    'id' => $athlete['user_id'],
                    'name' => $athlete['name'],
                    'email' => $athlete['email'],
                    'role' => $athlete['role'],
                    'phone_numbers' => [],
                ];
            }
            if ($athlete['phone_number']) {
                $groupedAthletes[$userId]['phone_numbers'][] = [
                    'phone_number' => $athlete['phone_number'],
                    'type' => $athlete['phone_type'],
                ];
            }
        }

        // Pass data to the template
        $data = [
            'header_title' => 'Athletes',
            'page_css_url' => '/assets/css/athletes.css',
            'page_js_url' => '/assets/js/backend/athletes/athletes.js',
            'athletes' => array_values($groupedAthletes), // Pass grouped athletes data to the template
        ];

        renderTemplate('back_pages/athletes.php', $data);
    }
}