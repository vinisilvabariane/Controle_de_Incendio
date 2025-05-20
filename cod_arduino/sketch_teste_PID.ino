#include <PID_v1.h>

// Simulação sem DHT
// #include <DHT.h> -> Removido

// ------------------- Configurações ------------------- //
#define FLAME_SENSOR_PIN 3     // Botão simula sensor de chama
#define MOTOR_IN1 9            
#define MOTOR_IN2 10           // Pode ser deixado desconectado

#define FAN_IN1 5              // L9110 IN1
#define FAN_IN2 6              // L9110 IN2

// PID - Variáveis
double Setpoint = 30.0;        // Temperatura alvo (°C)
double Input, Output;          // Entrada e saída do PID
double Kp = 2.0, Ki = 5.0, Kd = 1.0;

PID myPID(&Input, &Output, &Setpoint, Kp, Ki, Kd, DIRECT);

float fakeTemp = 20.0;         // Temperatura inicial simulada
unsigned long lastUpdate = 0;

void setup() {
  Serial.begin(9600);
  Serial.println("Temperatura\tPID_Output\tSetpoint\tChamas");

  pinMode(FLAME_SENSOR_PIN, INPUT_PULLUP);
  pinMode(MOTOR_IN1, OUTPUT);
  pinMode(MOTOR_IN2, OUTPUT);
  pinMode(FAN_IN1, OUTPUT);
  pinMode(FAN_IN2, OUTPUT);

  myPID.SetMode(AUTOMATIC);
  myPID.SetOutputLimits(0, 255);  // PWM range
}

void loop() {
  // Simula aumento de temperatura a cada 3 segundos
  if (millis() - lastUpdate >= 3000) {
    fakeTemp += 1.5;  // aumenta em 1.5°C
    lastUpdate = millis();
  }

  // Leitura falsa da temperatura
  Input = fakeTemp;
  myPID.Compute();

  bool flameDetected = digitalRead(FLAME_SENSOR_PIN) == LOW;

  // -------- Controle da bomba -------- //
  if (flameDetected || fakeTemp >= 45.0) {
    digitalWrite(MOTOR_IN1, HIGH);
  } else {
    digitalWrite(MOTOR_IN1, LOW);
  }

  // -------- Controle do ventilador -------- //
  analogWrite(FAN_IN1, Output);  // PWM via PID
  digitalWrite(FAN_IN2, LOW);    // Sentido fixo

  // -------- Monitor Serial -------- //
  Serial.print(fakeTemp);
  Serial.print('\t');
  Serial.print(Output);
  Serial.print('\t');
  Serial.print(Setpoint);
  Serial.print('\t');
  Serial.println(flameDetected ? 1 : 0);

  delay(1000);
}