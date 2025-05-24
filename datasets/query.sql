/* ------------------------- */
/* CRIAÇÃO DO BANCO DE DADOS */
/* ------------------------- */
CREATE DATABASE IF NOT EXISTS projeto_incendio;
USE projeto_incendio;

/* --------------------------- */
/* CRIAÇÃO DA TABELA DE USERS  */
/* --------------------------- */
CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(80) NOT NULL,
    username VARCHAR(200) NOT NULL,
    password VARCHAR(200) NOT NULL,
    permission TINYINT NOT NULL DEFAULT 0,
    status TINYINT NOT NULL DEFAULT 1
);

CREATE TABLE dados (
    id INT PRIMARY KEY AUTO_INCREMENT,
    umidade FLOAT NOT NULL,
    temperatura FLOAT NOT NULL,
    chama BOOLEAN NOT NULL,
    data_verificacao DATETIME NOT NULL,
    resultado VARCHAR(100)
);

INSERT INTO users (name, username, password, permission, status)
VALUES 
('Vinicius Bariane', 'vini.bariane', '202cb962ac59075b964b07152d234b70', 0, 1),
('Maria Heloísa', 'maria.heloisa', '202cb962ac59075b964b07152d234b70', 0, 1),
('Maria Morgado', 'maria.morgado', '202cb962ac59075b964b07152d234b70', 0, 1),
('Gabriela Florêncio', 'gabriela.florencio', '202cb962ac59075b964b07152d234b70', 0, 1),
('Gabriel Sampaio', 'gabriel.sampaio', '202cb962ac59075b964b07152d234b70', 0, 1),
('Kleber Santana', 'kleber.santana', '202cb962ac59075b964b07152d234b70', 0, 1);

INSERT INTO dados (umidade, temperatura, chama, data_verificacao, resultado)
VALUES 
    (55.3, 25.8, 0, NOW() - INTERVAL 1 DAY, 'Normal'),
    (53.7, 26.4, 0, NOW() - INTERVAL 12 HOUR, 'Normal'),
    (50.2, 28.9, 0, NOW() - INTERVAL 6 HOUR, 'Normal'),
    (48.6, 32.1, 0, NOW() - INTERVAL 3 HOUR, 'Temperatura elevada'),
    (45.8, 36.7, 0, NOW() - INTERVAL 1 HOUR, 'Alerta de temperatura'),
    (42.3, 41.2, 1, NOW(), 'INCÊNDIO DETECTADO');

/* ------------------------- */
/*     SEÇÃO DE SELECTS      */
/* ------------------------- */
SELECT * FROM users;