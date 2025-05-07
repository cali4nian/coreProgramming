<?php
namespace App\Controllers;

use App\Models\ContactModel;

class ContactController extends BaseController
{
    private ContactModel $contactModel;

    // Constructor to initialize the ContactModel
    public function __construct()
    {
        $this->contactModel = new ContactModel();
    }

    // Method to render the contact page
    public function index()
    {    
        // Redirect to dashboard if user is logged in
        $this->isLoggedIn();

        // Fetch settings using the BaseController method
        $settings = $this->fetchSettings();

        // Generate CSRF token for the form
        $csrf_token = $this->generateOrValidateCsrfToken();

        // Prepare data for the contact page
        $data = [
            'csrf_token' => $csrf_token,
            'page_css_url' => '/assets/css/contact.css',
            'page_js_url' => '/assets/js/contact/contact.js',
            'header_title' => 'Contact ' . $settings['site_name'],
            'settings' => $settings,
        ];

        // Render the template and pass data
        renderTemplate('contact.php', $data);
    }

    // Method to handle the contact form submission
    public function sendMessage()
    {
        // Redirect to dashboard if user is logged in
        $this->isLoggedIn();
        
        // Validate CSRF token
        $this->generateOrValidateCsrfToken($_POST['csrf_token'], 'contact?error=invalid_request', true);
        
        // Handle the contact form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $this->sanitizeString($_POST['name']) ?? '';
            $email = $this->sanitizeEmail($_POST['email']) ?? '';
            $message = $this->sanitizeString($_POST['message']) ?? '';

            // Validate input (basic validation)
            if (empty($name) || empty($email) || empty($message)) $this->redirect('/contact?error=empty_fields');

            // Save the message using the ContactModel
            $message = $this->contactModel->saveMessage($name, $email, $message);

            // Send email notification (optional)
            // $this->contactModel->sendEmailNotification($name, $email, $message);

            // Check if the message was saved successfully
            if (!$message) $this->redirect('/contact?error=message_failed');

            // Set success message and redirect back to contact page
            $this->redirect('/contact?success=message_sent');
        }
    }
}
