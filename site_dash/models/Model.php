<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/site_dash/configs/Connection.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/site_dash/configs/PDOExceptionHandler.php";
class Model
{
    private $pdo;
    private $pdoExceptionHandler;

    public function __construct()
    {
        $e = 0;
        $this->pdo = (new Connection())->getConnection();
        $this->pdoExceptionHandler = new PDOExceptionHandler($e);
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

    public function getDashboardData()
    {
        try {
            if (!$this->pdo) {
                throw new Exception("Conexão com o banco de dados não está disponível");
            }
            $sql = "SELECT 
                    id,
                    umidade,
                    temperatura,
                    chama,
                    data_verificacao,
                    resultado
                FROM dados
                ORDER BY data_verificacao DESC
                LIMIT 30";
            $stmt = $this->pdo->prepare($sql);
            if (!$stmt->execute()) {
                $errorInfo = $stmt->errorInfo();
                throw new Exception("Erro ao executar consulta: " . $errorInfo[2]);
            }
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (empty($results)) {
                throw new Exception("Nenhum dado encontrado na tabela");
            }
            $dashboardData = [];
            foreach ($results as $row) {
                if (!isset($row['data_verificacao']) || !isset($row['temperatura'])) {
                    throw new Exception("Dados incompletos retornados do banco de dados");
                }
                $dashboardData[] = [
                    'id' => $row['id'],
                    'date' => $row['data_verificacao'],
                    'umidade' => (float) $row['umidade'],
                    'temperatura' => (float) $row['temperatura'],
                    'chama' => (bool) $row['chama'],
                    'resultado' => $row['resultado'] ?? null,
                    'value' => (float) $row['temperatura'] * ($row['chama'] ? 1.5 : 1)
                ];
            }
            return array_reverse($dashboardData);
        } catch (PDOException $e) {
            error_log("PDO Error in getDashboardData: " . $e->getMessage());
            throw new Exception("Erro no banco de dados: " . $e->getMessage());
        } catch (Exception $e) {
            error_log("General Error in getDashboardData: " . $e->getMessage());
            throw new Exception($e->getMessage());
        }
    }
}