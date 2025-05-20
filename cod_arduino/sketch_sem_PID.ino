#include <DHT.h>

#define DHTPIN 2
#define DHTTYPE DHT22
#define FLAME_SENSOR_PIN 3
#define FAN_INA 5   // Pino INA do L9110
#define FAN_INB 6   // Pino INB do L9110
#define PUMP_PIN 9   // Pino da bomba d'água

DHT dht(DHTPIN, DHTTYPE);

void setup() {
  Serial.begin(9600);
  dht.begin();
  
  pinMode(FLAME_SENSOR_PIN, INPUT_PULLUP);  // Sensor de chama com pull-up interno
  pinMode(FAN_INA, OUTPUT);
  pinMode(FAN_INB, OUTPUT);
  pinMode(PUMP_PIN, OUTPUT);
  
  // Inicia com todos os dispositivos desligados
  digitalWrite(FAN_INA, LOW);
  digitalWrite(FAN_INB, LOW);
  digitalWrite(PUMP_PIN, LOW);
  
  Serial.println("Sistema iniciado - Modulo L9110");
  Serial.println("Aguardando dados dos sensores...");
}

void loop() {
  float temp = dht.readTemperature();
  bool hasFlame = digitalRead(FLAME_SENSOR_PIN) == LOW;  // LOW = chama detectada

  // Verifica leitura do sensor de temperatura
  if (isnan(temp)) {
    Serial.println("Erro na leitura do DHT22!");
    digitalWrite(FAN_INA, LOW);
    digitalWrite(FAN_INB, LOW);
    delay(2000);
    return;
  }

  // Controle da bomba d'água (com debug detalhado)
  if(hasFlame) {
    digitalWrite(PUMP_PIN, HIGH);
    Serial.println("CHAMA DETECTADA - BOMBA LIGADA");
  } else {
    digitalWrite(PUMP_PIN, LOW);
    Serial.println("Sem chama - Bomba desligada");
  }

  // Controle da ventoinha L9110
  if(temp > 40.0) {
    digitalWrite(FAN_INA, HIGH);
    digitalWrite(FAN_INB, LOW);
    Serial.print("VENTOINHA LIGADA - Temp: ");
    Serial.println(temp);
  } else {
    digitalWrite(FAN_INA, LOW);
    digitalWrite(FAN_INB, LOW);
    Serial.print("Ventoinha DESLIGADA - Temp: ");
    Serial.println(temp);
  }

  delay(1000);  // Intervalo entre leituras
}