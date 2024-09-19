<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/controller.php");
$access_control->validate(1);

$controller = new controller;
$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'getData':
        $controller->getData($data);
        break;
    default:
        header('Content-Type: application/json');
        http_response_code(404);
        echo json_encode([
            'status' => 'error',
            'message' => "Invalid request method."
        ]);
        break;
}