<?php
if (isset($_SESSION["user_id"])) {
    require("views/gymtracker/dashboard.php");
} else {
    http_response_code(403);
    die("403: Access denied");
}
