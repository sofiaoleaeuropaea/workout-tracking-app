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

            $image_validation = imageValidator($_FILES['photo']);

            if ($image_validation === true) {
                $allowed_image_formats = [
                    "image/jpeg" => ".jpg",
                    "image/webp" => ".webp",
                    "image/avif" => ".avif",
                    "image/png" => ".png"
                ];

                $finfo = new finfo(FILEINFO_MIME_TYPE);
                $media_type = $finfo->file($_FILES['photo']['tmp_name']);

                $file_name =  date("Y-m-H-i-s") . "_" . bin2hex(random_bytes(16));
                $file_extension = $allowed_image_formats[$media_type];
                $full_path = "images/" . $file_name . $file_extension;

                if (!move_uploaded_file($_FILES['photo']['tmp_name'], $full_path)) {
                    $errors[] = "Image processing failed.";
                }
            } else {
                $errors[] = $image_validation;
            }
        } else {
            $user = $modelUsers->getUserById($_SESSION["user_id"]);
            $full_path = $user["photo"];
        }

        if (!empty($errors)) {
            $message_Profile = implode(';', $errors);
        }

        if (
            !empty($_POST["name"]) &&
            !empty($_POST["username"]) &&
            !empty($_POST["email"]) &&
            !empty($_POST["birthdate"]) &&
            mb_strlen($_POST["name"]) >= 3 &&
            mb_strlen($_POST["name"]) <= 100 &&
            mb_strlen($_POST["username"]) >= 3 &&
            mb_strlen($_POST["username"]) <= 60 &&
            filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)
        ) {
            $_POST['photo'] = $full_path;

            $user_updated = $modelUsers->updateUser($_POST, $_SESSION["user_id"]);
            if ($user_updated) {
                $message_profile = "Profile updated successfully.";
            } else {
                http_response_code(400);
                $message_profile = "Failed to update profile.";
            }
        } else {
            $message_profile = "Please, submit valid information.";
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
