<?php
if (isset($_SESSION["user_id"])) {
    header("Location: " . ROOT . "/gymtracker/dashboard/");
    exit();
}
require("views/home.php");
