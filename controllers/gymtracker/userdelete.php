<?php
require("models/users.php");

$modelUsers = new Users();

header("Content-Type: application/json");

$messagePasswordRequired = 'Please, enter your password.';
$messagePasswordIncorrect = 'Password incorrect.';
$messageUserDeleted = 'Your information has been deleted. We will miss you!';
$messageError = 'Failed to delete your account. Please, try again.';

if (isset($_SESSION["user_id"])) {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $user = $modelUsers->getUserById($_SESSION["user_id"]);

        $confirmPassword = $_POST["confirm_password"];

        if (empty($confirmPassword)) {
            echo json_encode(['success' => false, 'message' => $messagePasswordRequired]);
            http_response_code(400);
            exit();
        } elseif (!password_verify($confirmPassword, $user["password_hash"])) {
            echo json_encode(['success' => false, 'message' => $messagePasswordIncorrect]);
            http_response_code(400);
            exit();
        } else {
            $userDelete = $modelUsers->deleteUser($_SESSION["user_id"]);

            if ($userDelete) {
                session_destroy();
                echo json_encode(['success' => true]);
                http_response_code(200);
                exit();
            } else {
                echo json_encode(['success' => false, 'message' => $messageError]);
                http_response_code(400);
                exit();
            }
        }
    }
} else {
    http_response_code(403);
    die("403: Access denied");
}
