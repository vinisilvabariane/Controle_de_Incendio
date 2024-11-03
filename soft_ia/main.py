from IA import IA_Incêndios
import numpy as np
import os
from sql import inserirDados, obterUltimoRegistro
import datetime
from serial_Arduino import obterMsgSerial
serial = "COM6"
chama = 0
fumaca = 0
temperatura = 0
umidade = 0
fumacaBool = 0
import time

if __name__ == "__main__":
    os.system("cls")

    ia = IA_Incêndios("BRAGANCA PAULISTA", range(2020, 2024+1))
    ia.impotarDados()
    ia.tratarDados()
    ia.analisarDados()
    ia.converterEmClassificação([0, 300, 500, 1000, 4000, np.inf], 
                                ["Segurança OK", 
                                "Baixo Risco de Incêndio", 
                                "Médio Risco de Incéndio", 
                                "Alerta! Alto risco de incêndio", 
                                "ALERTA! Altíssimo risco de incêndio"])
    ia.treinarIa()

    while True:
        dados = {}
        # dados["Fumaça"] = fumaca
        # dados["Umidade"] = umidade
        # dados["Temperatura"] = temperatura

        try:
            dados = obterMsgSerial(serial)
        except PermissionError:
            print("Erro de permissão - Arduíno está inacessível\nTentando novamente...")
            time.sleep(1)
            continue
        except UnboundLocalError:
            print("Arduíno não pôde ser acessado\nTentando novamente...")
            time.sleep(1)
            continue
        anterior = obterUltimoRegistro()[-1]
        resultado = ia.preverIncendio(float(dados["Temperatura"]), dados["Umidade"], anterior)

        if chama == 1 and fumaca == 1: resultado = "Alerta: Chama e fumaça detectados!"
        elif chama == 1: resultado = "Alerta: Chama detectada!"
        elif float(dados["Fumaça"]) > 1100: resultado = "Alerta: Fumaça detectada!"

        if(dados["Fumaça"] >= 1023):
            fumacaBool = 1
        else:
            fumacaBool = 0

        inserirDados(dados["Umidade"], dados["Temperatura"], dados["Chama"], fumacaBool, str(datetime.datetime.now().strftime("%d/%m/%Y %H:%M:%S")), resultado)
        time.sleep(1)