<?php
// TODO: REFACTOR Validators
require("models/users.php");

function imageValidator($image)
{
    $allowed_image_formats = [
        "image/jpeg" => ".jpg",
        "image/webp" => ".webp",
        "image/avif" => ".avif",
        "image/png" => ".png"
    ];

    $max_image_size = 2 * 1024 * 1024;

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $media_type = $finfo->file($image['tmp_name']);

    if (!array_key_exists($media_type, $allowed_image_formats) || mb_strlen($image['size'])  > $max_image_size) {
        return false;
    }

    return true;
}

if (isset($_POST["register"])) {

    foreach ($_POST as $key => $value) {
        $_POST[$key] = htmlspecialchars(strip_tags(trim($value)));
    }

    if (!empty($_FILES['photo']['tmp_name'])) {

        if (imageValidator($_FILES['photo'])) {
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
                $message = "Image processing failed.";
                require("views/register.php");
                exit;
            }
        }
    } else {
        $full_path = null;
    }

    if (
        isset($_POST["agrees"]) &&
        !empty($_POST["name"]) &&
        !empty($_POST["username"]) &&
        !empty($_POST["email"]) &&
        !empty($_POST["password"]) &&
        !empty($_POST["password_repeat"]) &&
        !empty($_POST["birthdate"]) &&
        mb_strlen($_POST["name"]) >= 3 &&
        mb_strlen($_POST["name"]) <= 100 &&
        mb_strlen($_POST["username"]) >= 3 &&
        mb_strlen($_POST["username"]) <= 60 &&
        mb_strlen($_POST["password"]) >= 8 &&
        mb_strlen($_POST["password"]) <= 1000 &&
        filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) &&
        $_POST["password"] === $_POST["password_repeat"]

    ) {

        $modelUsers = new Users();
        $userByUsername = $modelUsers->getByUsername($_POST["username"]);
        $userByEmail = $modelUsers->getByEmail($_POST["email"]);


        if (empty($userByUsername) && empty($userByEmail)) {

            $_POST['photo'] = $full_path;
            $createUser = $modelUsers->createUser($_POST);
            $_SESSION["user_id"] = $user["user_id"];
            header("Location: " . ROOT . "/");
        } else {
            if (!empty($userByUsername)) {
                $message = "This username already exists.";
            }

            if (!empty($userByEmail)) {
                $message = "This email already exists.";
            }
        }
    } else {
        $message = "Please, submit valid information.";
    }
}

require("views/register.php");
