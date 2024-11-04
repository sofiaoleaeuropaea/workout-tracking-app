<?php
require("models/exercises.php");
require("models/analytics.php");
require("utility/encryption-utility.php");

$modelExercises = new Exercises();
$modelAnalytics = new Analytics();

$key = ENV["ENCRYPT_KEY"];
$encryptionUtility = new EncryptionUtility($key);

if (isset($_SESSION["admin_id"])) {

    $url_parts = explode("/", $_SERVER["REQUEST_URI"]);
    $url_part_3 = explode("?", $url_parts[3]);

    if (!empty($url_parts[3]) && isset($_GET['exercise_id'])) {

        require("controllers/admin/workout-edit.php");
    } elseif (!empty($url_parts[3]) && $url_part_3[0] === "create") {
        require("controllers/admin/workout-create.php");
    } else {

        $postsPerPage = 15;

        $totalExercises = $modelAnalytics->getTotalExercises()['total_exercises'];
        $totalPages = ceil($totalExercises / $postsPerPage);

        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $currentPage = max(1, min($currentPage, $totalPages));

        $offset = ($currentPage - 1) * $postsPerPage;

        $exercises = $modelAnalytics->getExercisesPerPage($offset, $postsPerPage);

        require("views/admin/workout-library.php");
    }
} else {
    http_response_code(403);
    die("403: Access denied");
}
