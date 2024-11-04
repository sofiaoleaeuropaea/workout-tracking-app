<?php
require("models/exercises.php");
require("models/workoutplans.php");
require("utility/encryption-utility.php");

$modelExercises = new Exercises();
$modelWorkoutPlans = new WorkoutPlans();

if (isset($_SESSION["user_id"])) {

    if (!empty($url_parts[3])) {

        require("controllers/gymtracker/update-workout.php");
    } elseif (isset($_POST["save"])) {

        foreach ($_POST as $key => $value) {
            if (!is_array($value)) {
                $_POST[$key] = htmlspecialchars(strip_tags(trim($value)));
            }
        }

        if (
            !empty($_POST["plan_name"]) &&
            mb_strlen($_POST["plan_name"]) >= 3 &&
            mb_strlen($_POST["plan_name"]) <= 100 &&
            is_array($_POST["exercises"])
        ) {

            $planExercises = [];
            foreach ($_POST["exercises"] as $exercise) {
                if (
                    !empty($exercise["exercise_id"]) &&
                    isset($exercise["sets"]) && is_numeric($exercise["sets"]) &&
                    isset($exercise["reps"]) && is_numeric($exercise["reps"]) &&
                    isset($exercise["exercise_order"]) && is_numeric($exercise["exercise_order"])
                ) {

                    $planExercises[] = [
                        'exercise_id' => htmlspecialchars(strip_tags(trim($exercise["exercise_id"]))),
                        'target_sets' => (int) $exercise["sets"],
                        'target_reps' => (int) $exercise["reps"],
                        'exercise_order' => (int) $exercise['exercise_order']
                    ];
                }
            }

            $workoutPlanCreate = [
                'plan_name' => $_POST["plan_name"],
                'plan_description' => $_POST["plan_description"],
                'exercises' => $planExercises
            ];

            $workoutPlan = $modelWorkoutPlans->createWorkoutPlan($_SESSION["user_id"], $workoutPlanCreate);

            if ($workoutPlan) {
                header("Location: " . ROOT . "/gymtracker/create-workout/");
                exit();
            } else {
                $message = "Error creating workout plan. Please try again.";
            }
        } else {
            $message = "Please provide a valid workout plan name and at least one exercise.";
        }
    }

    $exercises = $modelExercises->getAllExercises();

    $workoutPlans = $modelWorkoutPlans->getWorkoutPlansById($_SESSION["user_id"]);

    require("views/gymtracker/workout-plans.php");
} else {
    http_response_code(403);
    die("403: Access denied");
}
