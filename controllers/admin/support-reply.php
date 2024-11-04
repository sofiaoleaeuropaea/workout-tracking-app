<?php

use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'vendor/autoload.php';

$modelContactRequests = new ContactRequests();
$modelContactReplies = new ContactReplies();

$key = ENV["ENCRYPT_KEY"];
$encryptionUtility = new EncryptionUtility($key);

if (isset($_GET["request_id"])) {

    $encryptedRequestId = $_GET["request_id"];
    $decryptedRequestId = $encryptionUtility->decryptId($encryptedRequestId);

    if ($decryptedRequestId === false) {
        http_response_code(400);
        die("Invalid request ID.");
    }

    if (isset($_POST["reply"])) {
        foreach ($_POST as $key => $value) {
            $_POST[$key] = htmlspecialchars(strip_tags(trim($value)));
        }

        if (
            !empty($_POST["reply_message"])
        ) {

            $createReply = $modelContactReplies->createContactReplies($_POST, $decryptedRequestId);
            $replyDetails = $modelContactReplies->getAllContactRepliesById($createReply["reply_id"]);

            if (!empty($createReply)) {
                $mail = new PHPMailer(true);

                try {
                    $mail->isSMTP();
                    $mail->Host = ENV["SMTP_HOST"];
                    $mail->Username = ENV["SMTP_USER"];
                    $mail->Password = ENV["SMTP_PASSWORD"];
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = ENV["SMTP_PORT"];
                    $mail->SMTPAuth = true;
                    $mail->setFrom('ironclad.096@gmail.com', 'Ironclad Support');
                    $mail->addAddress($replyDetails['email']);

                    $mail->isHTML(true);
                    $mail->Subject = 'Ironclad Support | Reply to your contact message';
                    $mail->Body .= '<p>Dear Ironclader ' . nl2br($replyDetails['name']) . ',</p>
                    
                    <p>' . nl2br($replyDetails['reply_message']) . '</p>
                    
                    <p>Stay strong,<br>Ironclad Support Team</p>';

                    $mail->send();

                    $message = "Message sent to the user.";
                    header("Location: " . ROOT . "/admin/support/");
                    exit();
                } catch (Exception $e) {
                    $message = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            } else {
                http_response_code(400);
                $message = "Please enter valid information.";
            }
        }
    }

    $request = $modelContactRequests->getRequestById($decryptedRequestId);

    require("views/admin/support-reply.php");
} else {
    http_response_code(400);
    die("400: Bad Request");
}
