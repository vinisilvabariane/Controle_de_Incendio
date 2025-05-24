<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/site_dash/controllers/Controller.php";

$controller = new Controller();
$action = isset($_GET["action"]) ? $_GET["action"] : "";

switch ($action) {
    case "login":
        $controller->login();
        break;
    case "getDashboardData":
        $controller->getDashboardData();
        break;
    default:
        header("Content-Type: application/json");
        http_response_code(405);
        echo json_encode(["success" => false, "message" => "Ação não permitida"]);
        break;
}