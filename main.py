from sklearn.naive_bayes import GaussianNB, BernoulliNB
# import tensorflow as tf
from sklearn.ensemble import RandomForestClassifier
from sklearn.tree import DecisionTreeClassifier
from sklearn.svm import SVC
from sklearn.svm import LinearSVC
from sklearn.naive_bayes import MultinomialNB
from sklearn.linear_model import LogisticRegression
import matplotlib.pyplot as plt
import sys
import numpy as np
import pandas as pd
from sklearn.neighbors import KNeighborsClassifier
from sklearn.neighbors import KNeighborsRegressor
from sklearn.metrics import accuracy_score, confusion_matrix
from scipy.stats import pearsonr
from sklearn.model_selection import train_test_split
import os

if os.path.exists("saida.csv"):  os.remove("saida.csv")

# Extração Dados
dados = pd.read_excel("treinamento.xlsx")

#Embaralhar dados
dados_embaralhados = dados.sample(frac=1, random_state=54319)

# Separação de dados entre treino e teste
x_treino, x_teste, y_treino, y_teste = train_test_split(
    dados_embaralhados.iloc[:,:-1],
    dados_embaralhados.iloc[:,-1],
    test_size=0.30)

#Geração do coeficiente de pearson
for col in dados.columns[:]:
    print('%10s = %6.3f , p-value = %.9f' % (
        col,
        pearsonr(dados[col], dados['Coeficiente'])[0],
        pearsonr(dados[col], dados['Coeficiente'])[1]
    )
  )
print()

cores_amostras = []
for a in dados['Coeficiente']:
    if a > 2:
       cores_amostras.append("red")
    else:
       cores_amostras.append("green")

# Criar gráficos de correlação dados
# pd.plotting.scatter_matrix(
#     dados,
#     c=cores_amostras,
#     figsize=(20,20),
#     marker='o',
#     s=50,
#     alpha=0.50,
#     diagonal='hist',         # 'hist' ou 'kde'
#     hist_kwds={'bins':2}
#     )
# plt.suptitle(
#     'MATRIZ DE DISPERSÃO DOS ATRIBUTOS',
#     y=0.9,
#     fontsize='xx-large'
#     )
# plt.show()

# uniform, distance
maior = 0
for K in range(1, 10+1):
  classificador = KNeighborsRegressor(n_neighbors=K, weights="distance")

  classificador = classificador.fit(x_treino, y_treino)

  y_resposta_treino = classificador.predict(x_treino)
  y_resposta_teste = classificador.predict(x_teste)


  acuracia = sum(np.isclose(y_resposta_treino, y_treino)) / len(y_treino)
  print(f"Acuracia Treino K = {K}: {(100*acuracia):4.1f}%")

  acuracia = sum(np.isclose(y_resposta_teste, y_teste, rtol=0.01, atol=0.01)) / len(y_teste)
  print(f"Acuracia Teste K = {K}: {(100*acuracia):4.1f}%")

  if maior < acuracia:
    maior = acuracia
    K_maior = K

print(f"\nMelhor acuracia: {(maior*100):.2f}%")
print("Melhor K: "+ str(K_maior))

classificador = KNeighborsRegressor(n_neighbors=K_maior, weights="distance")
classificador = classificador.fit(x_treino, y_treino)
y_resposta_teste = classificador.predict(x_teste)

df_concat = pd.concat([x_teste, y_teste], axis=1)
df_concat.to_csv("saida.csv",index=False)