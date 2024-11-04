<?php
require("models/users.php");

$modelUsers = new Users();

if (isset($_SESSION["user_id"])) {

    if (isset($_POST["edit_password"])) {

        foreach ($_POST as $key => $value) {
            $_POST[$key] = htmlspecialchars(strip_tags(trim($value)));
        }

        $user = $modelUsers->getUserById($_SESSION["user_id"]);

        if (empty($_POST["current_password"])) {
            $messageUpdatePassword = "Current password is required.";
        } elseif (empty($_POST["new_password"]) && mb_strlen($_POST["new_password"]) < 8 && mb_strlen($_POST["new_password"]) > 1000) {
            $messageUpdatePassword = "New password must be valid.";
        } elseif ($_POST["new_password"] !== $_POST["password_repeat"]) {
            $messageUpdatePassword = "New password and confirmation password do not match.";
        } elseif (!password_verify($_POST["current_password"], $user["password_hash"])) {
            $messageUpdatePassword = "New password must be valid.";
        } else {
            $passwordUpdated = $modelUsers->updatePassword($_POST["new_password"], $_SESSION["user_id"]);
            if ($passwordUpdated) {
                header("Location: "  . ROOT . "/gymtracker/user-profile/?success_password=true");
                exit();
            } else {
                http_response_code(400);
                $messageUpdatePassword = "Failed to update password.";
            }
        }
    }

    require("views/gymtracker/user-profile.php");
} else {
    http_response_code(403);
    die("403: Access denied");
}
