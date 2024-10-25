from IA import IA_Incêndios
import numpy as np
import os
from sql import inserirDados
import datetime
from serial_Arduino import obterMsgSerial
chama = 0
fumaca = 0
temperatura = 0
umidade = 0
import time

if __name__ == "__main__":
    os.system("cls")

    ia = IA_Incêndios("Braganca Paulista", range(2020, 2022+1))
    ia.impotarDados()
    ia.tratarDados()
    #ia.analisarDados()
    ia.converterEmClassificação([0, 300, 500, 1000, 4000, np.inf], 
                                ["Segurança OK", 
                                "Baixo Risco de Incêndio", 
                                "Médio Risco de Incéndio", 
                                "Alerta! Alto risco de incêndio", 
                                "ALERTA! Altíssimo risco de incêndio"])
    ia.treinarIa()

    while True:
        dados = obterMsgSerial("COM3")
        print(dados["Temperatura"])
        resultado = ia.preverIncendio(float(dados["Temperatura"]), float(dados["Umidade"]))

        if chama == 1 and fumaca == 1: resultado = "Alerta: Chama e fumaça detectados!"
        elif chama == 1: resultado = "Alerta: Chama detectada!"
        elif float(dados["Fumaça"]) > 1100: resultado = "Alerta: Fumaça detectada!"

        inserirDados(float(dados["Umidade"]), float(dados["Temperatura"]), chama, 1, f"{datetime.datetime.now().strftime("%d/%m/%Y %H:%M:%S")}", resultado)
        time.sleep(1000)