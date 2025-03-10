<?php
namespace App\Controllers;

require_once __DIR__ . '/../functions/auth.php';
require_once __DIR__ . '/../config/Database.php';

use App\Config\Database;
use PDO;

class SubscriberController
{
    public function listSubscribers()
    {
        requireAdmin(); // Ensure only admins can access

        $db = Database::connect();
        
        $perPage = 10; // Number of subscribers per page
        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $perPage;

        // Fetch subscribers with pagination
        $stmt = $db->prepare("SELECT id, email, is_confirmed, subscribed_at FROM subscribers LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $subscribers = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Get total number of subscribers for pagination
        $stmt = $db->query("SELECT COUNT(*) FROM subscribers");
        $totalSubscribers = $stmt->fetchColumn();
        $totalPages = ceil($totalSubscribers / $perPage);

        renderTemplate('back_pages/admin/subscribers.php', [
            'subscribers' => $subscribers,
            'totalPages' => $totalPages,
            'currentPage' => $page
        ]);
    }

    public function deleteSubscriber()
    {
        requireAdmin(); // Ensure only admins can delete subscribers

        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            die("❌ Invalid subscriber ID.");
        }

        $db = Database::connect();
        $stmt = $db->prepare("DELETE FROM subscribers WHERE id = :id");
        $stmt->execute(['id' => $_GET['id']]);

        // Redirect to the subscriber list with a success message
        header("Location: /admin/subscribers?deleted=true");
        exit();
    }

    // Download All Subscribers
    public function downloadAllSubscribers()
    {
        requireAdmin(); // Ensure only admins can download

        $db = Database::connect();
        $stmt = $db->query("SELECT id, email, is_confirmed, subscribed_at FROM subscribers");
        $subscribers = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Set headers for CSV download
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=all_subscribers.csv');

        // Open output stream
        $output = fopen('php://output', 'w');
        fputcsv($output, ['ID', 'Email', 'Confirmed', 'Subscribed At'], ',', '"', "\\"); // CSV headers

        foreach ($subscribers as $subscriber) {
            fputcsv($output, [
                $subscriber['id'],
                $subscriber['email'],
                $subscriber['is_confirmed'] ? 'Yes' : 'No',
                $subscriber['subscribed_at']
            ], ',', '"', "\\");
        }

        fclose($output);
        exit();
    }

    // Download Confirmed Subscribers
    public function downloadConfirmedSubscribers()
    {
        requireAdmin(); // Ensure only admins can download

        $db = Database::connect();
        $stmt = $db->prepare("SELECT id, email, is_confirmed, subscribed_at FROM subscribers WHERE is_confirmed = 1");
        $stmt->execute();
        $subscribers = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Set headers for CSV download
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=confirmed_subscribers.csv');

        // Open output stream
        $output = fopen('php://output', 'w');
        fputcsv($output, ['ID', 'Email', 'Confirmed', 'Subscribed At'], ',', '"', "\\");

        foreach ($subscribers as $subscriber) {
            fputcsv($output, [
                $subscriber['id'],
                $subscriber['email'],
                $subscriber['is_confirmed'] ? 'Yes' : 'No',
                $subscriber['subscribed_at']
            ], ',', '"', "\\");
        }

        fclose($output);
        exit();
    }

    // Download Unconfirmed Subscribers
    public function downloadUnconfirmedSubscribers()
    {
        requireAdmin(); // Ensure only admins can download

        $db = Database::connect();
        $stmt = $db->prepare("SELECT id, email, is_confirmed, subscribed_at FROM subscribers WHERE is_confirmed = 0");
        $stmt->execute();
        $subscribers = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Set headers for CSV download
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=unconfirmed_subscribers.csv');

        // Open output stream
        $output = fopen('php://output', 'w');
        fputcsv($output, ['ID', 'Email', 'Confirmed', 'Subscribed At'], ',', '"', "\\");

        foreach ($subscribers as $subscriber) {
            fputcsv($output, [
                $subscriber['id'],
                $subscriber['email'],
                $subscriber['is_confirmed'] ? 'Yes' : 'No',
                $subscriber['subscribed_at']
            ], ',', '"', "\\");
        }

        fclose($output);
        exit();
    }

}
