#include <DHT.h>

// === DEFINIÇÕES DE PINOS ===
#define DHTPIN 2
#define DHTTYPE DHT22
#define FLAME_SENSOR_PIN 3
#define FAN_INA 5
#define FAN_INB 6
#define PUMP_MAIN 9
#define PUMP_AUX 10

// === VARIÁVEIS DO PI ===
float Kp = 5.0;
float Ki = 0.1;
float integral = 0;
float setpoint = 40.0;

DHT dht(DHTPIN, DHTTYPE);

void setup() {
  Serial.begin(9600);
  dht.begin();

  pinMode(FLAME_SENSOR_PIN, INPUT);
  pinMode(FAN_INA, OUTPUT);
  pinMode(FAN_INB, OUTPUT);
  pinMode(PUMP_MAIN, OUTPUT);
  pinMode(PUMP_AUX, OUTPUT);

  // Estado inicial: tudo desligado
  digitalWrite(FAN_INA, LOW);
  digitalWrite(FAN_INB, LOW);
  digitalWrite(PUMP_MAIN, LOW);
  digitalWrite(PUMP_AUX, LOW);
}

void loop() {
  float temp = dht.readTemperature();
  float humidity = dht.readHumidity();
  bool hasFlame = digitalRead(FLAME_SENSOR_PIN) == LOW;

  // Checa leitura inválida
  if (isnan(temp) || isnan(humidity)) {
    Serial.println("Erro na leitura do DHT22!");
    delay(2000);
    return;
  }

  // === CONTROLE DA BOMBA ===
  if (hasFlame) {
    digitalWrite(PUMP_MAIN, HIGH);
    digitalWrite(PUMP_AUX, HIGH);
    Serial.println("🔥 FOGO DETECTADO - BOMBA ATIVADA!");
  } else {
    digitalWrite(PUMP_MAIN, LOW);
    digitalWrite(PUMP_AUX, LOW);
  }

  // === CONTROLE PI DA VENTOINHA ===
  int pwmValue = 0;
  if (temp > setpoint) {
    float error = temp - setpoint;
    integral += error;
    integral = constrain(integral, 0, 255.0 / Ki);
    pwmValue = constrain(Kp * error + Ki * integral, 0, 255);

    analogWrite(FAN_INA, pwmValue);
    digitalWrite(FAN_INB, LOW);
  } else {
    digitalWrite(FAN_INA, LOW);
    digitalWrite(FAN_INB, LOW);
    integral = 0; // zera a integral se estiver abaixo do setpoint
  }

  // === MONITOR SERIAL ===
  Serial.print("Temp: ");
  Serial.print(temp);
  Serial.print("°C | Umidade: ");
  Serial.print(humidity);
  Serial.print("% | Ventoinha: ");
  Serial.print(pwmValue);
  Serial.print("/255 | Bomba: ");
  Serial.println(hasFlame ? "LIGADA (FOGO)" : "DESLIGADA");

  delay(1000);
}
