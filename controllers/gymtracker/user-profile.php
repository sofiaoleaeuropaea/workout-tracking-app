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
        $user = $modelUsers->getUserById($_SESSION["user_id"]);

        $previousPhotoPath = $user['photo'] ?? null;

        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $allowedImageFormats = [
                ".jpg" => "image/jpeg",
                ".webp" => "image/webp",
                ".avif" => "image/avif",
                ".png" => "image/png"
            ];

            $fileInfo = new finfo(FILEINFO_MIME_TYPE);
            $mediaType = $fileInfo->file($_FILES['photo']['tmp_name']);
            $imageValidation = imageValidator($mediaType, $allowedImageFormats, $_FILES['photo']);

            if ($imageValidation === true) {
                $fileName = date("Y-m-H-i-s") . "_" . bin2hex(random_bytes(16));
                $fileExtension = array_search($mediaType, $allowedImageFormats);

                $fullPath = "images/userprofile/" . $fileName . $fileExtension;

                if ($previousPhotoPath && file_exists($previousPhotoPath)) {
                    unlink($previousPhotoPath);
                }

                move_uploaded_file($_FILES['photo']['tmp_name'], $fullPath);
            } else {
                $errors[] = $imageValidation;
                $user = $modelUsers->getUserById($_SESSION["user_id"]);
            }
        } else {
            $user = $modelUsers->getUserById($_SESSION["user_id"]);
            $fullPath = $previousPhotoPath;
        }

        $ageValidation = ageLimitValidator($_POST["birthdate"]);

        if ($ageValidation !== true) {
            $errors[] = $ageValidation;
        }

        if (
            mb_strlen($_POST["name"]) < 3 || mb_strlen($_POST["name"]) > 100 ||
            mb_strlen($_POST["username"]) < 3 || mb_strlen($_POST["username"]) > 60 ||
            !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)
        ) {
            $errors[] = "Please, submit valid information.";
        }

        if (!empty($errors)) {
            $messageProfile = implode('<br>', $errors);
            require("views/gymtracker/user-profile.php");
        } else {
            $_POST['photo'] = $fullPath;
            $userUpdated = $modelUsers->updateUser($_POST, $_SESSION["user_id"]);
            header("Location: "  . ROOT . "/gymtracker/user-profile/?success_profile=true");
            exit();
        }
    }

    $user = $modelUsers->getUserById($_SESSION["user_id"]);
    if ($user) {
        $defaultPhoto = '/images/userprofile/default-profile-icon.webp';
        $user['photo'] = !empty($user['photo']) ? '/' . ltrim($user['photo'], '/') : $defaultPhoto;
    }

    require("views/gymtracker/user-profile.php");
} else {
    http_response_code(403);
    die("403: Access denied");
}
