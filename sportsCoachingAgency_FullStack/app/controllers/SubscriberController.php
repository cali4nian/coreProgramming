<?php
namespace App\Controllers;

require_once __DIR__ . '/../functions/auth.php';
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../functions/email.php';

use App\Models\SubscriberModel;

class SubscriberController extends BaseController
{
    private SubscriberModel $subscriberModel;

    public function __construct()
    {
        $this->subscriberModel = new SubscriberModel();
    }

    public function index()
    {
        requireAdminOrSuper();

        $perPage = 10;
        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $perPage;

        // Fetch subscribers with pagination
        $subscribers = $this->subscriberModel->getAllSubscribersWithPagination($perPage, $offset);

        // Get total number of subscribers for pagination
        $totalSubscribers = $this->subscriberModel->getTotalSubscribers();
        $totalPages = ceil($totalSubscribers / $perPage);

        $data = [
            'subscribers' => $subscribers,
            'totalPages' => $totalPages,
            'currentPage' => $page,
            'header_title' => 'Subscribers List',
            'page_css_url' => '/assets/css/subscribers.css',
            'page_js_url' => '/assets/js/backend/subscribers/subscribers.js',
            'pageName' => 'Subscriber Management',
            'pageDescription' => 'View and manage all subscribers, including their subscription status and details.',
        ];

        renderTemplate('back_pages/admin/subscribers.php', $data);
    }

    public function subscribe()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
            $email = $this->sanitizeEmail($_POST['email']);
            $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

            if ($email) {
                $this->subscriberModel->addSubscriber($email);
                
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
                $this->subscriberModel->confirmSubscriber($email);
                // Check if the email exists in the database
                $subscriber = $this->subscriberModel->getSubscriberByEmail($email);

                // Redirect to home with a confirmation message
                if ($subscriber) $this->redirect('/?confirmed=true');
                else $this->showResendVerificationPage($email, 'not_found');

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
        if (!isset($_GET['email'])) $this->redirect('/?error=invalid_request');

        $email = $_GET['email'];

        $subscriber = $this->subscriberModel->getSubscriberByEmail($email);

        if (!$subscriber) $this->redirect('/?error=not_found');

        if ($subscriber['is_confirmed']) $this->redirect('/?error=subscription_already_verified');

        // Generate new confirmation token
        $newToken = bin2hex(random_bytes(32));

        // Store the new token in the database
        $this->subscriberModel->setNewToken($newToken, $subscriber['id']);

        // Send confirmation email
        $confirmationLink = "http://localhost:8000/confirm-subscription?email=" . urlencode($email);
        $subject = "Confirm Your Subscription (Resent)";

        if (!file_exists(__DIR__ . '/../../templates/email/confirm_email_template.html')) $this->redirect('forgot-password?error=system');

        $template = file_get_contents(__DIR__ . '/../../templates/email/confirm_email_template.html');

        // Replace placeholder with actual link
        $emailBody = str_replace("{{verification_link}}", $confirmationLink, $template);

        if (sendEmail($email, $subject, $emailBody)) $this->redirect('/?success=confirmation_email_sent');
        else $this->redirect('/?error=email_failed');

    }

    public function deleteSubscriber()
    {
        requireAdmin(); // Ensure only admins can delete subscribers

        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) $this->redirect('/admin/subscribers?error=invalid_request');

        $this->subscriberModel->deleteSubscriber($_GET['id']);

        // Redirect to the subscriber list with a success message
        $this->redirect('/admin/subscribers?success=subscriber_deleted');
    }

    // Download All Subscribers
    public function downloadAllSubscribers()
    {
        requireAdminOrSuper(); // Ensure only admins can download
        $subscribers = $this->subscriberModel->getAllSubscribers();
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
        requireAdminOrSuper(); // Ensure only admins can download
        $subscribers = $this->subscriberModel->getAllConfirmedSubscribers();
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
        requireAdminOrSuper(); // Ensure only admins can download
        $subscribers = $this->subscriberModel->getAllUnconfirmedSubscribers();

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
