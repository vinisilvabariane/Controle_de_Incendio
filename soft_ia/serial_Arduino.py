import serial
import time

# Definir a porta e a taxa de transmissão (baud rate)
porta_serial = 'COM4'  # Ajuste conforme seu sistema: 'COM3' no Windows, '/dev/ttyUSB0' no Linux
baud_rate = 9600       # Taxa de transmissão (deve coincidir com a configuração do Arduino)

# Abrir a conexão serial
try:
    ser = serial.Serial(porta_serial, baud_rate, timeout=1)
    time.sleep(2)  # Aguarda 2 segundos para a conexão estabilizar

    while True:
        if ser.in_waiting > 0:
            # Ler a linha recebida do Arduino
            linha = ser.readline().decode('utf-8').rstrip()
            print(f"Dado recebido: {linha}")

except serial.SerialException as e:
    print(f"Erro ao conectar à porta serial: {e}")

finally:
    # Fechar a conexão serial ao terminar
    if ser.is_open:
        ser.close()
