from IA import IA_Incêndios
import numpy as np
import os
import datetime as dt

if __name__ == "__main__":
    os.system("cls")

    ia = IA_Incêndios("Braganca Paulista", range(2019, 2025))
    ia.impotarDados()
    ia.tratarDados()
    ia.analisarDados()
    ia.converterEmClassificação([0, 2.5, np.inf], ["Baixa Probabilidade", "Alta probabilidade"])
    ia.treinarIa()
    print(ia.preverIncendio(30, 99))