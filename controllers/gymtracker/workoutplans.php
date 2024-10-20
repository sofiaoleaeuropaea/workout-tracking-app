<?php
require("models/exercises.php");
require("models/workoutplans.php");

$modelExercises = new Exercises();
$modelWorkoutPlans = new WorkoutPlans();

if (isset($_SESSION["user_id"])) {

    if (isset($_POST["save"])) {
        foreach ($_POST as $key => $value) {
            $_POST[$key] = htmlspecialchars(strip_tags(trim($value)));
        }

        if (
            !empty($_POST["plan_name"]) &&
            !empty($_POST["exercise_name"]) &&
            mb_strlen($_POST["plan_name"]) >= 3 &&
            mb_strlen($_POST["plan_name"]) <= 100
        ) {

            $workout_plan = $modelWorkoutPlans->createWorkoutPlan($_SESSION["user_id"], $_POST);

            if ($workout_plan) {
                echo json_encode([
                    "success" => true,
                    "message" => "Workout plan created successfully! Start moving now!"
                ]);
            } else {
                echo json_encode([
                    "success" => false,
                    "message" => "Error creating workout plan. Please, try again."
                ]);
            }
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Please provide a valid workout plan name and at least one exercise."
            ]);
        }
        exit();
    }

    $exercises = $modelExercises->getAllExercises();

    require("views/gymtracker/workoutplans.php");
} else {
    http_response_code(403);
    die("403: Access denied");
}
