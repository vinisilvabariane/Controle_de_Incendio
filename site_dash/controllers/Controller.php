<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/site_dash/models/Model.php";

class Controller
{
    private $model;

    public function __construct()
    {
        $this->model = new Model();
    }

    public function login(): void
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $username = $_POST["username"] ?? "";
            $password = $_POST["password"] ?? "";
            if ($username && $password) {
                try {
                    if ($this->model->login($username, $password)) {
                        session_start();
                        $_SESSION["logado"] = true;
                        $_SESSION["username"] = $username;
                        echo json_encode([
                            "status" => "success",
                            "message" => "Login realizado com sucesso."
                        ]);
                    } else {
                        $this->sendErrorResponse(401, "Usuário ou senha incorretos.");
                    }
                } catch (Exception $e) {
                    $this->sendErrorResponse(500, $e->getMessage());
                }
            } else {
                $this->sendErrorResponse(400, "Parâmetros insuficientes para login.");
            }
        } else {
            $this->sendErrorResponse(405, "Método de requisição inválido. Use POST.");
        }
    }

    public function getDashboardData()
    {
        header("Content-Type: application/json");
        error_log("getDashboardData called");
        try {
            $model = new Model();
            error_log("Model instantiated");
            $data = $model->getDashboardData();
            error_log("Data received from model: " . print_r($data, true));
            echo json_encode([
                'success' => true,
                'data' => $data
            ]);
        } catch (Exception $e) {
            error_log("Exception in getDashboardData: " . $e->getMessage());
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Erro ao buscar dados do dashboard: ' . $e->getMessage(),
                'trace' => $e->getTrace()
            ]);
        }
    }
    
    private function sendErrorResponse(int $statusCode, string $message): void
    {
        header("Content-Type: application/json");
        http_response_code($statusCode);
        echo json_encode([
            "status" => "error",
            "message" => $message
        ]);
        exit;
    }
}
