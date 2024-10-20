<?php
session_start();

define("ENV", parse_ini_file(".env"));
define("ROOT", "");

$url_parts = explode("/", $_SERVER["REQUEST_URI"]);

if (isset($url_parts[1]) && $url_parts[1] === "gymtracker") {
    $controller = isset($url_parts[2]) && !empty($url_parts[2]) ? $url_parts[2] : "dashboard";

    $id = isset($url_parts[3]) ? $url_parts[3] : null;

    if (!file_exists("controllers/gymtracker/" . $controller . ".php")) {
        http_response_code(404);
        die("Not Found");
    }

    require("controllers/gymtracker/" . $controller . ".php");
} else {
    $controller = isset($url_parts[1]) && !empty($url_parts[1]) ? $url_parts[1] : "home";

    $id = isset($url_parts[2]) ? $url_parts[2] : null;


    if (!file_exists("controllers/" . $controller . ".php")) {
        http_response_code(404);
        die("Not Found");
    }

    require("controllers/" . $controller . ".php");
}
