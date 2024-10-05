import pandas as pd
import numpy as np
from sklearn.preprocessing import MinMaxScaler, StandardScaler
from variaveis import CLIMA_CSV, ESTACOES_CSV, QUEIMADAS_CSV
import requests
import locale

# Configurar o locale para português (Brasil)
locale.setlocale(locale.LC_TIME, 'pt_BR.UTF-8')

def obterLocalizacaoPorIp() -> dict[str, str]:

    """
    retorna um dicionário com as seguintes informações por IP:
    ret["cidade"] = cidade
    ret["estado"] = regiao
    ret["pais"] = pais
    ret["lat"] = localizacao[0]
    ret["long"] = localizacao[1]
    """

    ret = {}
    # Obtém os dados de localização com base no IP público
    response = requests.get('https://ipinfo.io/')
    data = response.json()

    # Extrai informações da localização
    cidade = data['city']
    regiao = data['region']
    pais = data['country']
    localizacao = data['loc'].split(',')

    ret["cidade"] = cidade
    ret["estado"] = regiao
    ret["pais"] = pais
    ret["lat"] = localizacao[0]
    ret["long"] = localizacao[1]

    print(f"Cidade: {cidade}")
    print(f"Região: {regiao}")
    print(f"Latitude: {ret["lat"]}, Longitude: {ret["long"]}")

    return ret


def importarDados(estado: str) -> pd.DataFrame:

    """
        Obtém dados formatados das planilhas utilizadas no projeto:
        - clima.csv
        - estacoes.csv
        - queimadas.csv
    """

    # Para evitar erro de downcast do pandas no comando replace
    pd.set_option('future.no_silent_downcasting', True)

    # Extraindo dados
    estacoes = pd.read_csv(ESTACOES_CSV, sep=",")
    clima = pd.read_csv(CLIMA_CSV)
    queimadas = pd.read_csv(QUEIMADAS_CSV, encoding='ISO-8859-1')

    # Renomeando coluna de incêndios
    queimadas = queimadas.rename(columns={'number': 'number_of_fires'})

    # Exclui colunas desnecessárias para reduzir processamento
    clima = clima.drop(columns=[

                                'rain_max', 
                                'rad_max', 
                                'wind_max', 
                                'wind_avg'
                                ])

    estacoes = estacoes.drop(columns=[ 
                                'region',
                                'city_station',
                                'record_first',
                                'record_last'])

    # Unindo dados da tabela "estações" e da tabela "clima"
    dados_completos = pd.merge(clima, estacoes, left_on='ESTACAO', right_on='id_station', how='left')

    # Converte a coluna DATA (YYYY-MM-DD) em datetime
    dados_completos['DATA (YYYY-MM-DD)'] = pd.to_datetime(dados_completos['DATA (YYYY-MM-DD)'], format='%Y-%m-%d')

    # Separa a coluna 'DATA (YYYY-MM-DD)' em duas colunas: mês e ano
    dados_completos["month"] = dados_completos['DATA (YYYY-MM-DD)'].dt.month
    dados_completos["year"] = dados_completos['DATA (YYYY-MM-DD)'].dt.year

    estado_completo = {
        'Acre': 1,
        'Alagoas': 2,
        'Amapá': 3,
        'Amazonas': 4,
        'Bahia': 5,
        'Ceará': 6,
        'Distrito Federal': 7,
        'Espírito Santo': 8,
        'Goiás': 9,
        'Maranhão': 10,
        'Mato Grosso': 11,
        'Mato Grosso do Sul': 12,
        'Minas Gerais': 13,
        'Pará': 14,
        'Paraíba': 15,
        'Paraná': 16,
        'Pernambuco': 17,
        'Piauí': 18,
        'Rio de Janeiro': 19,
        'Rio Grande do Norte': 20,
        'Rio Grande do Sul': 21,
        'Rondônia': 22,
        'Roraima': 23,
        'Santa Catarina': 24,
        'São Paulo': 25,
        'Sergipe': 26,
        'Tocantins': 27
    }

    achou = 0
    for i in estado_completo.keys():
        if estado == i:
            estado = estado_completo[i]
            achou = 1
    if not achou:
        print("Estado não encontrado")
        exit()

    # Substitui as abreviações por números para interpretação da IA
    queimadas['state'] = queimadas['state'].replace(estado_completo)

    # Transforma estados abreviados em nomes completos, ex: MG->Minas Gerais
    estado_completo = {
        'AC': 1,
        'AL': 2,
        'AP': 3,
        'AM': 4,
        'BA': 5,
        'CE': 6,
        'DF': 7,
        'ES': 8,
        'GO': 9,
        'MA': 10,
        'MT': 11,
        'MS': 12,
        'MG': 13,
        'PA': 14,
        'PB': 15,
        'PR': 16,
        'PE': 17,
        'PI': 18,
        'RJ': 19,
        'RN': 20,
        'RS': 21,
        'RO': 22,
        'RR': 23,
        'SC': 24,
        'SP': 25,
        'SE': 26,
        'TO': 27
    }

    # Substitui as abreviações por números para interpretação da IA
    dados_completos['state'] = dados_completos['state'].replace(estado_completo)

    # Une as duas tabelas por mês e ano
    dados_completos = pd.merge(dados_completos, queimadas, on=["month", "year", "state"], how="left")

    # Filtragem final de dados
    dados_completos = dados_completos.drop(columns=["id_station", 
                                                     "ESTACAO",
                                                     "DATA (YYYY-MM-DD)",
                                                     "date",
                                                     "year",
    #                                                 "hum_min",
    #                                                 "hum_max",
    #                                                 "temp_max",
    #                                                 "temp_min",
    #                                                 "state",
    #                                                 "lat",
    #                                                 "lon", 
    #                                                 "lvl"
    ])

    # Converte colunas em float ou int para a IA entender
    dados_completos['lat'] = dados_completos['lat'].str.replace(',', '.').astype(float)
    dados_completos['lon'] = dados_completos['lon'].str.replace(',', '.').astype(float)
    dados_completos['lvl'] = dados_completos['lvl'].str.replace(',', '.').astype(float)
    # dados_completos['state'] = dados_completos['state'].astype(int)
    
    # Embaralha os dados
    dados_completos = dados_completos.sample(frac=1, random_state=32443).reset_index(drop=True)

    # Filtra incêndio por estado e remove a coluna estado
    dados_completos = dados_completos[dados_completos["state"] == estado]
    dados_completos = dados_completos.drop(columns=['state'])

    #limpa linhas com Nan
    dados_completos = dados_completos.dropna()

    return dados_completos
