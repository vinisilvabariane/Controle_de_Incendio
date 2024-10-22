from IA import IA_Incêndios
import numpy as np
import os
from sql import inserirDados
import datetime
chama = 0
fumaca = 0

if __name__ == "__main__":
    os.system("cls")

    ia = IA_Incêndios("Braganca Paulista", range(2023, 2024 + 1))
    ia.impotarDados()
    ia.tratarDados()
    ia.analisarDados()
    ia.converterEmClassificação([0, 2.5, np.inf], ["Alerta: Alta probabilidade de incêndios!", "Segurança OK"])
    ia.treinarIa()
    resultado = ia.preverIncendio(99, 0)

    if chama == 1 and fumaca == 1: resultado = "Alerta: Chama e fumaça detectados!"
    elif chama == 1: resultado = "Alerta: Chama detectada!"
    elif fumaca == 1: resultado = "Alerta: Fumaça detectada!"

    inserirDados(99, 30, 0, 0, datetime.datetime.now(), resultado)