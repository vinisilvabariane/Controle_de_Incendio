<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/site_dash/configs/Connection.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/site_dash/configs/PDOExceptionHandler.php";
class Model
{
    private $pdo;
    private $pdoExceptionHandler;

    public function __construct()
    {
        $this->pdo = (new Connection())->getConnection();
        $this->pdoExceptionHandler = new PDOExceptionHandler;
    }

    public function login(string $username, string $password): bool
    {
        try {
            $query = "SELECT * FROM users WHERE username = :username AND password = MD5(:password)";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(":username", $username, PDO::PARAM_STR);
            $stmt->bindParam(":password", $password, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            $this->pdoExceptionHandler->PDOExceptionHandler($e);
            return false;
        }
    }


    public function deleteVideo($videoId)
    {
        try {
            $query = "DELETE FROM videos WHERE id = :id";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':id', $videoId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            $this->pdoExceptionHandler->PDOExceptionHandler($e);
        }
    }

    public function getVideoById($videoId)
    {
        try {
            $query = "SELECT link, linkImage FROM videos WHERE id = :id";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':id', $videoId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->pdoExceptionHandler->PDOExceptionHandler($e);
        }
    }

    public function getByPriority(string $location): array
    {
        try {
            $query = "SELECT * FROM videos WHERE filial = :filial ORDER BY priority ASC";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':filial', $location, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->pdoExceptionHandler->PDOExceptionHandler($e);
            return [];
        }
    }

    public function getPriority(string $location): array
    {
        $query = "SELECT priority FROM videos WHERE filial = :location";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':location', $location, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_COLUMN);
        return $result ?: [];
    }

    public function updateVideoOrder(array $orderedVideos, string $location): void
    {
        try {
            $this->pdo->beginTransaction();
            foreach ($orderedVideos as $priority => $videoId) {
                $priority += 1;
                $query = "UPDATE videos SET priority = :priority WHERE id = :id AND filial = :filial";
                $stmt = $this->pdo->prepare($query);
                $stmt->bindParam(':priority', $priority, PDO::PARAM_INT);
                $stmt->bindParam(':id', $videoId, PDO::PARAM_INT);
                $stmt->bindParam(':filial', $location, PDO::PARAM_STR);
                $stmt->execute();
            }
            $this->pdo->commit();
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            $this->pdoExceptionHandler->PDOExceptionHandler($e);
        }
    }

    public function addVideo(string $link, string $title, int $priority, string $filial, ?string $linkImage): void
    {
        try {
            if (empty($link)) {
                throw new Exception('O link do vídeo não pode estar vazio.');
            }
            $this->pdo->beginTransaction();
            $query = "INSERT INTO videos (link, title, priority, filial, linkImage) VALUES (:link, :title, :priority, :filial, :linkImage);";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(":link", $link, PDO::PARAM_STR);
            $stmt->bindParam(":title", $title, PDO::PARAM_STR);
            $stmt->bindParam(':priority', $priority, PDO::PARAM_INT);
            $stmt->bindParam(':filial', $filial, PDO::PARAM_STR);
            $stmt->bindParam(':linkImage', $linkImage, PDO::PARAM_STR | PDO::PARAM_NULL);
            $stmt->execute();
            $this->pdo->commit();
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            $this->pdoExceptionHandler->PDOExceptionHandler($e);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
