<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/site_dash/controllers/Controller.php";

$controller = new Controller();
$action = isset($_GET["action"]) ? $_GET["action"] : "";

switch ($action) {
    case "login":
        $controller->login();
        break;
    case "videoView":
        $controller->videoView();
        break;
    case "getByPriority":
        $controller->getByPriority();
        break;
    case "updateVideoOrder":
        $controller->updateVideoOrder();
        break;
    case "deletePathVideo";
        $controller->deletePathVideo();
        break;
    default:
        header("Content-Type: application/json");
        http_response_code(405);
        break;
}
