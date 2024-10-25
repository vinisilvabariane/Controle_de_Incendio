import serial
import time
import re

def obterMsgSerial(porta_serial:str, baud_rate = 9600 ) -> dict[str:float]:
    info = {}
    contador = 0
    # Abrir a conexão serial
    try:
        ser = serial.Serial(porta_serial, baud_rate, timeout=1)
        time.sleep(2)  # Aguarda 2 segundos para a conexão estabilizar

        while True:
            if ser.in_waiting > 0:
                # Ler a linha recebida do Arduino
                linha = ser.readline().decode('utf-8').rstrip()
                fumaca = re.findall(r'Fumaça: (.+)', linha)
                if fumaca != []:
                    info["Fumaça"] = fumaca[0]
                    break

        while True:
            if ser.in_waiting > 0:
                # Ler a linha recebida do Arduino
                linha = ser.readline().decode('utf-8').rstrip()
                temperatura = re.findall(r'Temperatura: (.+)', linha)
                if temperatura != []:
                    info["Temperatura"] = temperatura[0]
                    break

        while True:
            if ser.in_waiting > 0:
                # Ler a linha recebida do Arduino
                linha = ser.readline().decode('utf-8').rstrip()
                umidade = re.findall(r'Umidade: (.+)', linha)
                if umidade != []:
                    info["Umidade"] = umidade[0]
                    break

        return info

    except serial.SerialException as e:
        print(f"Erro ao conectar à porta serial: {e}")

    finally:
        # Fechar a conexão serial ao terminar
        if ser.is_open:
            ser.close()

if __name__ == "__main__":
    print(obterMsgSerial("COM3"))