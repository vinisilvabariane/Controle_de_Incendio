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

/* ------------------------- */
/*     SEÇÃO DE SELECTS      */
/* ------------------------- */
SELECT * FROM users;