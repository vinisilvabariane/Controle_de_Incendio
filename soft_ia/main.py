from IA import IA_Incêndios
import numpy as np
import os
from sql import inserirDados
import datetime
chama = 0
fumaca = 0
temperatura = 30
umidade = 0

if __name__ == "__main__":
    os.system("cls")

    ia = IA_Incêndios("Braganca Paulista", range(2020, 2024+1))
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
    resultado = ia.preverIncendio(temperatura, umidade)

    if chama == 1 and fumaca == 1: resultado = "Alerta: Chama e fumaça detectados!"
    elif chama == 1: resultado = "Alerta: Chama detectada!"
    elif fumaca == 1: resultado = "Alerta: Fumaça detectada!"

    inserirDados(umidade, temperatura, chama, fumaca, f"{datetime.datetime.now().strftime("%d/%m/%Y %H:%M:%S")}", resultado)