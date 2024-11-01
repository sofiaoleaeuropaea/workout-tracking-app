<?php

require("models/users.php");
require("validators/validators.php");

$modelUsers = new Users();

if (isset($_POST["register"])) {

    foreach ($_POST as $key => $value) {
        $_POST[$key] = htmlspecialchars(strip_tags(trim($value)));
    }

    // $dateValidation = dateValidator($_POST["birthdate"]);
    // if ($dateValidation !== true) {
    //     $errors[] = $dateValidation;
    // }
    $errors = [];

    $allowedImageFormats = [
        ".jpg" => "image/jpeg",
        ".webp" => "image/webp",
        ".avif" => "image/avif",
        ".png" => "image/png"
    ];
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $fileInfo = new finfo(FILEINFO_MIME_TYPE);
        $mediaType = $fileInfo->file($_FILES['photo']['tmp_name']);
        $imageValidation = imageValidator($mediaType, $allowedImageFormats, $_FILES['photo']);

        if ($imageValidation === true) {
            $fileName = date("Y-m-H-i-s") . "_" . bin2hex(random_bytes(16));
            $fileExtension = array_search($mediaType, $allowedImageFormats);

            $fullPath = "images/userprofile/" . $fileName . $fileExtension;

            move_uploaded_file($_FILES['photo']['tmp_name'], $fullPath);
        } else {
            $errors[] = $imageValidation;
        }
    } else {
        $fullPath = NULL;
    }

    $ageValidation = ageLimitValidator($_POST["birthdate"]);

    if ($ageValidation !== true) {
        $errors[] = $ageValidation;
    }

    $registeredUsernames = $modelUsers->getByUsername($_POST["username"]);
    $registeredEmails = $modelUsers->getByEmail($_POST["email"]);

    if (
        !isset($_POST["agrees"]) ||
        empty($_POST["name"]) ||
        empty($_POST["username"]) ||
        empty($_POST["email"]) ||
        empty($_POST["password"]) ||
        empty($_POST["password_repeat"]) ||
        mb_strlen($_POST["name"]) < 3 ||
        mb_strlen($_POST["name"]) > 100 ||
        mb_strlen($_POST["username"]) < 3 ||
        mb_strlen($_POST["username"]) > 60 ||
        mb_strlen($_POST["password"]) < 8 ||
        mb_strlen($_POST["password"]) > 1000 ||
        !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) ||
        $_POST["password"] !== $_POST["password_repeat"] ||
        !empty($registeredUsernames) ||
        !empty($registeredEmails)
    ) {
        $errors[] = "Please, submit valid information.";
    }

    if (!empty($errors)) {
        $message = implode('; ', $errors);
    } else {
        $_POST['photo'] = $fullPath;
        $createUser = $modelUsers->createUser($_POST);
        header("Location: " . ROOT . "/gymtracker/login");
        exit();
    }
}

require("views/register.php");
