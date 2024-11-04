<?php
require("models/workoutplans.php");
require("models/trainingschedule.php");

$modelWorkoutPlans = new WorkoutPlans();
$modelTrainingSchedule = new TrainingSchedule();

if (isset($_SESSION["user_id"])) {
    if (isset($_POST["submit"])) {
        foreach ($_POST as $key => $value) {
            $_POST[$key] = htmlspecialchars(strip_tags(trim($value)));
        }
        if (
            !empty($_POST["workout_plan_id"]) &&
            !empty($_POST["calendar_date"]) &&
            (int)$_POST["workout_plan_id"] > 0 &&
            preg_match('/^\d{4}-\d{2}-\d{2}$/', $_POST["calendar_date"])
        ) {

            $workoutPlanId = (int)$_POST["workout_plan_id"];
            $scheduledDate = $_POST["calendar_date"];

            $scheduleId = $modelTrainingSchedule->createTrainingSchedule($_SESSION["user_id"], $workoutPlanId, $scheduledDate);
        }
        if (!empty($scheduleId)) {
            header("Location: " . ROOT . "/gymtracker/training-schedule/");
            exit();
        } else {
            $message = "Please select a workout plan and enter a valid date.";
        }
    }

    $workoutPlans = $modelWorkoutPlans->getWorkoutPlansById($_SESSION["user_id"]);
    require("views/gymtracker/training-schedule.php");
} else {
    http_response_code(403);
    die("403: Access denied");
}
