<?php

$modelExercises = new Exercises();
$modelWorkoutPlans = new WorkoutPlans();

if (isset($_GET['plan_id'])) {

    $planId = $_GET['plan_id'];

    $planDetails = $modelWorkoutPlans->getWorkoutPlansDetails($planId);

    if ($planDetails) {
        $planId = $planDetails[0]['plan_id'];
        $planName = $planDetails[0]['plan_name'];
        $planDescription = $planDetails[0]['plan_description'];
        $existingExercises = [];

        foreach ($planDetails as $exercise) {
            $existingExercises[] = [
                'exercise_id' => $exercise['exercise_id'],
                'exercise_name' => $exercise['exercise_name'],
                'sets' => $exercise['target_sets'],
                'reps' => $exercise['target_reps'],
                'exercise_order' => $exercise['exercise_order']
            ];
        }
    }

    if (isset($_POST["update"])) {
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

            $workoutPlanData = [
                'plan_name' => $_POST["plan_name"],
                'plan_description' => $_POST["plan_description"],
                'exercises' => $planExercises
            ];

            $updatedWorkout = $modelWorkoutPlans->updateWorkoutPlan($workoutPlanData, $_SESSION["user_id"], (int)$_POST['plan_id']);

            if ($updatedWorkout) {
                header("Location: " . ROOT . "/gymtracker/create-workout/");
                exit();
            } else {
                $message = "Error updating workout plan. Please try again.";
            }
        } else {
            $message = "Please provide a valid workout plan name and at least one exercise.";
        }
    }
}

$exercises = $modelExercises->getAllExercises();

$workoutPlans = $modelWorkoutPlans->getWorkoutPlansById($_SESSION["user_id"]);
