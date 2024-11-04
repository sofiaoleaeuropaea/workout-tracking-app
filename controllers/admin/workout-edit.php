<?php
$key = ENV["ENCRYPT_KEY"];
$encryptionUtility = new EncryptionUtility($key);

if (isset($_GET["exercise_id"])) {

    $encryptedExerciseId = $_GET["exercise_id"];
    $decryptedExerciseId = $encryptionUtility->decryptId($encryptedExerciseId);

    if ($decryptedExerciseId === false) {
        http_response_code(400);
        die("Invalid request ID.");
    }

    if (isset($_POST["edit_exercise"])) {
        foreach ($_POST as $key => $value) {
            $_POST[$key] = htmlspecialchars(strip_tags(trim($value)));
        }

        if (
            mb_strlen($_POST["name"]) >= 3 &&
            mb_strlen($_POST["name"]) <= 150 &&
            mb_strlen($_POST["muscle_group"]) >= 3 &&
            mb_strlen($_POST["muscle_group"]) <= 50
        ) {

            $exerciseUpdated = $modelExercises->updateExercise($_POST, $decryptedExerciseId);
            $message = "Exercise updated";

            if (!empty($exerciseUpdated)) {
                header("Location: " . ROOT . "/admin/workout-library/");
                exit();
            } else {
                http_response_code(400);
                $message = "Please enter valid information";
            }
        }
    }

    $exercise = $modelExercises->getExerciseById($decryptedExerciseId);

    require("views/admin/workout-edit.php");
} else {
    http_response_code(400);
    die("400: Bad Request");
}
