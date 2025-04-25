<?php
namespace App\Controllers;

require_once __DIR__ . '/../functions/csrf.php';

use App\Models\MessageModel;

class MessageController extends BaseController
{
    private MessageModel $messageModel;

    public function __construct()
    {
        $this->messageModel = new MessageModel();
    }

    public function index()
    {    
        // Fetch settings using the BaseController method
        $settings = $this->fetchSettings();
        $messages = $this->messageModel->getAllMessages();

        // Paginate messages
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 10; // Number of messages per page
        $offset = ($page - 1) * $limit;
        $totalMessages = count($messages);
        $totalPages = ceil($totalMessages / $limit);
        $messages = array_slice($messages, $offset, $limit);

        // Prepare data for the contact page
        $data = [
          'messages' => $messages,
          'currentPage' => $page,
          'totalPages' => $totalPages,
          'pageName' => 'Messages',
          'pageDescription' => 'Manage messages from users sent through the contact form.',
          'page_css_url' => '/assets/css/messages.css',
          'page_js_url' => '/assets/js/contact/messages.js',
          'header_title' => 'Contact ' . $settings['site_name'],
          'settings' => $settings,
        ];

        // Render the template and pass data
        renderTemplate('back_pages/messages.php', $data);
    }

    // Function to read a single message
    public function read()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            // Handle case where ID is not provided
            $this->redirect('/messages.php?error=invalid_id');
        }
        // Fetch settings using the BaseController method
        $settings = $this->fetchSettings();
        $message = $this->messageModel->getMessageById($id);

        if (!$message) {
            // Handle case where message is not found
            header('Location: /messages.php?error=message_not_found');
            exit;
        }

        // Prepare data for the read message page
        $data = [
          'message' => $message,
          'pageName' => 'Read Message',
          'pageDescription' => 'View the details of a specific message.',
          'page_css_url' => '/assets/css/read-message.css',
          'page_js_url' => '/assets/js/contact/read-message.js',
          'header_title' => 'Read Message - ' . $settings['site_name'],
          'settings' => $settings,
        ];

        // Render the template and pass data
        renderTemplate('back_pages/read_message.php', $data);
    }

    // Function to delete a message
    public function delete()
    {
        $id = $_POST['id'] ?? null;
        if (!$id) {
            // Handle case where ID is not provided
            $this->redirect('/admin/messages?error=invalid_id');
        }

        // Delete the message
        $this->messageModel->deleteMessageById($id);

        // Redirect back to messages page with success message
        $this->redirect('/admin/messages?success=message_deleted');
    }
    
}
