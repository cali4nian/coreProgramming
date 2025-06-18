<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require_once __DIR__ . '/../../vendor/autoload.php';

// Load .env variables
require_once __DIR__ . '/../../app/functions/loadEnv.php'; // ✅ Ensure this is loaded before calling loadEnv()
loadEnv(__DIR__ . '/../../.env'); // ✅ Now, load the .env variables


function sendEmail($to, $subject, $body)
{
    $mail = new PHPMailer(true);
    
    try {
        $mail->isSMTP();
        $mail->Host       = getenv('MAIL_HOST'); 
        $mail->SMTPAuth   = true;
        $mail->Username   = getenv('MAIL_USERNAME');
        $mail->Password   = getenv('MAIL_PASSWORD');
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = getenv('MAIL_PORT');

        $mail->setFrom(getenv('MAIL_FROM_ADDRESS'), getenv('MAIL_FROM_NAME'));
        $mail->addAddress($to);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
