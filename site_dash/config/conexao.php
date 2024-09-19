<?php
class Conexao
{
    private string $host;
    private string $dbname;
    private string $username;
    private string $password;
    private PDO $pdo;

    public function __construct(
        string $host = 'localhost',
        string $dbname = 'projeto_incendio',
        string $username = 'root',
        string $password = '1234'
    ) {
        $this->host = $host;
        $this->dbname = $dbname;
        $this->username = $username;
        $this->password = $password;
    }

    public function conectarBD(): ?PDO
    {
        try {
            $this->pdo = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname};charset=utf8",
                $this->username,
                $this->password
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->pdo;
        } catch (PDOException $e) {
            echo "Erro na conexão: " . $e->getMessage();
            return null;
        }
    }
}
