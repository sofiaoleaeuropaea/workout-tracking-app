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
            $message = "Current password is required.";
        } elseif (empty($_POST["new_password"]) || mb_strlen($_POST["new_password"]) < 8) {
            $message = "New password must be at least 8 characters long.";
        } elseif (mb_strlen($_POST["new_password"]) > 1000) {
            $message = "New password must be less than 1000 characters.";
        } elseif ($_POST["new_password"] === $_POST["current_password"]) {
            $message = "New password must be different from the current password.";
        } elseif ($_POST["new_password"] !== $_POST["password_repeat"]) {
            $message = "New password and confirmation password do not match.";
        } elseif (!password_verify($_POST["current_password"], $user["password_hash"])) {
            $message = "Current password is incorrect.";
        } else {

            $passwordUpdated = $modelUsers->updatePassword($_POST["new_password"], $_SESSION["user_id"]);

            if ($passwordUpdated) {
                $message = "Password updated successfully.";
            } else {
                http_response_code(400);
                $message = "Failed to update password.";
            }
        }
    }

    $user = $modelUsers->getUserById($_SESSION["user_id"]);
    if (!$user) {
        http_response_code(404);
        die("404: User not found.");
    }

    require("views/gymtracker/userprofile.php");
} else {
    http_response_code(400);
    die("400: Bad Request");
}
