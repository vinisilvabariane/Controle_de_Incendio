CREATE DATABASE projeto_incendio;

USE projeto_incendio;

CREATE TABLE dados (
    idDados INT AUTO_INCREMENT PRIMARY KEY,
    umidade DECIMAL(5,2),
    temperatura DECIMAL(5,2),
    chama BOOLEAN,
    fumaça BOOLEAN,
    data_verificacao DATETIME
);

INSERT INTO dados (umidade, temperatura, chama, fumaça, data_verificacao)
VALUES 
(65.50, 23.30, 0, 0),
(55.20, 25.00, 0, 1);

SELECT * FROM dados;