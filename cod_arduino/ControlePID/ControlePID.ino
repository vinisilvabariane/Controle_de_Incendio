#include <DHT.h>
#include <PID_v1.h>

// Definindo as portas dos sensores
#define pinSensorChama 2   // Sensor de chama na porta 2 (digital)
#define pinSensorFumaca A0 // Sensor de fumaça na porta A0 (analógico)
#define pinBombaDeAgua 3   // Bomba de água controlada pela porta PWM
#define pinDHT A1          // Sensor DHT na porta A1

// Definindo o tipo do sensor DHT
#define DHTTYPE DHT22      // DHT11 ou DHT22, dependendo do seu modelo
DHT dht(pinDHT, DHTTYPE);

// Variáveis para controle PID
double Setpoint, Input, Output;

// Definindo os parâmetros do PID: Kp, Ki, Kd
double Kp = 30, Ki = 20, Kd = 0;
PID myPID(&Input, &Output, &Setpoint, Kp, Ki, Kd, REVERSE);

// Configuração da média móvel para três variáveis independentes
const int numLeituras = 3; // Define o número de leituras para o cálculo da média móvel

// Variáveis para a média móvel do sensor de fumaça
float leiturasFumaca[numLeituras] = {0};
int indiceLeituraFumaca = 0;
float somaFumaca = 0;

// Variáveis para a média móvel de umidade
float leiturasUmidade[numLeituras] = {0};
int indiceLeituraUmidade = 0;
float somaUmidade = 0;

// Variáveis para a média móvel de temperatura
float leiturasTemperatura[numLeituras] = {0};
int indiceLeituraTemperatura = 0;
float somaTemperatura = 0;

// Variáveis para leitura dos sensores
int statusChama;
float nivelFumaca;
float umidade;
float temperatura;

void setup() {
  Serial.begin(9600);

  // Inicializa os sensores
  dht.begin();
  pinMode(pinSensorChama, INPUT);
  pinMode(pinBombaDeAgua, OUTPUT);
  pinMode(pinSensorFumaca, INPUT);

  lerSensores();
  lerSensores();
  lerSensores();

  // Definindo o setpoint de controle
  Setpoint = 25;  // Umidade ideal de 30% (ajustável conforme necessidade)

  // Inicializa o PID
  myPID.SetMode(AUTOMATIC);
}

void loop() {
  lerSensores();
  exibirDadosSerial();
  controlePID();
  delay(50);
}

// Função de média móvel para o sensor de fumaça
float calculaMediaMovelFumaca(float novaLeitura) {
  somaFumaca -= leiturasFumaca[indiceLeituraFumaca];
  leiturasFumaca[indiceLeituraFumaca] = novaLeitura;
  somaFumaca += novaLeitura;
  indiceLeituraFumaca = (indiceLeituraFumaca + 1) % numLeituras;
  return somaFumaca / numLeituras;
}

// Função de média móvel para a umidade
float calculaMediaMovelUmidade(float novaLeitura) {
  somaUmidade -= leiturasUmidade[indiceLeituraUmidade];
  leiturasUmidade[indiceLeituraUmidade] = novaLeitura;
  somaUmidade += novaLeitura;
  indiceLeituraUmidade = (indiceLeituraUmidade + 1) % numLeituras;
  return somaUmidade / numLeituras;
}

// Função de média móvel para a temperatura
float calculaMediaMovelTemperatura(float novaLeitura) {
  somaTemperatura -= leiturasTemperatura[indiceLeituraTemperatura];
  leiturasTemperatura[indiceLeituraTemperatura] = novaLeitura;
  somaTemperatura += novaLeitura;
  indiceLeituraTemperatura = (indiceLeituraTemperatura + 1) % numLeituras;
  return somaTemperatura / numLeituras;
}

void lerSensores() {
  // Leitura dos sensores
  statusChama = !digitalRead(pinSensorChama);  // 0 ou 1 (chama detectada ou não)
  nivelFumaca = calculaMediaMovelFumaca((float)analogRead(pinSensorFumaca)); // Média móvel da fumaça
  
  // Leitura da umidade e temperatura com média móvel
  umidade = dht.readHumidity();
  temperatura = dht.readTemperature();

  // Verifica se houve erro na leitura do DHT
  if (isnan(umidade)) {
    umidade = 0;
    
  }
  if(isnan(temperatura)){
    temperatura = 0;
  }
  umidade = calculaMediaMovelUmidade(umidade);
  temperatura = calculaMediaMovelTemperatura(temperatura);
}

void controlePID() {
  // Entrada para o PID é a temperatura atual
  Input = temperatura;
  Setpoint = 30;

  // Caso haja chama detectada, acionar bomba no máximo
  if (statusChama == 1) {
    Setpoint = temperatura - 1;
    myPID.Compute();
    Output = constrain(map(Output, 0, 255, 0, 101)+154, 154, 255);      // Garante que o valor esteja entre 0 e 255
    analogWrite(pinBombaDeAgua, Output);

  }else{
    // Caso não haja chama, controlar bomba com PID
    myPID.Compute();
    Output = constrain(Output, 0, 255);      // Garante que o valor esteja entre 0 e 255
    if(Output < 154) Output = 0;
    analogWrite(pinBombaDeAgua, Output);     // Saída do PID ajusta o PWM da bomba
  }

}

void exibirDadosSerial() {
  // Exibe as leituras dos sensores
  Serial.print("Fumaca:");
  Serial.print(nivelFumaca);
  Serial.print(",");
  Serial.print("Umidade:");
  Serial.print(umidade);
  Serial.print(",");
  Serial.print("Temperatura:");
  Serial.print(temperatura);
  Serial.print(",");
  Serial.print("Chama:");
  Serial.print(statusChama);
  Serial.print(",");
  Serial.print("Entrada:");
  Serial.print(Input);
  Serial.print(",");
  Serial.print("Setpoint:");
  Serial.print(Setpoint);
  Serial.print(",");
  Serial.print("Saida:");
  Serial.println(Output);
}
