#include <DHT.h>
#include <PID_v1.h>

// Definindo as portas dos sensores
#define FLAME_SENSOR_PIN 2 // Sensor de chama na porta 2 (digital)
#define SMOKE_SENSOR_PIN A0 // Sensor de fumaça na porta A0 (analógico)
#define DHTPIN 3 // Sensor DHT na porta 3
#define PUMP_PIN 3 // Bomba de água controlada pela porta PWM

// Definindo o tipo do sensor DHT
#define DHTTYPE DHT11   // DHT 11 ou DHT22, dependendo do seu modelo

DHT dht(DHTPIN, DHTTYPE);

// Variáveis para controle PID
double Setpoint, Input, Output;

// Definindo os parâmetros do PID: Kp, Ki, Kd
double Kp = 2, Ki = 5, Kd = 1; 
PID myPID(&Input, &Output, &Setpoint, Kp, Ki, Kd, DIRECT);

// Variáveis para leitura dos sensores
int flameStatus;
int smokeLevel;
float humidity;
float temperature;

void setup() {
  Serial.begin(9600);
  
  // Inicializa o sensor DHT
  dht.begin();
  
  // Inicializa o sensor de chama
  pinMode(FLAME_SENSOR_PIN, INPUT);
  
  // Inicializa o pino da bomba de água
  pinMode(PUMP_PIN, OUTPUT);
  
  // Definindo o setpoint de controle
  Setpoint = 50; // Umidade ideal de 50% (ajustável conforme necessidade)

  // Inicializa o PID
  myPID.SetMode(AUTOMATIC);
}

void loop() {
  // Leitura dos sensores
  flameStatus = digitalRead(FLAME_SENSOR_PIN); // 0 ou 1 (chama detectada ou não)
  smokeLevel = analogRead(SMOKE_SENSOR_PIN);   // Leitura analógica de concentração de fumaça (0 a 1023)
  humidity = dht.readHumidity();               // Leitura de umidade do sensor DHT
  temperature = dht.readTemperature();         // Leitura de temperatura do sensor DHT
  
  // Verifica se houve erro na leitura do DHT
  if (isnan(humidity) || isnan(temperature)) {
    Serial.println("Erro na leitura do sensor DHT!");
    return;
  }
  
  // Exibe as leituras dos sensores
  Serial.print("Fumaça: ");
  Serial.println(smokeLevel);
  Serial.print("Umidade: ");
  Serial.println(humidity);
  Serial.print("Temperatura: ");
  Serial.println(temperature);
  
  // Entrada para o PID é a umidade atual (pode-se combinar temperatura se necessário)
  Input = humidity;
  
  // Caso haja chama detectada, acionar bomba no máximo
  if (flameStatus == 1) {
    analogWrite(PUMP_PIN, 255); // Ativar bomba em potência máxima (PWM 255)
    Serial.println("Chama detectada! Bomba ativada no máximo!");
  } else {
    // Caso não haja chama, controlar bomba com PID
    myPID.Compute();
    analogWrite(PUMP_PIN, Output); // Saída do PID ajusta o PWM da bomba
  }
  
  // Tempo de atualização (delay)
  delay(1000);
}