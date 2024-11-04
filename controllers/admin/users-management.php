<?php
require("models/users.php");
require("utility/encryption-utility.php");

$modelUsers = new Users();

$key = ENV["ENCRYPT_KEY"];
$encryptionUtility = new EncryptionUtility($key);

if (isset($_SESSION["admin_id"])) {
    if (!empty($url_parts[3])) {

        require("controllers/admin/users-edit.php");
    } else {
        $users = $modelUsers->getAllUsers();

        require("views/admin/users-management.php");
    }
} else {
    http_response_code(403);
    die("403: Access denied");
}
