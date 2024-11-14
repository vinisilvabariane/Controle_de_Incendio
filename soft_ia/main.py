from IA import IA_Incêndios
import numpy as np
from variaveis import PORTA_ARDUINO
import os
from sql import inserirDados, obterUltimoRegistro
import datetime
from serial_Arduino import obterMsgSerial
from tabulate import tabulate  # Adicionamos a importação do tabulate
import time

# Variáveis iniciais
chama = 0
fumaca = 0
temperatura = 0
umidade = 0
fumacaBool = 0

def iniciar_ia():
    ia = IA_Incêndios("Braganca Paulista", range(2020, 2021))
    ia.impotarDados()
    ia.tratarDados()
    ia.analisarDados()
    ia.converterEmClassificação([0, 1, 1.5, 2, 2.5, np.inf], 
                                ["ALERTA! Altíssimo risco de incêndio", 
                                "Alerta! Alto risco de incêndio",
                                "Médio Risco de Incêndio",
                                "Baixo Risco de Incêndio",
                                "Sem Risco de Incêndio"])
    ia.treinarIa()

    while True:
        dados = {}
        try:
            dados = obterMsgSerial(PORTA_ARDUINO)
        except PermissionError:
            print("Erro de permissão - Arduino está inacessível\nTentando novamente...")
            time.sleep(1)
            continue
        except UnboundLocalError:
            print("Arduino não pôde ser acessado\nTentando novamente...")
            time.sleep(1)
            continue

        if dados["Fumaça"] >= 1023:
            fumacaBool = 1
        else:
            fumacaBool = 0

        resultado = ia.preverIncendio(float(dados["Temperatura"]), dados["Umidade"])

        if dados["Chama"] == 1 and fumacaBool == 1:
            resultado = "Alerta: Chama e fumaça detectados!"
        elif dados["Chama"] == 1:
            resultado = "Alerta: Chama detectada!"
        elif float(dados["Fumaça"]) > 1100:
            resultado = "Alerta: Fumaça detectada!"

        inserirDados(dados["Umidade"], dados["Temperatura"], dados["Chama"], fumacaBool, str(datetime.datetime.now().strftime("%d/%m/%Y %H:%M:%S")), resultado)

        # Exibe dados em uma tabela formatada
        dados_tabela = [
            ["Fumaça", dados["Fumaça"]],
            ["Umidade", dados["Umidade"]],
            ["Temperatura", dados["Temperatura"]],
            ["Chama", "Sim" if dados["Chama"] == 1 else "Não"],
            ["Data", str(datetime.datetime.now().strftime("%d/%m/%Y %H:%M:%S"))],
            ["Resultado", resultado]
        ]
        os.system("cls")
        print("\n" + tabulate(dados_tabela, headers=["Parâmetro", "Valor"], tablefmt="grid"))
        time.sleep(1)

def visualizar_ultimo_registro():
    try:
        ultimo_registro = obterUltimoRegistro()
        if ultimo_registro:
            print("Último Registro:", ultimo_registro)
        else:
            print("Nenhum registro encontrado.")
    except Exception as e:
        print("Erro ao obter o último registro:", e)

if __name__ == "__main__":
    os.system("cls")
    while True:
        print("\nMENU:")
        print("1. Iniciar IA de Prevenção de Incêndios")
        print("2. Visualizar Último Registro")
        print("3. Sair")
        opcao = input("Escolha uma opção: ")

        if opcao == '1':
            iniciar_ia()
        elif opcao == '2':
            visualizar_ultimo_registro()
        elif opcao == '3':
            print("Saindo...")
            break
        else:
            print("Opção inválida. Tente novamente.")
