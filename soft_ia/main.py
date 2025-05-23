from IA_Incendios import IA_Incêndios
import numpy as np
from Utils import PORTA_ARDUINO
import os
from Connection import inserirDados, obterUltimoRegistro
from datetime import datetime
from Serial_Arduino import obterMsgSerial
from tabulate import tabulate
import time
import sys

class SistemaPrevencaoIncendio:
    def __init__(self):
        self.ia = None
        self.dados_atuais = {
            'temperatura': 0,
            'umidade': 0,
            'bomba': 0  # Estado da bomba (0 = desligada, 1 = ligada)
        }
        self.inicializar_ia()

    def inicializar_ia(self):
        """Inicializa a IA de prevenção de incêndios"""
        try:
            self.ia = IA_Incêndios("Braganca Paulista", range(2020, 2021))
            self.ia.impotarDados()
            self.ia.tratarDados()
            self.ia.analisarDados()
            self.ia.converterEmClassificação(
                [0, 1, 1.5, 2, 2.5, np.inf], 
                [
                    "ALERTA! Altíssimo risco de incêndio", 
                    "Alerta! Alto risco de incêndio",
                    "Médio Risco de Incêndio",
                    "Baixo Risco de Incêndio",
                    "Sem Risco de Incêndio"
                ]
            )
            self.ia.treinarIa()
        except Exception as e:
            print(f"Erro ao inicializar IA: {e}")
            sys.exit(1)

    def processar_dados_arduino(self):
        """Obtém e processa os dados do Arduino"""
        try:
            dados = obterMsgSerial(PORTA_ARDUINO)
            if not dados:
                raise ValueError("Dados vazios recebidos do Arduino")
            
            # Atualiza os dados atuais
            self.dados_atuais = {
                'temperatura': dados.get("Temperatura", 0),
                'umidade': dados.get("Umidade", 0),
                'bomba': dados.get("Bomba", 0)
            }
            
            return True
        except Exception as e:
            print(f"Erro ao processar dados do Arduino: {e}")
            return False

    def determinar_resultado(self):
        """Determina o resultado com base nos dados e na IA"""
        try:
            # Previsão baseada na IA
            resultado = self.ia.preverIncendio(
                float(self.dados_atuais['temperatura']), 
                float(self.dados_atuais['umidade'])
            )

            # Verificação de alertas imediatos (bomba ligada indica detecção de chama)
            if self.dados_atuais['bomba'] == 1:
                return "ALERTA: Incêndio detectado! Bomba acionada"
            
            return resultado
        except Exception as e:
            print(f"Erro ao determinar resultado: {e}")
            return "Erro na análise"

    def exibir_dados(self, resultado):
        dados_tabela = [
            ["Umidade", f"{self.dados_atuais['umidade']}%"],
            ["Temperatura", f"{self.dados_atuais['temperatura']}°C"],
            ["Bomba", "LIGADA" if self.dados_atuais['bomba'] == 1 else "DESLIGADA"],
            ["Data", datetime.now().strftime("%d/%m/%Y %H:%M:%S")],
            ["Resultado", resultado]
        ]
        
        os.system("cls" if os.name == 'nt' else "clear")
        print("\n" + tabulate(dados_tabela, headers=["Parâmetro", "Valor"], tablefmt="grid"))

    def executar_ciclo(self):
        """Executa um ciclo completo de leitura, processamento e exibição"""
        if not self.processar_dados_arduino():
            time.sleep(1)
            return

        resultado = self.determinar_resultado()
        
        # Inserir no banco de dados
        try:
            inserirDados(
                self.dados_atuais['temperatura'],
                self.dados_atuais['umidade'],
                self.dados_atuais['bomba'],
                datetime.now().strftime("%d/%m/%Y %H:%M:%S"),
                resultado
            )
        except Exception as e:
            print(f"Erro ao inserir dados no banco: {e}")

        self.exibir_dados(resultado)
        time.sleep(1)

def visualizar_ultimo_registro():
    """Exibe o último registro do banco de dados"""
    try:
        ultimo_registro = obterUltimoRegistro()
        if ultimo_registro:
            print("\nÚltimo Registro:")
            print("-" * 40)
            print(f"Temperatura: {ultimo_registro[2]}°C")
            print(f"Umidade: {ultimo_registro[3]}%")
            print(f"Bomba: {'LIGADA' if ultimo_registro[4] == 1 else 'DESLIGADA'}")
            print(f"Data: {ultimo_registro[5]}")
            print(f"Resultado: {ultimo_registro[6]}")
            print("-" * 40)
        else:
            print("Nenhum registro encontrado.")
    except Exception as e:
        print(f"Erro ao obter o último registro: {e}")
    input("\nPressione Enter para continuar...")

def mostrar_menu():
    """Exibe o menu principal"""
    os.system("cls" if os.name == 'nt' else "clear")
    print("---------------------------------------")
    print("SISTEMA DE PREVENÇÃO DE INCÊNDIOS")
    print("---------------------------------------")
    print("1. Iniciar Monitoramento Contínuo")
    print("2. Visualizar Último Registro")
    print("3. Sair")
    return input("Escolha uma opção: ")

def main():
    sistema = SistemaPrevencaoIncendio()
    
    while True:
        opcao = mostrar_menu()

        if opcao == '1':
            try:
                while True:
                    sistema.executar_ciclo()
            except KeyboardInterrupt:
                print("\nMonitoramento interrompido pelo usuário")
        elif opcao == '2':
            visualizar_ultimo_registro()
        elif opcao == '3':
            print("Saindo do sistema...")
            break
        else:
            print("Opção inválida. Tente novamente.")
            time.sleep(1)

if __name__ == "__main__":
    main()