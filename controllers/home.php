<?php
if (isset($_SESSION["user_id"])) {
    header("Location: " . ROOT . "/gymtracker/dashboard/");
    exit();
}
if (isset($_SESSION["admin_id"])) {
    header("Location: " . ROOT . "/admin/dashboard/");
    exit();
}
require("views/home.php");
