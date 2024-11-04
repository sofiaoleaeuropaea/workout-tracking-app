<?php
require("models/workoutplans.php");
require("models/workouttracker.php");
require("validators/validators.php");

$modelWorkoutPlans = new WorkoutPlans();
$modelWorkoutTracker = new WorkoutTracker();

$messageError = '{"message": "403 Forbidden"}';
$messageWrongInfo = '{"message": "400 Bad Request"}';


if (isset($_SESSION["user_id"])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST["submit"])) {

        header('Content-Type: application/json');

        if (isset($_POST['get_plan_tracker'])) {
            $planTrackerId = $_POST['get_plan_tracker'];

            $workoutPlans = $modelWorkoutPlans->getWorkoutPlansById($_SESSION["user_id"]);
            $workoutsTracker = $modelWorkoutTracker->getExerciseTrackerByWorkoutPlan($planTrackerId);

            $workoutTrackerCard = [
                "plan_name" => $workoutsTracker[0]['plan_name'],
                "tracking_ids" => []
            ];
            $trackingMap = [];

            foreach ($workoutsTracker as $tracker) {

                if (!isset($trackingMap[$tracker['tracking_id']])) {

                    $trackingMap[$tracker['tracking_id']] = [
                        "tracking_id" => $tracker['tracking_id'],
                        "tracking_date" => $tracker['tracking_date'],
                        "tracking_notes" => $tracker['tracking_notes'],
                        "exercises" => []
                    ];
                }

                $exerciseEntry = [
                    "name" => $tracker["exercise_name"],
                    "order" => $tracker["exercise_order"],
                    "sets" => []
                ];

                $exerciseEntry["sets"][] = [
                    "set_number" => $tracker["set_number"],
                    "reps" => $tracker["reps"],
                    "kg" => $tracker["weight"]
                ];

                $existingExerciseKey = null;
                foreach ($trackingMap[$tracker['tracking_id']]['exercises'] as $key => $existingExercise) {
                    if ($existingExercise["name"] === $exerciseEntry["name"]) {
                        $existingExerciseKey = $key;
                        break;
                    }
                }

                if ($existingExerciseKey !== null) {
                    $trackingMap[$tracker['tracking_id']]['exercises'][$existingExerciseKey]['sets'][] = [
                        "set_number" => $tracker["set_number"],
                        "reps" => $tracker["reps"],
                        "kg" => $tracker["weight"]
                    ];
                } else {
                    $trackingMap[$tracker['tracking_id']]['exercises'][] = $exerciseEntry;
                }
            }

            $workoutTrackerCard["tracking_ids"] = array_values($trackingMap);

            echo json_encode([$workoutTrackerCard]);
        } else {
            http_response_code(400);
            echo $messageWrongInfo;
        }
        exit();
    }

    $workoutPlans = $modelWorkoutPlans->getWorkoutPlansById($_SESSION["user_id"]);

    require("views/gymtracker/workout-tracker.php");
} else {
    http_response_code(403);
    die("403: Access denied");
}
