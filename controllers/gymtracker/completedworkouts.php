<?php
require("models/workouttracker.php");

$modelWorkoutTracker = new WorkoutTracker();

if (isset($_SESSION["user_id"])) {

    header("Content-Type: application/json");

    $completedEvents = $modelWorkoutTracker->getExerciseTrackerByDate($_SESSION["user_id"]);

    $events = [];
    foreach ($completedEvents as $row) {
        $events[] = [
            'id' => $row['tracking_id'],
            'title' => $row['plan_name'],
            'start' => $row['tracking_date'],
            'description' => $row['tracking_notes'],
        ];
    }

    echo json_encode($events);
} else {
    http_response_code(403);
    die("403: Access denied");
}
