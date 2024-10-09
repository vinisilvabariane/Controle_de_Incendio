import mysql.connector
import random
from datetime import datetime
from variaveis import HOST_DATABASE, USER_DATABASE, DATABASE, PASSWORD_DATABASE

def gerarConexao():
    # Conectando ao banco de dados MySQL
    conn = mysql.connector.connect(
        host=HOST_DATABASE,
        user=USER_DATABASE,
        password=PASSWORD_DATABASE,
        database= DATABASE
    )

    # Inicializa o cursor
    return conn

def inserirDados(umidade, temperatura, chama, fumaça, data_verificacao):

    # Cria a conexão
    conn = gerarConexao()

    # Inicializa o cursor
    cursor = conn.cursor()

    # SQL para inserção com placeholders para evitar injeção de código
    sql = """
    INSERT INTO dados (umidade, temperatura, chama, fumaça, data_verificacao) 
    VALUES (%s, %s, %s, %s, %s)
    """

    # Executa o insert de forma segura
    cursor.execute(sql, [umidade, temperatura, chama, fumaça, data_verificacao])

    # Confirma as mudanças no banco de dados
    conn.commit()

    # Fecha a conexão
    cursor.close()
    conn.close()

if __name__ == "__main__":
    inserirDados(100, 30, 0, 1, "2024-09-03 09:15:00")