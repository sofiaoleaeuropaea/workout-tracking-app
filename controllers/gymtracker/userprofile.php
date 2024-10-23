<?php
require("models/users.php");
require("validators/validators.php");

$modelUsers = new Users();

if (isset($_SESSION["user_id"])) {

    if (isset($_POST["edit_profile"])) {

        foreach ($_POST as $key => $value) {
            $_POST[$key] = htmlspecialchars(strip_tags(trim($value)));
        }

        $errors = [];

        if (!empty($_FILES['photo']['tmp_name'])) {

            $imageValidation = imageValidator($_FILES['photo']);

            if ($imageValidation === true) {
                $allowedImageFormats = [
                    "image/jpeg" => ".jpg",
                    "image/webp" => ".webp",
                    "image/avif" => ".avif",
                    "image/png" => ".png"
                ];

                $fileInfo = new finfo(FILEINFO_MIME_TYPE);
                $mediaType = $fileInfo->file($_FILES['photo']['tmp_name']);

                $fileName =  date("Y-m-H-i-s") . "_" . bin2hex(random_bytes(16));
                $fileExtension = $allowedImageFormats[$mediaType];
                $fullPath = "images/" . $fileName . $fileExtension;

                if (!move_uploaded_file($_FILES['photo']['tmp_name'], $fullPath)) {
                    $errors[] = "Image processing failed.";
                }
            } else {
                $errors[] = $image_validation;
            }
        } else {
            $user = $modelUsers->getUserById($_SESSION["user_id"]);
            $fullPath = $user["photo"];
        }

        if (!empty($_POST["birthdate"])) {
            $birthdateValidation = dateValidator($_POST["birthdate"]);
        } else {
            $errors[] = $birthdateValidation;
        }

        if (!empty($errors)) {
            $messageProfile = implode(';', $errors);
        }

        if (
            mb_strlen($_POST["name"]) >= 3 &&
            mb_strlen($_POST["name"]) <= 100 &&
            mb_strlen($_POST["username"]) >= 3 &&
            mb_strlen($_POST["username"]) <= 60 &&
            filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)
        ) {
            $_POST['photo'] = $fullPath;

            $userUpdated = $modelUsers->updateUser($_POST, $_SESSION["user_id"]);
            if ($userUpdated) {
                $messageProfile = "Profile updated successfully.";
            } else {
                http_response_code(400);
                $messageProfile = "Failed to update profile.";
            }
        } else {
            $messageProfile = "Please, submit valid information.";
        }
    }

    $user = $modelUsers->getUserById($_SESSION["user_id"]);
    if ($user) {
        $defaultPhoto = '/public/images/default-profile-icon.webp';
        $user['photo'] = !empty($user['photo']) ? $user['photo'] : $defaultPhoto;
    } else {

        http_response_code(404);
        die("404: User not found");
    }

    require("views/gymtracker/userprofile.php");
} else {
    http_response_code(403);
    die("403: Access denied");
}
