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

def obterUltimoRegistro() -> tuple:
    conn = gerarConexao()

    if conn is None:
        print("Falha na conexão com o banco de dados.")
        return

    try:
        cursor = conn.cursor()

        # SQL para obter o último registro com a data de verificação inferior a 1 dia
        sql = """
        SELECT *
        FROM dados 
        WHERE STR_TO_DATE(data_verificacao, '%d/%m/%Y %H:%i:%s') < NOW() - INTERVAL 1 DAY
        ORDER BY STR_TO_DATE(data_verificacao, '%d/%m/%Y %H:%i:%s') DESC
        LIMIT 1
        """

        cursor.execute(sql)
        resultado = cursor.fetchone()

        if resultado:
            return resultado
        else:
            return (0, 0, 0, 0, 0, 0, 0)

    except mysql.connector.Error as err:
        print(f"Erro ao executar a consulta: {err}")
    finally:
        if cursor:
            cursor.close()
        if conn:
            conn.close()

if __name__ == "__main__":
    inserirDados(100, 30, 0, 1, "31/10/2024 14:50:23", 200, "Baixo Risco de Incêndio")
    print(obterUltimoRegistro())
