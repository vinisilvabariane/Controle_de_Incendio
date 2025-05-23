#include <DHT.h>

#define DHTPIN 2
#define DHTTYPE DHT22
#define FLAME_SENSOR_PIN 3
#define FAN_INA 5      // Pino INA do L9110 (PWM)
#define FAN_INB 6      // Pino INB do L9110
#define PUMP_MAIN 9    // Pino principal da bomba (LIGA/DESLIGA)
#define PUMP_AUX 10    // Pino auxiliar da bomba (sentido/PWM) - opcional

// Parâmetros do controlador PI
float Kp = 5.0;
float Ki = 0.1;
float integral = 0;
float setpoint = 40.0;

DHT dht(DHTPIN, DHTTYPE);

void setup() {
  Serial.begin(9600);
  dht.begin();
  
  pinMode(FLAME_SENSOR_PIN, INPUT_PULLUP);
  pinMode(FAN_INA, OUTPUT);
  pinMode(FAN_INB, OUTPUT);
  pinMode(PUMP_MAIN, OUTPUT);
  pinMode(PUMP_AUX, OUTPUT);
  
  // Desliga todos os dispositivos
  digitalWrite(FAN_INA, LOW);
  digitalWrite(FAN_INB, LOW);
  digitalWrite(PUMP_MAIN, LOW);
  digitalWrite(PUMP_AUX, LOW);  // Configuração adicional para a bomba
  
  Serial.println("Sistema Iniciado - Bomba nos pinos 9 e 10");
  Serial.println("Temperatura,Umidade,Setpoint,PWM,EstadoBomba");
}

void testBomba() {
  Serial.println("Testando bomba...");
  digitalWrite(PUMP_MAIN, HIGH);
  digitalWrite(PUMP_AUX, HIGH);  // Ou LOW, dependendo do seu hardware
  delay(2000);
  digitalWrite(PUMP_MAIN, LOW);
  digitalWrite(PUMP_AUX, LOW);
  Serial.println("Teste concluído");
}

void loop() {
  float temp = dht.readTemperature();
  float humidity = dht.readHumidity();  // Nova linha para ler umidade
  bool hasFlame = digitalRead(FLAME_SENSOR_PIN) == LOW;

  if (isnan(temp) || isnan(humidity)) {  // Verifica ambas as leituras
    Serial.println("Erro na leitura do DHT22!");
    delay(2000);
    return;
  }

  // Controle da bomba d'água (independente do PI)
  if(hasFlame) {
    digitalWrite(PUMP_MAIN, HIGH);
    digitalWrite(PUMP_AUX, HIGH);  // Configuração para ligar a bomba
    Serial.println("ALERTA: CHAMA DETECTADA - BOMBA LIGADA!");
  } else {
    digitalWrite(PUMP_MAIN, LOW);
    digitalWrite(PUMP_AUX, LOW);
  }

  // Controle PI da ventoinha (original)
  int pwmValue = 0;
  if(temp > setpoint) {
    float error = temp - setpoint;
    integral += error;
    integral = constrain(integral, 0, 100/Ki);
    pwmValue = constrain(Kp * error + Ki * integral, 0, 255);
    
    analogWrite(FAN_INA, pwmValue);
    digitalWrite(FAN_INB, LOW);
  } else {
    digitalWrite(FAN_INA, LOW);
    digitalWrite(FAN_INB, LOW);
    integral = 0;
  }

  // Saída para plotter modificada para incluir umidade
  Serial.print(temp);
  Serial.print(",");
  Serial.print(humidity);
  Serial.print(",");
  Serial.print(setpoint);
  Serial.print(",");
  Serial.print(pwmValue);
  Serial.print(",");
  Serial.println(digitalRead(PUMP_MAIN));  // Mostra estado da bomba

  delay(1000);
}