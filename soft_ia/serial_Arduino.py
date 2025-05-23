import serial
import time
import re

def obterMsgSerial(porta_serial: str, baud_rate=9600) -> dict[str, float]:
    info = {}
    ser = None
    try:
        ser = serial.Serial(porta_serial, baud_rate, timeout=1)
        time.sleep(2)
        start_time = time.time()
        while time.time() - start_time < 5:
            if ser.in_waiting > 0:
                linha = ser.readline().decode('ISO-8859-1').rstrip()
                print(f"Dado recebido: {linha}")  # Debug
                
                # Ignora mensagens de sistema
                if linha.startswith("ALERTA:") or linha.startswith("Sistema") or linha.startswith("Testando"):
                    continue
                
                # Padrão atual: temperatura,umidade,setpoint,PWM,EstadoBomba
                match = re.search(
                    r'([\d.]+),([\d.]+),([\d.]+),(\d+),(\d+)',
                    linha
                )
                
                if match:
                    info = {
                        "Temperatura": float(match.group(1)),
                        "Umidade": float(match.group(2)),
                        "Setpoint": float(match.group(3)),
                        "PWM": int(match.group(4)),
                        "Bomba": int(match.group(5))
                    }
                    return info
                
        raise serial.SerialException("Nenhum dado válido recebido dentro do timeout")
    except Exception as e:
        print(f"Erro: {e}")
        return {}    
    finally:
        if ser and ser.is_open:
            ser.close()

if __name__ == "__main__":
    print(obterMsgSerial("COM5"))