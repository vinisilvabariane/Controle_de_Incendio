/* ------------------------- */
/* CRIAÇÃO DO BANCO DE DADOS */
/* ------------------------- */
CREATE DATABASE IF NOT EXISTS site_dash;
USE site_dash;

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

/* ------------------------- */
/*     SEÇÃO DE SELECTS      */
/* ------------------------- */
SELECT * FROM users;