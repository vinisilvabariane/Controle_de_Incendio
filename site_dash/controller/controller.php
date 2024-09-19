<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/model.php");

class controller
{
    private model $model;
    public function __construct()
    {$this->model = new model();}
    const METHOD_POST = 'POST';
    
    public function getData(array $data)
    {
        $resultado = $this->model->getData($data);
        if (isset($resultado)) echo json_encode($resultado);
        exit;
    }

    private function sendErrorResponse(int $statusCode, string $message): void
    {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo json_encode([
            'status' => 'error',
            'message' => $message
        ]);
        exit;
    }
}