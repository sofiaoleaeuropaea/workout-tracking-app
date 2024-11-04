<?php
require("models/trainingschedule.php");

$modelTrainingCalendar = new trainingSchedule();

if (isset($_SESSION["user_id"])) {

    header("Content-Type: application/json");

    $scheduledEvents = $modelTrainingCalendar->getTrainingScheduleById($_SESSION["user_id"]);

    $events = [];
    foreach ($scheduledEvents as $row) {
        $events[] = [
            'id' => $row['schedule_id'],
            'title' => $row['plan_name'],
            'start' => $row['schedule_date'],
            'description' => $row['plan_description'],
        ];
    }

    echo json_encode($events);
} else {
    http_response_code(403);
    die("403: Access denied");
}
