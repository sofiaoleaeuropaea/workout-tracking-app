<?php
require("models/workoutplans.php");

$modelWorkoutPlans = new WorkoutPlans();
header("Content-Type: application/json");

$messageError = '{"message": "400 Bad Request"}';
$messageWrongInfo = '{"message": "Incorrect information"}';

if (isset($_SESSION["user_id"])) {

    if ($_SERVER["REQUEST_METHOD"] === "DELETE") {

        $body = json_decode(file_get_contents("php://input"), true);

        if (isset($body['plan_id']) && is_numeric($body['plan_id'])) {

            $planDeleted = $modelWorkoutPlans->deleteWorkoutPlan($body['plan_id']);

            if ($planDeleted) {
                http_response_code(200);
                exit();
            }
        } else {
            http_response_code(400);
            echo $messageWrongInfo;
        }
    }
} else {
    http_response_code(403);
    echo $messageError;
}
