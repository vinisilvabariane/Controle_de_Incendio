#include <DHT.h>
#include <PID_v1.h>

#define DHTPIN 2
#define DHTTYPE DHT22
#define FLAME_SENSOR_PIN 3
#define FAN_IN1 5
#define PUMP_IN1 9

// Configurações de temperatura
#define TEMP_HISTERESE 2.0  // Histerese para evitar oscilação
#define SETPOINT 40.0       // Temperatura desejada
#define MAX_TEMP 80.0       // Temperatura máxima de segurança

DHT dht(DHTPIN, DHTTYPE);

// Variáveis PID
double Input, Output;
double Kp = 10.0, Ki = 0.1, Kd = 1.0;  // Valores mais conservadores

PID myPID(&Input, &Output, &SETPOINT, Kp, Ki, Kd, DIRECT);

void setup() {
  Serial.begin(9600);
  dht.begin();
  
  pinMode(FLAME_SENSOR_PIN, INPUT_PULLUP);
  pinMode(FAN_IN1, OUTPUT);
  pinMode(PUMP_IN1, OUTPUT);
  
  digitalWrite(FAN_IN1, LOW);
  digitalWrite(PUMP_IN1, LOW);

  myPID.SetMode(AUTOMATIC);
  myPID.SetOutputLimits(0, 255);
}

void loop() {
  float temperature = dht.readTemperature();
  bool flameDetected = digitalRead(FLAME_SENSOR_PIN) == LOW;

  if (isnan(temperature)) {
    Serial.println("Erro ao ler temperatura!");
    return;
  }

  temperature = constrain(temperature, 0, MAX_TEMP);
  Input = temperature;

  // Habilita o cálculo do PID apenas quando próximo do setpoint
  if (temperature >= (SETPOINT - TEMP_HISTERESE)) {
    myPID.Compute();
    analogWrite(FAN_IN1, Output);
  } else {
    analogWrite(FAN_IN1, 0);
    // Reseta o PID para evitar windup integral
    myPID.SetMode(MANUAL);
    Output = 0;
    myPID.SetMode(AUTOMATIC);
  }

  // Controle da bomba
  digitalWrite(PUMP_IN1, flameDetected ? HIGH : LOW);

  // Monitoramento
  Serial.print(temperature);
  Serial.print("\t");
  Serial.print(Output);
  Serial.print("\t");
  Serial.println(flameDetected ? 1 : 0);

  delay(1000);
}