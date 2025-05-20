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

    private function processVideo(?array $video, string $directoryBaseVideo, string $location, string $title, ?string $thumbnailLink): void
    {
        if ($video && $video['error'] === UPLOAD_ERR_OK) {
            $newFileName = $this->generateUniqueFileName('', 'mp4', $directoryBaseVideo, 5);
            $uploadPath = $directoryBaseVideo . $newFileName;
            if (!move_uploaded_file($video['tmp_name'], $uploadPath)) {
                throw new Exception('Falha no envio do vídeo.');
            }
            $videoLink = "/site_dash/public/videos/$location/$newFileName";
            $title = $title ?: "Vídeo " . pathinfo($newFileName, PATHINFO_FILENAME);
            $usedPriorities = $this->model->getPriority($location);
            $priority = $this->getAvailablePriority($usedPriorities);
            $this->model->addVideo($videoLink, $title, $priority, $location, $thumbnailLink);
        } else {
            throw new Exception('Nenhum vídeo foi enviado.');
        }
    }

    private function getAvailablePriority(array $usedPriorities): int
    {
        for ($i = 1; $i <= 5; $i++) {
            if (!in_array($i, $usedPriorities)) {
                return $i;
            }
        }
        throw new Exception('Não há prioridades disponíveis.');
    }

    private function generateUniqueFileName(string $prefix, string $extension, string $directory, int $limit = PHP_INT_MAX): string
    {
        $existingFiles = array_filter(scandir($directory), function ($file) use ($prefix, $extension) {
            return preg_match("/^{$prefix}(\\d+)\\.{$extension}$/", $file);
        });
        $existingNumbers = array_map(function ($file) use ($prefix, $extension) {
            preg_match("/^{$prefix}(\\d+)\\.{$extension}$/", $file, $matches);
            return (int)$matches[1];
        }, $existingFiles);
        $nextNumber = 1;
        while (in_array($nextNumber, $existingNumbers)) {
            $nextNumber++;
            if ($nextNumber > $limit) {
                throw new Exception('Limite de arquivos atingido.');
            }
        }
        return "{$prefix}{$nextNumber}.{$extension}";
    }

    public function getByPriority(): void
    {
        try {
            $location = $_POST['filial'] ?? '';
            $result = $this->model->getByPriority($location);
            echo json_encode($result);
        } catch (PDOException $e) {
            $this->sendErrorResponse(500, "Erro para buscar video por prioridade!" . $e->getMessage());
        }
    }

    public function deletePathVideo()
    {
        try {
            if (!isset($_POST['id'])) {
                throw new Exception('ID do vídeo não fornecido.');
            }
            $id = $_POST['id'];
            $videoData = $this->model->getVideoById($id);
            if ($videoData) {
                $videoPath = $_SERVER['DOCUMENT_ROOT'] . $videoData['link'];
                $imagePath = $_SERVER['DOCUMENT_ROOT'] . $videoData['linkImage'];
                $response = [];
                if (file_exists($videoPath)) {
                    if (unlink($videoPath)) {
                        $response['videoDeleted'] = true;
                    } else {
                        $response['videoDeleted'] = false;
                    }
                } else {
                    $response['videoNotFound'] = true;
                }
                if (file_exists($imagePath)) {
                    if (unlink($imagePath)) {
                        $response['imageDeleted'] = true;
                    } else {
                        $response['imageDeleted'] = false;
                    }
                } else {
                    $response['imageNotFound'] = true;
                }
                $result = $this->model->deleteVideo($id);
                if ($result) {
                    $response['success'] = true;
                    $response['message'] = 'Vídeo e thumbnail deletados com sucesso!';
                } else {
                    $response['success'] = false;
                    $response['message'] = 'Erro ao deletar o vídeo do banco de dados!';
                }
                echo json_encode($response);
            } else {
                echo json_encode(['success' => false, 'message' => 'Vídeo não encontrado!']);
            }
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Erro para deletar o vídeo! ' . $e->getMessage()]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function updateVideoOrder(): void
    {
        try {
            $location = $_POST['filial'] ?? '';
            $orderedVideos = json_decode($_POST['orderedVideos'], true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception("Erro ao decodificar os dados recebidos.");
            }
            if (empty($orderedVideos)) {
                throw new Exception("Nenhuma ordem de vídeos recebida.");
            }
            error_log("Filial: " . $location);
            error_log("Ordered Videos: " . implode(',', $orderedVideos));
            $this->model->updateVideoOrder($orderedVideos, $location);
            echo json_encode(["status" => "success"]);
        } catch (Exception $e) {
            $this->sendErrorResponse(500, "Falha ao atualizar a ordem dos vídeos: " . $e->getMessage());
        }
    }

    public function videoView(): void
    {
        try {
            $input = json_decode(file_get_contents('php://input'), true);
            $location = $input['location'] ?? '';
            if (!$location) {
                echo json_encode(["success" => false, "message" => "Localização não informada."]);
                exit;
            }
            $videos = $this->model->getByPriority($location);
            if (empty($videos)) {
                echo json_encode(["success" => false, "message" => "Nenhum vídeo encontrado!"]);
                exit;
            }
            $videoURLs = array_map(
                fn($video) => $video['link'] . "?t=" . time(),
                array_slice($videos, 0, 5)
            );
            header("Cache-Control: no-cache, must-revalidate, max-age=0");
            echo json_encode(["success" => true, "videos" => $videoURLs]);
        } catch (Exception $e) {
            echo json_encode(["success" => false, "message" => "Erro interno: " . $e->getMessage()]);
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
