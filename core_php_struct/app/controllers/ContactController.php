<?php
class ContactController
{
    public function index()
    {
        // Prepare data for the home page
        $data = [
            'title'   => 'Contact Page',
            'message' => 'Welcome to the contact page!'
        ];

        // Render the template and pass data
        renderTemplate('contact.php', $data);
    }
}
