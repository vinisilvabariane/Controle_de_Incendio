# Sistema de Controle de Incêndio com Arduino, IA e Sensores

Este projeto é um sistema de controle de incêndio que utiliza sensores conectados a um Arduino para coletar dados ambientais como temperatura, umidade, fumaça e presença de fogo. Esses dados são processados por uma Inteligência Artificial (IA) que, após ser treinada, calcula a probabilidade de um incêndio. Os resultados são exibidos em um site desenvolvido com HTML, JavaScript, CSS e PHP.

## Funcionalidades

- **Coleta de Dados**: Sensores de temperatura, umidade, fumaça e chama são utilizados para monitorar o ambiente em tempo real.
- **Processamento com IA**: Os dados coletados são enviados para uma IA que, após o treinamento, analisa as informações e estima a probabilidade de incêndio.
- **Exibição dos Resultados**: Um dashboard web exibe as conclusões da IA em um formato claro e acessível para o usuário. O site é construído com HTML, CSS e JavaScript, com suporte backend em PHP.

## Tecnologias Utilizadas

- **Hardware**:
  - Arduino
  - Sensores de Temperatura (DHT11 ou DHT22)
  - Sensor de Umidade (integrado com DHT)
  - Sensor de Fumaça (MQ-2 ou equivalente)
  - Sensor de Chama (sensor de chama infravermelho)
  
- **Software**:
  - Linguagem de programação Arduino para controle dos sensores e coleta dos dados.
  - **Inteligência Artificial**: Algoritmos de Machine Learning em Python para análise dos dados e previsão da probabilidade de incêndio.
  - **Frontend**: HTML, CSS e JavaScript para visualização dos dados.
  - **Backend**: PHP para lidar com requisições e integração com a IA e banco de dados.
  
- **Banco de Dados**:
  - Armazena dados históricos de temperatura, umidade, fumaça e detecção de fogo, além das conclusões geradas pela IA.
