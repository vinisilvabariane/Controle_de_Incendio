<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/model/model.php";

class Controller {
    private $model;

    public function __construct() {
        $this->model = new Model();
    }

    public function getData(): void {
        try {
            $data = $this->model->getData(); // Chama o método do Model para buscar os dados
            if ($data) {
                header('Content-Type: application/json');
                echo json_encode($data);
            } else {
                $this->sendErrorResponse(404, "Nenhum dado encontrado.");
            }
        } catch (Exception $e) {
            $this->sendErrorResponse(500, $e->getMessage());
        }
    }

    private function sendErrorResponse(int $statusCode, string $message): void {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo json_encode([
            'status' => 'error',
            'message' => $message
        ]);
        exit;
    }
}
?>
