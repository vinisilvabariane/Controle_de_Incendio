import serial
import time
import re

def obterMsgSerial(porta_serial:str, baud_rate = 9600 ) -> dict[str:float]:
    info = {}
    try:
        ser = serial.Serial(porta_serial, baud_rate, timeout=1)
        time.sleep(2)

        while True:
            if ser.in_waiting > 0:
                # Ler a linha recebida do Arduino
                linha = ser.readline().decode('ISO-8859-1').rstrip()
                infos = re.findall(r'Fumaca:(.+?):(.+?),Temperatura:(.+?),Chama:(.+?),Entrada:(.+?),Setpoint:(.+?),Saida:(.+?)', linha)[0]
                if infos != []:
                    info["Umidade"] = float(infos[1])
                    info["Temperatura"] = float(infos[2])
                    info["Chama"] = float(infos[3])
                    info["Entrada"] = float(infos[4])
                    info["Setpoint"] = float(infos[5])
                    info["Saida"] = float(infos[6])
                    break
        return info

    except serial.SerialException as e:
        print(f"Erro ao conectar à porta serial: {e}")

    finally:
        if ser.is_open:
            ser.close()

if __name__ == "__main__":
    print(obterMsgSerial("COM3"))