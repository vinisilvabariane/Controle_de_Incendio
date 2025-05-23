from pathlib import Path

RAIZ = Path(__file__).parent.resolve()
DADOS = RAIZ.parent / "/datasets"
HOST_DATABASE = "localhost"
USER_DATABASE = "root"
PASSWORD_DATABASE = "1234"
DATABASE = "projeto_incendio"
PORTA_ARDUINO = "COM5"