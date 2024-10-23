<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/config/conexao.php";

class Model {
    private $pdo;

    public function __construct() {
        $this->pdo = (new Conexao())->getConnection();
    }

    public function getData(): ?array {
        try {
            $query = "SELECT idDados, umidade, temperatura, chama, fumaça, data_verificacao, resultado FROM dados";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Erro de execução de consulta
            throw new Exception("Erro ao executar consulta: " . $e->getMessage());
        }
    }
}
?>