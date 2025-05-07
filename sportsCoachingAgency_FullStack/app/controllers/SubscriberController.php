<?php
namespace App\Controllers;

require_once __DIR__ . '/../functions/auth.php';
require_once __DIR__ . '/../functions/email.php';

use App\Models\SubscriberModel;

class SubscriberController extends BaseController
{
    private SubscriberModel $subscriberModel;

    // Constructor to initialize the SubscriberModel
    public function __construct()
    {
        $this->subscriberModel = new SubscriberModel();
    }

    // Method to display the list of subscribers with pagination
    public function index()
    {
        // Check if the session is started
        $this->isSessionOrStart();

        // Check if the user is logged in
        $this->isLoggedIn();
        
        // Check if the user is logged in and has admin or super privileges
        requireAdminOrSuper();

        // Generate CSRF token
        $csrfToken = $this->generateOrValidateCsrfToken();

        $perPage = 10;
        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $perPage;

        // Fetch subscribers with pagination
        $subscribers = $this->subscriberModel->getAllSubscribersWithPagination($perPage, $offset);

        // Get total number of subscribers for pagination
        $totalSubscribers = $this->subscriberModel->getTotalSubscribers();
        $totalPages = ceil($totalSubscribers / $perPage);

        // Prepare data for rendering
        $data = [
            'csrf_token' => $csrfToken,
            'subscribers' => $subscribers,
            'totalPages' => $totalPages,
            'currentPage' => $page,
            'header_title' => 'Subscribers List',
            'page_css_url' => '/assets/css/subscribers.css',
            'page_js_url' => '/assets/js/backend/subscribers/subscribers.js',
            'pageName' => 'Subscriber Management',
            'pageDescription' => 'View and manage all subscribers, including their subscription status and details.',
        ];

        renderTemplate('back_pages/subscribers.php', $data);
    }

    // Method to handle subscription requests UPDATE TO ADD CSRF TOKEN
    public function subscribe()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
            $email = $this->sanitizeEmail($_POST['email']);
            $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

            // Check if the email is already in the database
            $subscriber = $this->subscriberModel->getSubscriberByEmail($email);

            // If the email is already in the database, check if it's confirmed
            if ($subscriber) {
                // If it's confirmed, redirect to home with an error message
                if ($subscriber['is_confirmed']) $this->redirect('/?error=subscriber_already_verified');
                // If it's not confirmed, redirect to home with a pending message
                else $this->sendConfirmationEmail($email); // Send confirmation email
            }
            
            // If the email is not in the database, add it and send a confirmation email
            if ($email && !$subscriber) {
                $this->subscriberModel->addSubscriber($email);
                $this->sendConfirmationEmail($email); // Send confirmation email
            
            } else $this->redirect('/?error=invalid_email'); // Redirect to home with an error message
        } else $this->redirect('/'); // Redirect to home if accessed directly
    }

    // Method to send a confirmation email to the subscriber
    public function sendConfirmationEmail($email)
    {
        // Send confirmation email
        $subject = "Confirm your subscription";

        // Load the template
        $template = file_get_contents(__DIR__ . '/../../templates/email/confirm_subscription_template.html');

        $confirmationLink = "http://localhost:8000/confirm-subscription?email=" . urlencode($email);
        $message = str_replace('{{confirmation_link}}', $confirmationLink, $template);
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        sendEmail($email, $subject, $message);
        $this->redirect('/?pending=true'); // Redirect to home with a pending message
    }

    // Method to handle the confirmation of a subscription
    public function confirm()
    {
        if (isset($_GET['email'])) {
            $emailClean = $this->sanitizeEmail($_GET['email']);
            $emailFiltered = filter_var($emailClean, FILTER_VALIDATE_EMAIL);

            if ($emailClean && $emailFiltered) {
                $this->subscriberModel->confirmSubscriber($emailFiltered);
                
                // Check if the email exists in the database
                $subscriber = $this->subscriberModel->getSubscriberByEmail($emailFiltered);

                // Redirect to home with a confirmation message
                if ($subscriber && $subscriber['is_confirmed']) $this->redirect('/?confirmed=true');
                else $this->showResendVerificationPage($emailFiltered, 'not_found');

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
    
    // Method to handle the resending of the confirmation email
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

    // Method to handle the deletion of a subscriber
    public function deleteSubscriber()
    {
        // Check if the user is logged in and has admin privileges
        $this->isSessionOrStart();
        $this->isLoggedIn();
        requireAdmin();

        // Validate the CSRF token
        $this->generateOrValidateCsrfToken($_POST['csrf_token'], '/subscribers?error=invalid_request', true);

        if (!isset($_POST['id']) || !is_numeric($_POST['id']) || !isset($_POST['csrf_token'])) $this->redirect('/subscribers?error=invalid_request');

        // Delete the subscriber from the database
        $this->subscriberModel->deleteSubscriber($_POST['id']);

        // Redirect to the subscriber list with a success message
        $this->redirect('/subscribers?success=subscriber_deleted');
    }

    // Download All Subscribers
    public function downloadAllSubscribers()
    {
        // Check if the user is logged in and has admin privileges
        $this->isSessionOrStart();
        $this->isLoggedIn();
        requireAdminOrSuper();

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
        // Check if the user is logged in and has admin privileges
        $this->isSessionOrStart();
        $this->isLoggedIn();
        requireAdminOrSuper();

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
        // Check if the user is logged in and has admin privileges
        $this->isSessionOrStart();
        $this->isLoggedIn();
        requireAdminOrSuper();
        
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
