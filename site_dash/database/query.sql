DROP DATABASE projeto_incendio;

CREATE DATABASE projeto_incendio;

USE projeto_incendio;

CREATE TABLE dados (
    idDados INT AUTO_INCREMENT PRIMARY KEY,
    umidade DECIMAL(5,2),
    temperatura DECIMAL(5,2),
    chama BOOLEAN,
    fumaça BOOLEAN,
    data_verificacao TEXT,
    resultado TEXT NOT NULL
);

INSERT INTO dados (umidade, temperatura, chama, fumaça, data_verificacao, resultado) VALUES
(45.00, 25.30, FALSE, FALSE, '2024-10-01 10:00:00', 'Segurança OK'),
(60.50, 22.10, TRUE, TRUE, '2024-10-02 11:15:00', 'Alerta: Chama e fumaça detectadas'),
(30.25, 27.40, FALSE, FALSE, '2024-10-03 12:30:00', 'Segurança OK'),
(75.00, 24.00, TRUE, FALSE, '2024-10-04 09:45:00', 'Alerta: Chama detectada'),
(50.00, 23.50, FALSE, TRUE, '2024-10-05 14:20:00', 'Alerta: Fumaça detectada'),
(55.10, 26.70, TRUE, TRUE, '2024-10-06 15:30:00', 'Alerta: Chama e fumaça detectadas'),
(40.00, 21.80, FALSE, FALSE, '2024-10-07 16:00:00', 'Segurança OK'),
(65.25, 28.90, TRUE, FALSE, '2024-10-08 17:10:00', 'Alerta: Chama detectada'),
(48.30, 22.50, FALSE, TRUE, '2024-10-09 18:25:00', 'Alerta: Fumaça detectada'),
(70.00, 25.00, TRUE, TRUE, '2024-10-10 19:00:00', 'Alerta: Chama e fumaça detectadas');


SELECT * FROM dados;