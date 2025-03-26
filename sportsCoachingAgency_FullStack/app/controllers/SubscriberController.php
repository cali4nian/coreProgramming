<?php
namespace App\Controllers;

require_once __DIR__ . '/../functions/auth.php';
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../functions/email.php';

use App\Config\Database;
use PDO;

class SubscriberController extends BaseController
{
    public function index()
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

        $data = [
            'subscribers' => $subscribers,
            'totalPages' => $totalPages,
            'currentPage' => $page,
            'header_title' => 'Subscribers List',
            'page_css_url' => '/assets/css/subscribers.css',
            'page_js_url' => '/assets/js/backend/subscribers/subscribers.js',
            'pageName' => 'Subscriber Management', // Added pageName
            'pageDescription' => 'View and manage all subscribers, including their subscription status and details.', // Added pageDescription
        ];

        renderTemplate('back_pages/admin/subscribers.php', $data);
    }
    public function subscribe()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
            $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

            if ($email) {
                $db = Database::connect();
                $stmt = $db->prepare("INSERT INTO subscribers (email, is_confirmed, subscribed_at) VALUES (:email, 0, NOW())");
                $stmt->execute(['email' => $email]);
                // Send confirmation email
                $subject = "Confirm your subscription";
                $message = "
                    <html>
                    <head>
                        <title>Confirm your subscription</title>
                    </head>
                    <body>
                        <p>Please click the link below to confirm your subscription:</p>
                        <p><a href='http://localhost:8000/confirm-subscription?email=" . urlencode($email) . "'>Confirm Subscription</a></p>
                    </body>
                    </html>
                ";
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                sendEmail($email, $subject, $message);
                $this->redirect('/?pending=true'); // Redirect to home with a pending message
            
            } else {
                $this->redirect('/?error=invalid_email'); // Redirect to home with an error message
            }
        } else {
            $this->redirect('/'); // Redirect to home if accessed directly
        }
    }

    public function confirm()
    {
        if (isset($_GET['email'])) {
            $email = filter_var($_GET['email'], FILTER_VALIDATE_EMAIL);

            if ($email) {
                $db = Database::connect();
                $stmt = $db->prepare("UPDATE subscribers SET is_confirmed = 1 WHERE email = :email");
                $stmt->execute(['email' => $email]);

                if ($stmt->rowCount() > 0) {
                    // Redirect to home with a confirmation message
                    $this->redirect('/?confirmed=true');
                } else {
                    // Email not found, show a resend verification button
                    $this->showResendVerificationPage($email, 'not_found');
                }
            } else {
                // Invalid email, show a resend verification button
                $this->showResendVerificationPage(null, 'invalid_email');
            }
        } else {
            // Redirect to home if accessed directly
            $this->redirect('/');
        }
    }

    /**
     * Show a page with a resend verification button.
     *
     * @param string|null $email
     * @param string $errorType
     */
    private function showResendVerificationPage(?string $email, string $errorType)
    {
        $errorMessage = '';
        $resendLink = '';

        if ($errorType === 'not_found') {
            $errorMessage = "❌ We couldn't find a subscription with this email.";
            if ($email) {
                // Updated URL for resending subscription verification
                $resendLink = "/resend-subscription-verification?email=" . urlencode($email);
            }
        } elseif ($errorType === 'invalid_email') {
            $errorMessage = "❌ The email address provided is invalid.";
        }

        // Render a simple page with the error message and resend button
        echo "<html>
            <head>
                <title>Subscription Confirmation</title>
            </head>
            <body>
                <h1>Subscription Confirmation</h1>
                <p style='color: red;'>$errorMessage</p>";

        if ($resendLink) {
            echo "<p>If you believe this is a mistake, you can resend the verification email:</p>
                  <a href='$resendLink' style='display: inline-block; padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px;'>Resend Verification Email</a>";
        }

        echo "<p><a href='/'>Return to Home</a></p>
            </body>
        </html>";
        exit();
    }

    public function resendToSubscriber()
    {
        if (!isset($_GET['email'])) {
            die("❌ Invalid request.");
        }

        $email = $_GET['email'];

        $db = Database::connect();
        $stmt = $db->prepare("SELECT id, confirmation_token, is_confirmed FROM subscribers WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $subscriber = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$subscriber) {
            die("❌ No subscriber found with this email.");
        }

        if ($subscriber['is_confirmed']) {
            die("✅ Your email is already confirmed. You can <a href='/'>return to the homepage</a>.");
        }

        // Generate new confirmation token
        $newToken = bin2hex(random_bytes(32));

        // Store the new token in the database
        $stmt = $db->prepare("UPDATE subscribers SET confirmation_token = :token WHERE id = :id");
        $stmt->execute([
            'token' => $newToken,
            'id' => $subscriber['id']
        ]);

        // Send confirmation email
        $confirmationLink = "http://localhost:8000/confirm-subscription?email=" . urlencode($email);
        $subject = "Confirm Your Subscription (Resent)";
        $body = "
            <html>
            <head>
                <title>Confirm Your Subscription</title>
            </head>
            <body>
                <p>Click the link below to confirm your subscription:</p>
                <p><a href='$confirmationLink'>Confirm Subscription</a></p>
            </body>
            </html>
        ";

        if (sendEmail($email, $subject, $body)) {
            echo "✅ Confirmation email resent! Please check your inbox.";
        } else {
            echo "❌ Error sending email.";
        }
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
