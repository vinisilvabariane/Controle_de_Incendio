<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/conexao.php");

class model
{
    private PDO $pdo;
    private $errorHandler;

    public function __construct(?PDO $pdo = null)
    {
        $this->pdo = $pdo ?? (new Conexao())->conectarBD("master_data");
    }

    private function executeQuery(string $query, array $params = []): ?PDOStatement
    {
        try {
            $stmt = $this->pdo->prepare($query);
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            $this->errorHandler->pdoExceptionHandler($e);
            return null;
        }
    }

    public function getData(array $data): ?array
    {
        $query = "SELECT idDados, umidade, temperatura, chama, fumaça, dataVerificacao, longitude, latitude FROM dados";
        $stmt = $this->executeQuery($query);
        return $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : null;
    }
}