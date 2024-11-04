<?php
require("models/contact_requests.php");
require("models/contact-replies.php");
require("utility/encryption-utility.php");

$modelContactRequests = new ContactRequests();
$modelContactReplies = new ContactReplies();

$key = ENV["ENCRYPT_KEY"];
$encryptionUtility = new EncryptionUtility($key);

if (isset($_SESSION["admin_id"])) {
    if (!empty($url_parts[3])) {

        require("controllers/admin/support-reply.php");
    } else {
        $contactRequests = $modelContactRequests->getAllContactRequests();
        $contactReplies = $modelContactReplies->getAllContactReplies();

        require("views/admin/support.php");
    }
} else {
    http_response_code(403);
    die("403: Access denied");
}
