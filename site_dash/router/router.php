<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/controller/controller.php";

$controller = new Controller();
$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'getData':
        $controller->getData();
        break;
    default:
        header('Content-Type: application/json');
        http_response_code(404);
        echo json_encode([
            'status' => 'error',
            'message' => "Método de requisição inválido."
        ]);
        break;
}