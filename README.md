# Controle de Incêndio

## Descrição

O **Controle de Incêndio** é um sistema inteligente de monitoramento e prevenção de incêndios, desenvolvido para detectar possíveis riscos e alertar os usuários em tempo real.  

Utilizando sensores conectados a um **Arduino** e uma **Inteligência Artificial** treinada com um dataset específico para controle de incêndios, o sistema analisa variáveis como **temperatura, presença de gás inflamável e detecção de chama** para prever e prevenir incêndios.  

### Funcionalidades

- 📡 **Monitoramento em Tempo Real:** Coleta contínua de dados dos sensores (**DHT22, MQ-2 e sensor de chama**).  
- 🎛️ **Controle PID:** Processamento e estabilização das variáveis coletadas.  
- 🤖 **Análise Inteligente:** Uso de um modelo de IA treinado para identificar condições de risco.  
- 🚨 **Alertas Automáticos:** Envio de notificações para um aplicativo web quando um risco de incêndio é detectado.  
- 📊 **Histórico de Dados:** Armazenamento e exibição das medições para análise posterior.  

---

## Tecnologias Utilizadas

### 🔧 **Hardware**
- **Arduino** (Microcontrolador principal)  
- **DHT22** (Sensor de temperatura e umidade)  
- **MQ-2** (Sensor de gás inflamável)  
- **Sensor de Chama**  

### 💻 **Software**
- **Firmware:** C++ (para programação do Arduino)  
- **Inteligência Artificial:** Python (Treinamento e inferência do modelo de IA)  
- **Web App:** HTML5, CSS3, JavaScript  
- **Backend:** Node.js ou PHP (para lógica de controle e API)  
- **Banco de Dados:** MySQL ou Firebase (para armazenamento do histórico de dados)  

---

## 🚀 Como Rodar o Projeto

### 🔹 **Requisitos**
- **Arduino IDE** (para programar o microcontrolador)  
- **Python** (para treinar e executar a IA)  
- **Servidor Web** (Apache, Nginx ou similar para a aplicação web)  
- **Banco de Dados** (MySQL ou Firebase)  

### 📌 **Passos para Execução**

1️⃣ **Configurar o Arduino:**  
   - Carregar o código no Arduino via Arduino IDE.  
   - Conectar os sensores corretamente.  
   - Testar a comunicação com o PC.  

2️⃣ **Treinar a IA:**  
   - Rodar o script de treinamento do modelo de IA.  
   - Ajustar parâmetros conforme necessário.  

3️⃣ **Configurar o Servidor Web:**  
   - Instalar as dependências do backend.  
   - Configurar o banco de dados.  
   - Iniciar o servidor.  

4️⃣ **Testar o Sistema:**  
   - Simular diferentes condições ambientais.  
   - Verificar se os alertas estão sendo enviados corretamente.

---

## 🚀 Imagem do Circuito:
![Circuito](https://github.com/user-attachments/assets/8cf39996-a7fc-4c32-a8b6-8d29c16eb0d5)


