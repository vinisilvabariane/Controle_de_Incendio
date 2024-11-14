<?php
class Conexao {
    private $host = 'localhost'; // Endereço do servidor MySQL
    private $db_name = 'projeto_incendio'; // Nome do banco de dados
    private $username = 'root'; // Nome de usuário do MySQL
    private $password = '123'; // Senha do MySQL
    private $conn; // Variável para armazenar a conexão

    // Método para obter a conexão
    public function getConnection() {
        $this->conn = null; // Inicializa a variável de conexão

        try {
            // Tenta conectar ao banco de dados usando PDO
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Define o modo de erro
        } catch(PDOException $exception) {
            // Lança uma exceção em caso de erro na conexão
            throw new Exception("Erro na conexão: " . $exception->getMessage());
        }

        return $this->conn; // Retorna a conexão
    }
}
?>
