import mysql.connector
import random
from datetime import datetime
from variaveis import HOST_DATABASE, USER_DATABASE, DATABASE, PASSWORD_DATABASE

def gerarConexao() -> mysql.connector.MySQLConnection | None:
    try:
        # Conectando ao banco de dados MySQL
        conn = mysql.connector.connect(
            host=HOST_DATABASE,
            user=USER_DATABASE,
            password=PASSWORD_DATABASE,
            database=DATABASE
        )
        return conn
    except mysql.connector.Error as err:
        print(f"Erro na conexão: {err}")
        return None

def inserirDados(umidade, temperatura, chama, fumaça, data_verificacao, resultado) -> None:

    # Cria a conexão
    conn = gerarConexao()

    if conn is None:
        print("Falha na conexão com o banco de dados.")
        return

    try:
        # Inicializa o cursor
        cursor = conn.cursor()

        # SQL para inserção com placeholders
        sql = """
        INSERT INTO dados (umidade, temperatura, chama, fumaça, data_verificacao, resultado) 
        VALUES (%s, %s, %s, %s, %s, %s)
        """

        # Executa o insert de forma segura
        cursor.execute(sql, [umidade, temperatura, chama, fumaça, data_verificacao, resultado])

        # Confirma as mudanças no banco de dados
        conn.commit()

        print("Dados enviados com sucesso!")

    except mysql.connector.Error as err:
        print(f"Erro ao executar o SQL: {err}")
        conn.rollback()  # Desfaz mudanças em caso de erro
    finally:
        # Garante que a conexão será fechada
        if cursor:
            cursor.close()
        if conn:
            conn.close()

if __name__ == "__main__":
    inserirDados(100, 30, 0, 1, "2024-09-03 09:15:00")