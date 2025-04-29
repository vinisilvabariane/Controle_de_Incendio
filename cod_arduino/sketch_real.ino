#include <DHT.h>
#include <PID_v1.h>

// ------------------- CONFIGURAÇÕES ------------------- //
#define DHTPIN 2
#define DHTTYPE DHT22

#define FLAME_SENSOR_PIN 3  // Sensor de chama (LOW = fogo)
#define FAN_IN1 5           // Ventilador controlado pelo PID
#define PUMP_IN1 9          // Bomba (acionada apenas por fogo)

DHT dht(DHTPIN, DHTTYPE);

// PID - Variáveis
double Setpoint = 30.0;  // Temperatura alvo (°C)
double Input, Output;    // Entrada (temperatura) e Saída (PWM)
double Kp = 2.0, Ki = 5.0, Kd = 1.0;

PID myPID(&Input, &Output, &Setpoint, Kp, Ki, Kd, DIRECT);

void setup() {
  Serial.begin(9600);
  Serial.println("Temp\tPID\tChamas");

  dht.begin();

  pinMode(FLAME_SENSOR_PIN, INPUT_PULLUP);  // Botão ou sensor de chama

  pinMode(FAN_IN1, OUTPUT);   // Ventilador (PWM)
  pinMode(PUMP_IN1, OUTPUT);  // Bomba (ON/OFF)

  digitalWrite(FAN_IN1, LOW);
  digitalWrite(PUMP_IN1, LOW);

  myPID.SetMode(AUTOMATIC);
  myPID.SetOutputLimits(0, 255);  // PWM range para ventilador
}

void loop() {
  float temperature = dht.readTemperature();
  bool flameDetected = digitalRead(FLAME_SENSOR_PIN) == LOW;

  if (isnan(temperature)) {
    Serial.println("Erro ao ler o DHT22!");
    return;
  }

  // Atualiza temperatura e calcula PID
  Input = temperature;
  myPID.Compute();

  // -------------- CONTROLE DO VENTILADOR (PID) --------------
  analogWrite(FAN_IN1, Output);  // PWM proporcional à temperatura

  // -------------- CONTROLE DA BOMBA (FLAME SENSOR) --------------
  if (flameDetected) {
    digitalWrite(PUMP_IN1, HIGH);  // Aciona bomba
  } else {
    digitalWrite(PUMP_IN1, LOW);  // Desliga bomba
  }

  // Debug no Serial
  Serial.print(temperature);
  Serial.print("\t");
  Serial.print(Output);
  Serial.print("\t");
  Serial.println(flameDetected ? 1 : 0);

  delay(1000);
}
