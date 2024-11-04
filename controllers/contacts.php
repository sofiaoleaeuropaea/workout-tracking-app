<?php
require("models/contact_requests.php");

$modelContactRequests = new ContactRequests();

if (isset($_POST["submit"])) {

    foreach ($_POST as $key => $value) {
        $_POST[$key] = htmlspecialchars(strip_tags(trim($value)));
    }

    if (
        !empty($_POST["name"]) &&
        !empty($_POST["email"]) &&
        !empty($_POST["form_message"]) &&
        mb_strlen($_POST["name"]) >= 3 &&
        mb_strlen($_POST["name"]) <= 100 &&
        filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)
    ) {
        $contactRequest = $modelContactRequests->createContactRequest($_POST);

        header("Location: " . ROOT . "/");
        exit();
    } else {
        $message = "Please, submit valid information.";
    }
}

require("views/contacts.php");
