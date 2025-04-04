<?php
namespace App\Controllers;

require_once __DIR__ . '/../functions/csrf.php';

use App\Models\ContactModel;

class ContactController extends BaseController
{
    private ContactModel $contactModel;

    public function __construct()
    {
        $this->contactModel = new ContactModel();
    }

    public function index()
    {    
        // Fetch settings using the BaseController method
        $settings = $this->fetchSettings();

        // Prepare data for the contact page
        $data = [
            'page_css_url' => '/assets/css/contact.css',
            'page_js_url' => '/assets/js/contact/contact.js',
            'header_title' => 'Contact ' . $settings['site_name'],
            'settings' => $settings,
        ];

        // Render the template and pass data
        renderTemplate('contact.php', $data);
    }

    public function sendMessage()
    {
        if (!isset($_POST['csrf_token']) || !validateCsrfToken($_POST['csrf_token'])) $this->redirect('contact?error=invalid_request');
        
        // Handle the contact form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $this->sanitizeString($_POST['name']) ?? '';
            $email = $this->sanitizeEmail($_POST['email']) ?? '';
            $message = $this->sanitizeString($_POST['message']) ?? '';

            // Validate input (basic validation)
            if (empty($name) || empty($email) || empty($message)) $this->redirect('/contact?error=empty_fields');

            // Here you would typically send the email or save the message to a database
            $message = $this->contactModel->saveMessage($name, $email, $message);

            // Check if the message was saved successfully
            if (!$message) $this->redirect('/contact?error=message_failed');

            // Set success message and redirect back to contact page
            $this->redirect('/contact?success=message_sent');
        }
    }
}
