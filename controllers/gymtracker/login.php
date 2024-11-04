<?php
require("models/users.php");

$modelUsers = new Users();

if (isset($_POST["submit"])) {

    foreach ($_POST as $key => $value) {
        $_POST[$key] = htmlspecialchars(strip_tags(trim($value)));
    }

    if (
        !empty($_POST["email"]) &&
        !empty($_POST["password"]) &&
        mb_strlen($_POST["password"]) >= 8 &&
        mb_strlen($_POST["password"]) <= 1000 &&
        filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)
    ) {

        $user = $modelUsers->loginUser($_POST["email"]);

        if (!empty($user) && password_verify($_POST["password"], $user["password_hash"])) {

            $_SESSION["user_id"] = $user["user_id"];
            header("Location: " . ROOT . "/gymtracker/dashboard/");
            exit();
        } else {
            $message = "Please, enter a valid username and password.";
        }
    } else {
        $message = "Please, enter a valid username and password.";
    }
}

require("views/gymtracker/login.php");
