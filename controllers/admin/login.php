<?php
require("models/admin.php");

$modelAdmin = new Admin();

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

        $admin = $modelAdmin->loginAdmin($_POST["email"]);

        if (!empty($admin) && password_verify($_POST["password"], $admin["password_hash"])) {
            $_SESSION["admin_id"] = $admin["admin_id"];
            header("Location: " . ROOT . "/admin/dashboard/");
            exit();
        } else {
            $message = "Please, enter a valid username and password.";
        }
    } else {
        $message = "Please, enter a valid username and password.";
    }
}

require("views/admin/login.php");
