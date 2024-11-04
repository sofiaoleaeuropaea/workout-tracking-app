<?php

$modelExercises = new Exercises();

if (isset($_POST["create_exercise"])) {

    foreach ($_POST as $key => $value) {
        $_POST[$key] = htmlspecialchars(strip_tags(trim($value)));
    }

    if (
        !empty($_POST["name"]) &&
        !empty($_POST["muscle_group"]) &&
        !empty($_POST["description"]) &&
        mb_strlen($_POST["name"]) >= 3 &&
        mb_strlen($_POST["name"]) <= 150 &&
        mb_strlen($_POST["muscle_group"]) >= 3 &&
        mb_strlen($_POST["muscle_group"]) <= 50
    ) {

        $exerciseCreated = $modelExercises->createExercise($_POST);
        $message = "Exercise updated";

        if (!empty($exerciseCreated)) {
            header("Location: " . ROOT . "/admin/workout-library/");
            exit();
        } else {
            http_response_code(400);
            $message = "Please enter valid information";
        }
    }
}
require("views/admin/workout-create.php");
