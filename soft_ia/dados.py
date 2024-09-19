import pandas as pd
import numpy as np
from variaveis import CLIMA_CSV, ESTACOES_CSV, QUEIMADAS_CSV
import requests
from IPython.display import display
import locale

# Configurar o locale para português (Brasil)
locale.setlocale(locale.LC_TIME, 'pt_BR.UTF-8')

def obterLocalizacao() -> list[str]:
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


obterLocalizacao()

# Extraindo dados
estacoes = pd.read_csv(ESTACOES_CSV, sep=",")
clima = pd.read_csv(CLIMA_CSV)
queimadas = pd.read_csv(QUEIMADAS_CSV, encoding='ISO-8859-1')

# estacoes = estacoes.rename(columns={'id_station': 'ESTACAO'})

# Unindo dados
dados_completos = pd.merge(clima, estacoes, left_on='ESTACAO', right_on='id_station', how='inner')
queimadas['state'] = queimadas['state'].str.upper()
dados_completos = pd.merge(dados_completos, queimadas, left_on="city_station", right_on="state")
# dados_completos = pd.merge(clima, estacoes, on='ESTACAO', how='inner')

# Exclui colunas desnecessárias
dados_completos = dados_completos.drop(columns=['ESTACAO', 
                                                'state_x', 
                                                'id_station', 
                                                'region', 
                                                'year',  
                                                'rain_max', 
                                                'rad_max', 
                                                'wind_max', 
                                                'wind_avg'])

# Transforma colunas em data:
dados_completos['DATA (YYYY-MM-DD)'] = pd.to_datetime(dados_completos['DATA (YYYY-MM-DD)'], format='%Y-%m-%d')
dados_completos['date'] = pd.to_datetime(dados_completos['date'], format='%Y-%m-%d')
dados_completos['record_first'] = pd.to_datetime(dados_completos['record_first'], format='%Y-%m-%d')
dados_completos['record_last'] = pd.to_datetime(dados_completos['record_last'], format='%Y-%m-%d')


# Formatando datas
dados_completos["date"] = dados_completos['month'] + ' ' + pd.to_datetime(dados_completos["date"], format='%Y-%m-%d').dt.year.astype(str)
dados_completos['date'] = pd.to_datetime(dados_completos['date'], format='mixed')


# Informações
display(dados_completos.info())
# print(dados_completos.describe())

amostra_100_linhas = dados_completos.sample(n=100, random_state=1)  # random_state para reprodutibilidade

# Salvar a amostra em um arquivo CSV
amostra_100_linhas.to_csv("dados_filtrados.csv", index=False)