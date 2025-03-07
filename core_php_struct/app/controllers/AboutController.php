<?php
class AboutController
{
    public function index()
    {
        // Prepare data for the home page
        $data = [
            'title'   => 'About Page',
            'message' => 'Welcome to the about page!'
        ];

        // Render the template and pass data
        renderTemplate('about.php', $data);
    }
}
