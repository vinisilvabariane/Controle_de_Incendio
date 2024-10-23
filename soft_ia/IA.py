import pandas as pd
import numpy as np
from sklearn.exceptions import NotFittedError
from sklearn.preprocessing import MinMaxScaler, StandardScaler
from variaveis import DADOS
import requests
import locale
from scipy.stats import pearsonr
from sklearn.neighbors import KNeighborsRegressor
import matplotlib.pyplot as plt
import sys
import math
import numpy as np
import pandas as pd
from sklearn.neighbors import KNeighborsClassifier
from sklearn.neighbors import KNeighborsRegressor
from sklearn.metrics import accuracy_score, confusion_matrix
from sklearn.model_selection import train_test_split
import os
from tqdm import tqdm
from sklearn.preprocessing import MinMaxScaler, StandardScaler
from sklearn.metrics import mean_squared_error
import re
import zipfile
from threading import Thread
import time

class IA_Incêndios():

    estado:str
    anos:list[int] = []
    dados: pd.DataFrame = pd.DataFrame()
    iaTreinada: KNeighborsClassifier = KNeighborsClassifier(n_neighbors=1, weights="distance")

    def __init__(self, estado: str, anos: list[int]):
        # Indica o estado escolhido
        self.estado = estado.upper()
        self.anos = anos
        print("IA de incêndios instanciada")

    def impotarDados(self):
        """
        Importa os dados do banco de dados INMET em formato zip
        """
        # Cria a pasta dados caso nao exista
        if not os.path.exists(DADOS): os.mkdir(DADOS)

        # Inicializa o contador
        contador = 0
        while True:

            if contador == len(self.anos):
                print("Dados baixados com sucesso!!!")
                break

            # Baixa a partir do banco de dados do INMET relativo aos anos indicados
            url = f'https://portal.inmet.gov.br/uploads/dadoshistoricos/{(self.anos[contador])}.zip'  # URL do arquivo que você deseja baixar
            try:
                print("\nConectando...")
                response = requests.head(url)
            except:
                print(" Erro de conexão\nTentando Novamente...")
                time.sleep(1)
                continue

            tamanho_total = int(response.headers.get('content-length', 0))

            # Se o arquivo já estiver baixado, ele pula para economizar rede
            if os.path.exists(DADOS / f"{(self.anos[contador])}.zip") and tamanho_total == os.path.getsize(DADOS / f"{(self.anos[contador])}.zip"):
                print(f"Utilizando dados em cache referente ao ano de {self.anos[contador]}\n")
                contador += 1
                continue

            try:
                
                # Mostra uma barra de progresso ao baixar dados referente ao ano
                with requests.get(url, stream=True) as r, open(DADOS / f'{(self.anos[contador])}.zip', 'wb') as arquivo:
                    print(f"\nBaixando dados meteriológicos referente ao ano de {self.anos[contador]} - INMET")

                    # Usa tqdm para exibir uma barra de progresso
                    barra_progresso = tqdm(total=tamanho_total, unit='iB', unit_scale=True)
                    for chunk in r.iter_content(chunk_size=1024):
                        arquivo.write(chunk)
                        barra_progresso.update(len(chunk))
                    barra_progresso.close()
            # Caso houver erro de conexão ele tenta denovo
            except requests.exceptions.ChunkedEncodingError:
                print("\nOcorreu um erro no download (ChunkedEncodingError).\nTentando Novamente")
                os.remove(DADOS / f"{contador}.zip")
                continue

            if tamanho_total != 0 and barra_progresso.n != tamanho_total:
                print("Ocorreu um erro no download (Arquivo corrompido).")
                print("Tentando novamente")
            else:
                contador+=1
        
        # Extrai dos dados a cidade expecificada
        for ano in self.anos:
            # Caminho para o arquivo ZIP
            zip_file_path = DADOS / f'{ano}.zip'
            # Diretório onde você quer extrair os arquivos
            extract_to_directory = DADOS

            # Certifique-se de que o diretório de extração existe
            os.makedirs(extract_to_directory, exist_ok=True)

            # Abrir o arquivo ZIP
            with zipfile.ZipFile(zip_file_path, 'r') as zip_ref:

                # Extrair um arquivo de dados de uma determinada cidade
                try:
                    arquivo_especifico = re.search(fr'(INMET_.+?_.+?_.+?_{self.estado}_.+?.CSV)', "\n".join(zip_ref.namelist())).group()  # Substitua pelo nome do arquivo que você deseja extrair
                except AttributeError:
                    arquivo_especifico = None

                if arquivo_especifico in zip_ref.namelist():
                    zip_ref.extract(arquivo_especifico, extract_to_directory)
                    print(f"\nArquivo '{arquivo_especifico}' extraído com sucesso!")
                    # extrai os dados da cidade no ano especificado
                    dadosExtraidos = pd.read_csv(DADOS / arquivo_especifico, delimiter=";", encoding="ISO-8859-1", skiprows=8)
                    self.dados = pd.concat([self.dados, dadosExtraidos])
                else:
                    print(f"\nArquivo não encontrado no ZIP.")


            # Remove os dados extras para economizar memória
            # os.remove(DADOS / 'dados.zip')
            
            # Remove a planilha de dados da cidade
            if os.path.exists(DADOS / f"{arquivo_especifico}"): os.remove(DADOS / arquivo_especifico)
        print("Dados importados")

    def tratarDados(self):
        """
        Trata os dados para que a IA possa interpretar
        """

        # Verifica se os dados não estão vazios
        if self.dados.empty:
            print("Nenhum dado encontrado!")
            return

        # Converte os dados em seus devidos tipos
        self.dados["Data"] = pd.to_datetime(self.dados["Data"], format="%Y/%m/%d")
        self.dados['Data'] = self.dados['Data'].astype('int64') / 10**9
        self.dados["TEMPERATURA DO AR - BULBO SECO, HORARIA (°C)"] = self.dados["TEMPERATURA DO AR - BULBO SECO, HORARIA (°C)"].str.replace(',', '.').astype(float)
        self.dados["UMIDADE RELATIVA DO AR, HORARIA (%)"] = self.dados["UMIDADE RELATIVA DO AR, HORARIA (%)"].replace(',', '.').astype(float)
        self.dados["TEMPERATURA DO PONTO DE ORVALHO (°C)"] = self.dados["TEMPERATURA DO PONTO DE ORVALHO (°C)"].str.replace(',', '.').astype(float)
        self.dados["PRESSAO ATMOSFERICA AO NIVEL DA ESTACAO, HORARIA (mB)"] = self.dados["PRESSAO ATMOSFERICA AO NIVEL DA ESTACAO, HORARIA (mB)"].str.replace(',', '.').astype(float)
        self.dados["PRECIPITAÇÃO TOTAL, HORÁRIO (mm)"] = self.dados["PRECIPITAÇÃO TOTAL, HORÁRIO (mm)"].str.replace(',', '.').astype(float)
        
        # Filtra dados por hora as 13 da tarde
        self.dados["Hora UTC"] = self.dados["Hora UTC"].str.replace(' UTC', '').astype(int)
        self.dados = self.dados[self.dados["Hora UTC"] == 1300]
        self.dados = self.dados.drop(columns=["Hora UTC"])

        # Elimina colunas desnecessárias
        self.dados = self.dados[[# "Data",
                                 # "Hora UTC",
                                 # "PRECIPITAÇÃO TOTAL, HORÁRIO (mm)",
                                 "TEMPERATURA DO AR - BULBO SECO, HORARIA (°C)",
                                 # "TEMPERATURA DO PONTO DE ORVALHO (°C)",
                                 "UMIDADE RELATIVA DO AR, HORARIA (%)",
                                 # "PRESSAO ATMOSFERICA AO NIVEL DA ESTACAO, HORARIA (mB)"
                                 ]]
        # Adiciona a coluna de probabilidade de incêndio
        self.dados["Probabilidade Incêndio"] = 0.050*self.dados["UMIDADE RELATIVA DO AR, HORARIA (%)"] - 0.10*(self.dados["TEMPERATURA DO AR - BULBO SECO, HORARIA (°C)"]-27)

        # Retira linhas com células vazias
        self.dados = self.dados.dropna()

        # Embaralhar dados
        self.dados = self.dados.sample(frac=1, random_state=81681)

    def analisarDados(self):
        if self.dados.empty:
            print("Nenhum dado encontrado!")
            return

        # Verifica tipagem e quantidade de dados
        print("\nInformações")
        print(self.dados.info())
        print("\nInformações estatísticas")
        print(self.dados.describe())

        print("\nCoeficiente de person")
        # Geração do coeficiente de pearson
        for col in self.dados.columns[:]:
            print('%10s = %6.3f , p-value = %.9f' % (
                col,
                pearsonr(self.dados[col], self.dados.iloc[:, -1])[0],
                pearsonr(self.dados[col], self.dados.iloc[:, -1])[1]
            ))
        print()

        # Criar gráficos de correlação self.dados
        pd.plotting.scatter_matrix(
            self.dados,
            # c=cores_amostras,
            figsize=(20,20),
            marker='o',
            s=50,
            alpha=0.50,
            diagonal='kde',         # 'hist' ou 'kde'
            hist_kwds={'bins':3},
            )
        plt.suptitle(
            'MATRIZ DE DISPERSÃO DOS ATRIBUTOS',
            y=0.9,
            fontsize='xx-large'
            )
        
        plt.show()

    def converterEmClassificação(self, bins, labels):

        if self.dados.empty:
            print("Nenhum dado encontrado!")
            return

        """
        Converte a variável alvo em argumentos para a ia de classificação 
        (evita problemas com o coeficiente de person)
        """
        # Classifica a coluna de probabilidade de incêndio
        self.dados["Probabilidade Incêndio"] = pd.cut(self.dados["Probabilidade Incêndio"], bins=bins, labels=labels, include_lowest=True)

    def treinarIa(self):
        """
        treina a ia para que possa prever os incêndios
        """

        # Separação de dados entre treino e teste

        if self.dados.empty:
            print("Nenhum dado encontrado!")
            return

        maiorAcuracia = 0
        maiorK = 0

        x_treino, x_teste, y_treino, y_teste = train_test_split(
            self.dados.iloc[:, :-1],
            self.dados.iloc[:, -1],
            test_size=0.25)

        for K in range(1, 10+1):
            # Deixa os dados Uniformes
            scaler = StandardScaler()
            scaler.fit(x_treino)
            x_treino = scaler.transform(x_treino)
            x_teste = scaler.transform(x_teste)

            # Instancia a ia: uniform, distance
            classificador = KNeighborsClassifier(n_neighbors=K, 
                                                weights="uniform")
            classificador = classificador.fit(x_treino, y_treino)

            # Usa a ia criada no conjunto de treino e teste para ver a acurácia
            y_resposta_treino = classificador.predict(x_treino)
            y_resposta_teste = classificador.predict(x_teste)

            # acuracia = math.sqrt(mean_squared_error(
            #    y_treino, y_resposta_treino))
            acuracia = sum(y_resposta_treino == y_treino) / len(y_treino)
            # print(f"Acuracia Treino K = {K}: {(100*acuracia):4.1f} %")

            # acuracia = math.sqrt(mean_squared_error(y_teste, y_resposta_teste))
            acuracia = sum(y_resposta_teste == y_teste) / len(y_teste)
            # print(f"Acuracia Teste K = {K}: {(100*acuracia):4.1f} %")

            if maiorAcuracia < acuracia:
                self.iaTreinada = classificador
                maiorAcuracia = acuracia
                maiorK = K
        print(f"Ia treinada\nAcuracia Teste K = {maiorK}: {(100*maiorAcuracia):4.1f} %")

    def preverIncendio(self, temperatura, umidade) -> str:
        """
        Gera um resultado referente a probabilidade de incêndio (Alta probabilidade, baixa probabilidade)
        """
        try:
            return self.iaTreinada.predict([[temperatura, umidade]])[0]
        except NotFittedError as error:
            print("IA não treinada")


    # Permite que a função seja usada sem a classe estar instanciada
    @classmethod
    def obterLocalizacaoPorIp(self) -> dict[str, str]:

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
