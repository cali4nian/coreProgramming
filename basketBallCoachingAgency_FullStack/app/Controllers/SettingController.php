<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SettingModel;

require_once __DIR__ . '/../functions/auth.php';

class SettingController extends BaseController
{
    private SettingModel $settingsModel;

    // Constructor to initialize the settings model
    public function __construct()
    {
        // call settings model if needed
        $this->settingsModel = new SettingModel();
    }

    // Method to render the settings page
    public function index()
    {
        // Check if session is started, if not, start it
        $this->isSessionOrStart();
        // Check if user is logged in and has admin or super role
        $this->isNotLoggedIn();
        requireAdminOrSuper();

        // Generate CSRF token
        $csrfToken = $this->generateOrValidateCsrfToken();

        // Fetch all settings
        $settings = $this->settingsModel->getAllSettings();

        $data = [
            'csrf_token' => $csrfToken,
            'header_title' => 'Settings',
            'page_css_url' => '/assets/css/settings.css',
            'page_js_url' => '/assets/js/backend/settings/settings.js',
            'settings' => $settings,
            'pageName' => 'Settings',
            'pageDescription' => 'Manage your application settings, including site details, social media links, and homepage configurations.',
        ];

        renderTemplate('back_pages/settings.php', $data);
    }

    // Methods to handle form submissions for updating settings
    public function updateSiteSettings()
    {
        // Check if user is logged in and has admin or super role
        $this->isSessionOrStart();
        $this->isNotLoggedIn();
        requireAdminOrSuper();

        // Validate CSRF token
        $this->generateOrValidateCsrfToken($_POST['csrf_token'], '/admin/settings?error=invalid_request', true);


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Update Site Name and Customer Service Email
            $this->settingsModel->updateSetting('site_name', $_POST['site_name']);
            $this->settingsModel->updateSetting('customer_service_email', $_POST['customer_service_email']);

            $this->redirect('/admin/settings?success=site_updated');
        }
    }

    // Method to handle form submissions for updating social media settings
    public function updateSocialMediaSettings()
    {
        // Check if user is logged in and has admin or super role
        $this->isSessionOrStart();
        $this->isNotLoggedIn();
        requireAdminOrSuper();

        // Validate CSRF token
        $this->generateOrValidateCsrfToken($_POST['csrf_token'], '/admin/settings?error=invalid_request', true);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Update Social Media URLs
            $this->settingsModel->updateSetting('facebook_url', $_POST['facebook_url']);
            $this->settingsModel->updateSetting('twitter_url', $_POST['twitter_url']);
            $this->settingsModel->updateSetting('instagram_url', $_POST['instagram_url']);
            $this->settingsModel->updateSetting('linkedin_url', $_POST['linkedin_url']);
            $this->settingsModel->updateSetting('tiktok_url', $_POST['tiktok_url']);
            $this->settingsModel->updateSetting('youtube_url', $_POST['youtube_url']);
            $this->settingsModel->updateSetting('snapchat_url', $_POST['snapchat_url']);

            $this->redirect('/admin/settings?success=social_media_updated');
        }
    }

    // Method to handle form submissions for updating home page settings
    public function updateHomePageSettings()
    {
        // Check if user is logged in and has admin or super role
        $this->isSessionOrStart();
        $this->isNotLoggedIn();
        requireAdminOrSuper();

        // Validate CSRF token
        $this->generateOrValidateCsrfToken($_POST['csrf_token'], '/admin/settings?error=invalid_request', true);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Update Home Page Settings
            $this->settingsModel->updateSetting('call_now_phone', $_POST['call_now_phone']);
            $this->settingsModel->updateSetting('where_to_start_video', $_POST['where_to_start_video']);
            $this->settingsModel->updateSetting('main_youtube_video', $_POST['main_youtube_video']);

            // Handle file uploads for images
            $this->settingsModel->handleFileUpload('background_image', $_FILES['background_image']);
            $this->settingsModel->handleFileUpload('hero_image', $_FILES['hero_image']);
            $this->settingsModel->handleFileUpload('head_coach_image', $_FILES['head_coach_image']);
            $this->settingsModel->handleFileUpload('main_instagram_photo', $_FILES['main_instagram_photo']);
            $this->settingsModel->handleFileUpload('main_facebook_photo', $_FILES['main_facebook_photo']);

            $this->redirect('/admin/settings?success=home_page_updated');
        }
    }

    // Method to handle form submissions for updating About Page settings
    public function updateAboutPageSettings()
    {
        // Check if user is logged in and has admin or super role
        $this->isSessionOrStart();
        $this->isNotLoggedIn();
        requireAdminOrSuper();

        // Validate CSRF token
        $this->generateOrValidateCsrfToken($_POST['csrf_token'], '/admin/settings?error=invalid_request', true);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Update About Page Settings
            $this->settingsModel->updateSetting('about_page_text_one', $_POST['about_page_text_one']);
            $this->settingsModel->updateSetting('about_page_text_two', $_POST['about_page_text_two']);
            $this->settingsModel->updateSetting('about_page_text_three', $_POST['about_page_text_three']);

            // Handle file uploads for images
            $this->settingsModel->handleFileUpload('about_page_image', $_FILES['about_page_image']);

            $this->redirect('/admin/settings?success=about_page_updated');
        }
    }
    
}