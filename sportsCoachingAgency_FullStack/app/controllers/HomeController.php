<?php
namespace App\Controllers;

use App\Models\TopPlayerModel;

class HomeController extends BaseController
{
    private TopPlayerModel $topPlayerModel;

    public function __construct()
    {
        $this->topPlayerModel = new TopPlayerModel();
    }

    public function index()
    {   
        // Fetch settings using the BaseController method
        $settings = $this->fetchSettings();

        // Prepare data for the home page
        $data = [
            'players' => $this->topPlayerModel->getAllTopPlayers() ?? [],
            'page_css_url' => '/assets/css/index.css',
            'page_js_url' => '/assets/js/index/index.js',
            'header_title' => 'Welcome to ' . $settings['site_name'],
            'settings' => $settings,
        ];

        // Render the template and pass data
        renderTemplate('home.php', $data);
    }
}
