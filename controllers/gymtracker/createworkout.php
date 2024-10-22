<?php
require("models/exercises.php");
require("models/workoutplans.php");

$modelExercises = new Exercises();
$modelWorkoutPlans = new WorkoutPlans();

if (isset($_SESSION["user_id"])) {

    if (isset($_POST["save"])) {

        foreach ($_POST as $key => $value) {
            if (!is_array($value)) {
                $_POST[$key] = htmlspecialchars(strip_tags(trim($value)));
            }
        }

        if (
            !empty($_POST["plan_name"]) &&
            mb_strlen($_POST["plan_name"]) >= 3 &&
            mb_strlen($_POST["plan_name"]) <= 100 &&
            is_array($_POST["exercises"]) &&
            count($_POST["exercises"]) > 0
        ) {
            $planExercises = [];

            foreach ($_POST["exercises"] as $exercise) {
                if (
                    !empty($exercise["exercise_id"]) &&
                    isset($exercise["sets"]) && is_numeric($exercise["sets"]) &&
                    isset($exercise["reps"]) && is_numeric($exercise["reps"])
                ) {
                    $planExercises[] = [
                        'exercise_id' => htmlspecialchars(strip_tags(trim($exercise["exercise_id"]))),
                        'sets' => (int) $exercise["sets"],
                        'reps' => (int) $exercise["reps"]
                    ];
                }
            }

            $workout_plan_data = [
                'plan_name' => $_POST["plan_name"],
                'plan_description' => $_POST["plan_description"],
                'exercises' => $planExercises
            ];

            $workout_plan = $modelWorkoutPlans->createWorkoutPlan($_SESSION["user_id"], $workout_plan_data);

            if ($workout_plan) {
                header("Location: " . ROOT . "/gymtracker/createworkout/");
                exit();
            } else {
                $message = "Error creating workout plan. Please, try again.";
            }
        } else {
            $message = "Please provide a valid workout plan name and at least one exercise.";
        }
    }

    $exercises = $modelExercises->getAllExercises();

    $workoutPlans = $modelWorkoutPlans->getWorkoutPlansById($_SESSION["user_id"]);

    require("views/gymtracker/workoutplans.php");
} else {
    http_response_code(403);
    die("403: Access denied");
}
