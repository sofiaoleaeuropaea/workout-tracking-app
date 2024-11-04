<?php
require("models/users.php");

$modelUsers = new Users();

header("Content-Type: application/json");

$messageError = '{"message": "400 Bad Request"}';
$messageSuccess = '{"message": "User was deleted"}';

if (isset($_SESSION["admin_id"])) {

    if ($_SERVER["REQUEST_METHOD"] === "DELETE") {

        $body = json_decode(file_get_contents("php://input"), true);

        if (isset($body['user_id']) && is_numeric($body['user_id'])) {

            $userDeleted = $modelUsers->deleteUser($body['user_id']);

            if (!empty($userDeleted)) {
                http_response_code(200);
                echo $messageSuccess;
                exit();
            }
        } else {
            http_response_code(400);
            echo $messageError;
        }
    }
} else {
    http_response_code(403);
    die("403: Access denied");
}
