<?php
require("validators/validators.php");

$modelUsers = new Users();

$key = ENV["ENCRYPT_KEY"];
$encryptionUtility = new EncryptionUtility($key);

if (isset($_GET["user_id"])) {

    $encryptedUserId = $_GET["user_id"];
    $decryptedUserId = $encryptionUtility->decryptId($encryptedUserId);

    if ($decryptedUserId === false) {
        http_response_code(400);
        die("Invalid request ID.");
    }

    if (isset($_POST["edit_profile"])) {

        foreach ($_POST as $key => $value) {
            $_POST[$key] = htmlspecialchars(strip_tags(trim($value)));
        }
        $errors = [];

        $user = $modelUsers->getUserById($decryptedUserId);

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
                $user = $modelUsers->getUserById($decryptedUserId);
            }
        } else {
            $user = $modelUsers->getUserById($decryptedUserId);
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
            http_response_code(400);
            $message = implode('<br>', $errors);
        } else {
            $_POST['photo'] = $fullPath;
            $userUpdated = $modelUsers->updateUser($_POST, $decryptedUserId);
            $message = "User updated";
        }
    }

    $user = $modelUsers->getUserById($decryptedUserId);
    if ($user) {
        $defaultPhoto = '/images/userprofile/default-profile-icon.webp';
        $user['photo'] = !empty($user['photo']) ? '/' . ltrim($user['photo'], '/') : $defaultPhoto;
    }

    require("views/admin/users-edit.php");
} else {
    http_response_code(400);
    die("400: Bad Request");
}
