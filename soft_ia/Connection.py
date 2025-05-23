import mysql.connector
from datetime import datetime
from Utils import HOST_DATABASE, USER_DATABASE, DATABASE, PASSWORD_DATABASE

def gerarConexao() -> mysql.connector.MySQLConnection | None:
    try:
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

def inserirDados(temperatura: float, umidade: float, bomba: int, data_verificacao: str, resultado: str) -> bool:
    """
    Insere dados no banco de dados
    Retorna True se a inserção foi bem-sucedida, False caso contrário
    """
    conn = gerarConexao()
    if conn is None:
        print("Falha na conexão com o banco de dados.")
        return False
    
    cursor = None
    try:
        cursor = conn.cursor()
        sql = """
        INSERT INTO dados (temperatura, umidade, chama, data_verificacao, resultado) 
        VALUES (%s, %s, %s, %s, %s)
        """
        # Convertendo a string de data para o formato do MySQL (YYYY-MM-DD HH:MM:SS)
        data_mysql = datetime.strptime(data_verificacao, '%d/%m/%Y %H:%M:%S').strftime('%Y-%m-%d %H:%M:%S')
        
        cursor.execute(sql, (temperatura, umidade, bomba, data_mysql, resultado))
        conn.commit()
        return True
    except mysql.connector.Error as err:
        print(f"Erro ao inserir dados: {err}")
        conn.rollback()
        return False
    except ValueError as e:
        print(f"Erro no formato da data: {e}")
        return False
    finally:
        if cursor:
            cursor.close()
        if conn:
            conn.close()

def obterUltimoRegistro() -> tuple:
    """
    Obtém o último registro inserido no banco de dados
    Retorna uma tupla com os dados ou None em caso de erro
    """
    conn = gerarConexao()
    if conn is None:
        print("Falha na conexão com o banco de dados.")
        return None
    
    cursor = None
    try:
        cursor = conn.cursor(dictionary=True)
        sql = """
        SELECT temperatura, umidade, chama, 
               DATE_FORMAT(data_verificacao, '%d/%m/%Y %H:%i:%s') as data_verificacao, 
               resultado
        FROM dados 
        ORDER BY data_verificacao DESC
        LIMIT 1
        """
        cursor.execute(sql)
        resultado = cursor.fetchone()
        return resultado if resultado else None
    except mysql.connector.Error as err:
        print(f"Erro ao obter último registro: {err}")
        return None
    finally:
        if cursor:
            cursor.close()
        if conn:
            conn.close()

if __name__ == "__main__":
    # Teste da função de inserção
    sucesso = inserirDados(
        temperatura=30.5,
        umidade=65.2,
        bomba=0,
        data_verificacao=datetime.now().strftime('%d/%m/%Y %H:%M:%S'),
        resultado="Baixo Risco de Incêndio"
    )
    
    if sucesso:
        print("Dados inseridos com sucesso!")
    else:
        print("Falha ao inserir dados.")
    
    # Teste da função de consulta
    ultimo_registro = obterUltimoRegistro()
    print("\nÚltimo registro:")
    print(ultimo_registro)