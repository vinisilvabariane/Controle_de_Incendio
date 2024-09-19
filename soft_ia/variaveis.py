from pathlib import Path

RAIZ = Path(__file__).parent.resolve()
DADOS = RAIZ / "DADOS"
ESTACOES_CSV = DADOS / "estacoes.csv"
QUEIMADAS_CSV = DADOS / "queimadas.csv"
CLIMA_CSV = DADOS / "clima.csv"