<?php
require("models/workoutplans.php");
require("models/workouttracker.php");
require("validators/validators.php");

$modelWorkoutPlans = new WorkoutPlans();
$modelWorkoutTracker = new WorkoutTracker();

$messageWrongInfo = '{"message": "400 Bad Request"}';

if (isset($_SESSION["user_id"])) {

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST["submit"])) {

        header('Content-Type: application/json');
        $input = json_decode(file_get_contents("php://input"), true);

        if (isset($input['plan_id']) && is_numeric($input['plan_id'])) {
            $planId = $input['plan_id'];

            $exercises = $modelWorkoutPlans->getWorkoutPlansDetails($planId);

            echo json_encode($exercises);
        } else {
            http_response_code(400);
            echo $messageWrongInfo;
        }
        exit();
    }

    if (isset($_POST["submit"])) {

        foreach ($_POST as $key => $value) {
            if (!is_array($value)) {
                $_POST[$key] = htmlspecialchars(strip_tags(trim($value)));
            }
        }

        if (
            !empty($_POST["workout_plan"]) && is_numeric($_POST["workout_plan"]) &&
            !empty($_POST["date"]) && !empty($_POST["sets"]) && is_array($_POST["sets"])
        ) {

            $exerciseTracker = [];
            foreach ($_POST["sets"] as $exerciseId => $sets) {
                foreach ($sets as $set) {
                    if (
                        !empty($set["reps"]) && is_numeric($set["reps"]) && $set["reps"] > 0 &&
                        !empty($set["weight"]) && is_numeric($set["weight"]) && isValidDecimal($set["weight"])
                    ) {
                        $exerciseTracker[$exerciseId][] = [
                            'reps' => (int) $set["reps"],
                            'weight' => (float) $set["weight"]
                        ];
                    }
                }
            }
            $trackerData = [
                'date' => $_POST['date'],
                'notes' => $_POST['notes'] ?? '',
                'exercisesTracker' => $exerciseTracker
            ];

            $trackingId = $modelWorkoutTracker->createExerciseTracker($_SESSION["user_id"], (int)$_POST["workout_plan"], $trackerData);
            header("Location: " . ROOT . "/gymtracker/workout-tracker/");
        }
    }

    $workoutPlans = $modelWorkoutPlans->getWorkoutPlansById($_SESSION["user_id"]);

    require("views/gymtracker/workout-tracker.php");
} else {
    http_response_code(403);
    die("403: Access denied");
}
