#include <DHT.h>
#include <PID_v1.h>

// Definindo as portas dos sensores
#define pinSensorChama 2   // Sensor de chama na porta 2 (digital)
#define pinSensorFumaca A0  // Sensor de fumaça na porta A0 (analógico)
#define pinBombaDeAgua 3           // Bomba de água controlada pela porta PWM
#define pinDHT 4             // Sensor DHT na porta 3

// Definindo o tipo do sensor DHT
#define DHTTYPE DHT22  // DHT 11 ou DHT22, dependendo do seu modelo
DHT dht(pinDHT, DHTTYPE);

// Variáveis para controle PID
double Setpoint, Input, Output;

// Definindo os parâmetros do PID: Kp, Ki, Kd
double Kp = 30, Ki = 10, Kd = 0;
PID myPID(&Input, &Output, &Setpoint, Kp, Ki, Kd, DIRECT);

// Variáveis para leitura dos sensores
int statusChama;
int nivelFumaca;
float umidade;
float temperatura;

void setup() {
  Serial.begin(9600);

  // Inicializa os sensores
  dht.begin();
  pinMode(pinSensorChama, INPUT);
  pinMode(pinBombaDeAgua, OUTPUT);
  pinMode(pinSensorFumaca, INPUT);

  // Definindo o setpoint de controle
  Setpoint = 30;  // Umidade ideal de 30% (ajustável conforme necessidade)

  // Inicializa o PID
  myPID.SetMode(AUTOMATIC);
}

void loop() {

  lerSensores();
  exibirDadosSerial();
  controlePID();
  delay(200);
}

void lerSensores(){
  // Leitura dos sensores
  statusChama = digitalRead(pinSensorChama);  // 0 ou 1 (chama detectada ou não)
  nivelFumaca = analogRead(pinSensorFumaca);    // Leitura analógica de concentração de fumaça (0 a 1023)
  umidade = dht.readHumidity();                // Leitura de umidade do sensor DHT
  temperatura = dht.readTemperature();          // Leitura de temperatura do sensor DHT

   // Verifica se houve erro na leitura do DHT
  if (isnan(umidade) || isnan(temperatura)) {
    exit(1); // Se houver erro, não continua
  }
}

void controlePID(){
  // Entrada para o PID é a umidade atual
  Input = temperatura;

  // Caso haja chama detectada, acionar bomba no máximo
  if (statusChama == 0) {
    analogWrite(pinBombaDeAgua, 255);  // Ativar bomba em potência máxima (PWM 255)
    // Serial.println("Chama detectada! Bomba ativada no máximo!");
  } else {
    // Caso não haja chama, controlar bomba com PID
    myPID.Compute();
    Output = map(Output, 0, 255, 153, 255);
    analogWrite(pinBombaDeAgua, Output);  // Saída do PID ajusta o PWM da bomba
  }
}

void exibirDadosSerial(){
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
  Serial.print("Saida:");
  Serial.println(Output);
}
