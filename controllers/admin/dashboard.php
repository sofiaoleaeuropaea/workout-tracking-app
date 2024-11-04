<?php
require("models/admin.php");
require("models/analytics.php");

$modelAdmin = new Admin();
$modelAnalytics = new Analytics();

if (isset($_SESSION["admin_id"])) {

    $admin = $modelAdmin->getAdminById($_SESSION["admin_id"]);
    $totalUsers = $modelAnalytics->getTotalUsers();
    $newUsers = $modelAnalytics->getNewUsers();

    require("views/admin/dashboard.php");
} else {
    http_response_code(403);
    die("403: Access denied");
}
