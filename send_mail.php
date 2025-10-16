<?php
// send_mail.php - PHPMailer SMTP via Gmail
// Place the PHPMailer files in a folder called 'phpmailer' (instructions in README).
// Edit the SMTP credentials below before using.

header('Content-Type: text/plain; charset=utf-8');

function clean($v){ return trim(strip_tags($v)); }

$name = isset($_POST['name']) ? clean($_POST['name']) : '';
$email = isset($_POST['email']) ? clean($_POST['email']) : '';
$subject = isset($_POST['subject']) && $_POST['subject'] !== '' ? clean($_POST['subject']) : 'Website Enquiry';
$message = isset($_POST['message']) ? clean($_POST['message']) : '';

if(!$name || !$email){
    http_response_code(400);
    echo 'Name and email are required.';
    exit;
}

if(!file_exists(__DIR__.'/phpmailer/PHPMailer.php')){
    http_response_code(500);
    echo 'PHPMailer library not found. Please download PHPMailer and place files in the phpmailer/ folder.';
    exit;
}

require __DIR__.'/phpmailer/PHPMailer.php';
require __DIR__.'/phpmailer/SMTP.php';
require __DIR__.'/phpmailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try{
    // SMTP config - update these with your Gmail account details
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'yourname@gmail.com'; // replace with your Gmail
    $mail->Password = 'your-app-password'; // replace with App Password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Sender & recipient
    $mail->setFrom('website@' . ($_SERVER['SERVER_NAME'] ?? 'example.com'), 'PrimeIT Website');
    $mail->addAddress('yourname@example.com', 'Website Recipient'); // replace recipient

    $mail->addReplyTo($email, $name);

    $mail->isHTML(true);
    $mail->Subject = '[PrimeIT] ' . $subject;
    $body = '<h3>New enquiry</h3>';
    $body .= '<p><strong>Name:</strong> ' . htmlspecialchars($name) . '</p>';
    $body .= '<p><strong>Email:</strong> ' . htmlspecialchars($email) . '</p>';
    $body .= '<p><strong>Message:</strong><br>' . nl2br(htmlspecialchars($message)) . '</p>';

    $mail->Body = $body;

    $mail->send();
    echo 'Message sent';
} catch (Exception $e){
    http_response_code(500);
    echo 'Mailer Error: ' . $mail->ErrorInfo;
}
?>