<?php
class Conexao
{
    private $host = 'localhost'; // Endereço do servidor MySQL/MariaDB
    private $db_name = 'projeto_incendio'; // Nome do banco de dados
    private $username = 'webuser'; // Usuário com permissões no banco
    private $password = '1234'; // Senha do usuário

    private $conn; // Variável para armazenar a conexão

    // Método para obter a conexão
    public function getConnection()
    {
        $this->conn = null; // Inicializa a variável de conexão

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Define o modo de erro
        } catch (PDOException $exception) {
            throw new Exception("Erro na conexão: " . $exception->getMessage());
        }

        return $this->conn;
    }
}