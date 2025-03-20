<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Config\Database;
use PDO;

require_once __DIR__ . '/../functions/auth.php';

class SettingController extends BaseController
{
    public function index()
    {
        requireAdmin();

        $db = Database::connect();

        // Fetch all settings
        $stmt = $db->query("SELECT key_name, value FROM settings");
        $settings = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

        $data = [
            'header_title' => 'Settings',
            'page_css_url' => '/assets/css/settings.css',
            'page_js_url' => '/assets/js/backend/settings/settings.js',
            'settings' => $settings,
            'pageName' => 'Settings', // Added pageName
            'pageDescription' => 'Manage your application settings, including site details, social media links, and homepage configurations.', // Added pageDescription
        ];

        renderTemplate('back_pages/settings.php', $data);
    }

    public function updateSiteSettings()
    {
        requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $db = Database::connect();

            // Update Site Name and Customer Service Email
            $this->updateSetting($db, 'site_name', $_POST['site_name']);
            $this->updateSetting($db, 'customer_service_email', $_POST['customer_service_email']);

            $this->redirect('/admin/settings?success=site-updated');
        }
    }

    public function updateSocialMediaSettings()
    {
        requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $db = Database::connect();

            // Update Social Media URLs
            $this->updateSetting($db, 'facebook_url', $_POST['facebook_url']);
            $this->updateSetting($db, 'twitter_url', $_POST['twitter_url']);
            $this->updateSetting($db, 'instagram_url', $_POST['instagram_url']);
            $this->updateSetting($db, 'linkedin_url', $_POST['linkedin_url']);
            $this->updateSetting($db, 'tiktok_url', $_POST['tiktok_url']);
            $this->updateSetting($db, 'youtube_url', $_POST['youtube_url']);
            $this->updateSetting($db, 'snapchat_url', $_POST['snapchat_url']);

            $this->redirect('/admin/settings?success=social-media-updated');
        }
    }

    public function updateHomePageSettings()
    {
        requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $db = Database::connect();

            // Update Home Page Settings
            $this->updateSetting($db, 'call_now_phone', $_POST['call_now_phone']);
            $this->updateSetting($db, 'where_to_start_video', $_POST['where_to_start_video']);
            $this->updateSetting($db, 'main_youtube_video', $_POST['main_youtube_video']);

            // Handle file uploads for images
            $this->handleFileUpload($db, 'background_image', $_FILES['background_image']);
            $this->handleFileUpload($db, 'hero_image', $_FILES['hero_image']);
            $this->handleFileUpload($db, 'head_coach_image', $_FILES['head_coach_image']);
            $this->handleFileUpload($db, 'main_instagram_photo', $_FILES['main_instagram_photo']);
            $this->handleFileUpload($db, 'main_facebook_photo', $_FILES['main_facebook_photo']);

            $this->redirect('/admin/settings?success=home-page-updated');
        }
    }

    private function updateSetting(PDO $db, $key, $value)
    {
        $stmt = $db->prepare("INSERT INTO settings (key_name, value) VALUES (:key_name, :value)
                              ON DUPLICATE KEY UPDATE value = :value");
        $stmt->execute(['key_name' => $key, 'value' => $value]);
    }

    private function handleFileUpload(PDO $db, $key, $file)
    {
        if ($file['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../public_html/uploads/';
            $fileName = basename($file['name']);
            $filePath = $uploadDir . $fileName;

            if (move_uploaded_file($file['tmp_name'], $filePath)) {
                $this->updateSetting($db, $key, '/uploads/' . $fileName);
            }
        }
    }
}