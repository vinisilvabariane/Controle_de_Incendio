import socket
import mysql.connector
from mysql.connector import errorcode

def full_diagnosis():
    host = "192.168.0.108"
    port = 3306
    user = "webuser"
    password = "1234"
    database = "projeto_incendio"

    print("\n=== DIAGNÓSTICO DE CONEXÃO MYSQL ===")

    # 1. Teste de ping
    print("\n[1/4] Testando conectividade básica...")
    try:
        socket.gethostbyname(host)
        print(f"✓ O host {host} é resolvido corretamente")
    except socket.error:
        print(f"✗ Não foi possível resolver {host}")
        return

    # 2. Teste de porta
    print("\n[2/4] Testando acesso à porta 3306...")
    sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    sock.settimeout(5)
    try:
        sock.connect((host, port))
        print("✓ Porta 3306 está acessível")
    except socket.error as err:
        print(f"✗ Falha ao conectar na porta 3306: {err}")
        print("\nSOLUÇÕES SUGERIDAS:")
        print("1. Verifique se o serviço MySQL está rodando no servidor")
        print("2. Confira se o bind-address está como 0.0.0.0 no my.ini/my.cnf")
        print("3. Verifique as regras de firewall no servidor")
        return
    finally:
        sock.close()

    # 3. Teste de credenciais
    print("\n[3/4] Testando credenciais MySQL...")
    try:
        conn = mysql.connector.connect(
            host=host,
            user=user,
            password=password,
            database=database,
            port=port
        )
        print("✓ Credenciais válidas")
        conn.close()
    except mysql.connector.Error as err:
        if err.errno == errorcode.ER_ACCESS_DENIED_ERROR:
            print("✗ Erro de acesso: usuário/senha incorretos")
        elif err.errno == errorcode.ER_BAD_DB_ERROR:
            print("✗ Banco de dados não existe")
        else:
            print(f"✗ Erro MySQL: {err}")
        return

    # 4. Teste de consulta
    print("\n[4/4] Testando consulta básica...")
    try:
        conn = mysql.connector.connect(
            host=host,
            user=user,
            password=password,
            database=database,
            port=port
        )
        cursor = conn.cursor()
        cursor.execute("SELECT 1")
        result = cursor.fetchone()  # <- Evita o erro Unread result found
        if result:
            print("✓ Consulta executada com sucesso!")
        else:
            print("✗ Consulta não retornou resultado")
        cursor.close()
        conn.close()
    except Exception as e:
        print(f"✗ Falha na consulta: {e}")

    print("\nDiagnóstico completo!")

if __name__ == "__main__":
    full_diagnosis()
