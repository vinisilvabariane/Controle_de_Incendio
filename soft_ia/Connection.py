import mysql.connector
from datetime import datetime
from Utils import HOST_DATABASE, USER_DATABASE, DATABASE, PASSWORD_DATABASE
import time

def gerarConexao(max_tentativas=3, delay=2) -> mysql.connector.MySQLConnection | None:
    """
    Tenta estabelecer conexão com o banco de dados com tratamento de erros aprimorado
    """
    tentativas = 0
    ultimo_erro = None
    
    while tentativas < max_tentativas:
        try:
            conn = mysql.connector.connect(
                host=HOST_DATABASE,
                user=USER_DATABASE,
                password=PASSWORD_DATABASE,
                database=DATABASE,
                port=3306,  # Explicitando a porta padrão
                connection_timeout=5  # Timeout de 5 segundos
            )
            
            # Verifica se a conexão está ativa
            if conn.is_connected():
                print(f"Conexão estabelecida com {HOST_DATABASE}")
                return conn
            
        except mysql.connector.Error as err:
            ultimo_erro = err
            print(f"Tentativa {tentativas + 1} falhou: {err}")
            if tentativas < max_tentativas - 1:
                print(f"Tentando novamente em {delay} segundos...")
                time.sleep(delay)
            tentativas += 1
    
    print(f"Falha após {max_tentativas} tentativas. Último erro: {ultimo_erro}")
    return None

def inserirDados(temperatura: float, umidade: float, bomba: int, data_verificacao: str, resultado: str) -> bool:
    """
    Insere dados no banco de dados com tratamento de erros aprimorado
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
        try:
            data_mysql = datetime.strptime(data_verificacao, '%d/%m/%Y %H:%M:%S').strftime('%Y-%m-%d %H:%M:%S')
        except ValueError as e:
            print(f"Formato de data inválido: {data_verificacao}. Usando data atual.")
            data_mysql = datetime.now().strftime('%Y-%m-%d %H:%M:%S')
        
        cursor.execute(sql, (temperatura, umidade, bomba, data_mysql, resultado))
        conn.commit()
        print("Dados inseridos com sucesso!")
        return True
        
    except mysql.connector.Error as err:
        print(f"Erro ao inserir dados: {err}")
        if err.errno == 1146:  # Table doesn't exist
            print("Erro: Tabela 'dados' não existe no banco de dados.")
        elif err.errno == 1045:  # Access denied
            print("Erro: Acesso negado. Verifique usuário e senha.")
        conn.rollback()
        return False
    except Exception as e:
        print(f"Erro inesperado: {e}")
        return False
    finally:
        if cursor:
            cursor.close()
        if conn and conn.is_connected():
            conn.close()

def obterUltimoRegistro() -> tuple:
    """
    Obtém o último registro inserido no banco de dados
    Retorna um dicionário com os dados ou None em caso de erro
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
        
        if resultado:
            print("Último registro obtido com sucesso!")
            return resultado
        else:
            print("Nenhum registro encontrado na tabela 'dados'.")
            return None
            
    except mysql.connector.Error as err:
        print(f"Erro ao obter último registro: {err}")
        return None
    finally:
        if cursor:
            cursor.close()
        if conn and conn.is_connected():
            conn.close()

if __name__ == "__main__":
    print("\nTestando conexão com o banco de dados...")
    
    # Teste da função de inserção
    print("\nTestando inserção de dados...")
    sucesso = inserirDados(
        temperatura=30.5,
        umidade=65.2,
        bomba=0,
        data_verificacao=datetime.now().strftime('%d/%m/%Y %H:%M:%S'),
        resultado="Baixo Risco de Incêndio"
    )
    
    # Teste da função de consulta
    print("\nTestando consulta de dados...")
    ultimo_registro = obterUltimoRegistro()
    print("\nÚltimo registro encontrado:")
    print(ultimo_registro if ultimo_registro else "Nenhum registro disponível")