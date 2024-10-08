<?php
class Conexao {
    private $host = 'localhost';
    private $db_name = 'projeto_incendio';
    private $username = 'root';
    private $password = '1234';
    private $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            throw new Exception("Erro na conexão: " . $exception->getMessage());
        }

        return $this->conn;
    }
}
?>
