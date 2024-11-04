<?php
require("models/users.php");
require("models/trainingschedule.php");

$modelUsers = new Users();
$modelTrainingSchedule = new TrainingSchedule();

if (isset($_SESSION["user_id"])) {

    $user = $modelUsers->getUserById($_SESSION["user_id"]);
    if ($user) {
        $defaultPhoto = '/images/userprofile/default-profile-icon.webp';
        $user['photo'] = !empty($user['photo']) ? '/' . ltrim($user['photo'], '/') : $defaultPhoto;

        $exercises = $modelTrainingSchedule->getTrainingScheduleByCurrDate($_SESSION["user_id"]);
        require("views/gymtracker/dashboard.php");
    } else {
        http_response_code(404);
        die("404: User not found");
    }
} else {
    http_response_code(403);
    die("403: Access denied");
}
