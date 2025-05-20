/* ------------------------- */
/* CRIAÇÃO DO BANCO DE DADOS */
/* ------------------------- */
CREATE DATABASE IF NOT EXISTS site_dash;
USE site_dash;

/* --------------------------- */
/* CRIAÇÃO DA TABELA DE VIDEOS */
/* --------------------------- */
CREATE TABLE IF NOT EXISTS videos (
  id INT PRIMARY KEY AUTO_INCREMENT,
  link TEXT NOT NULL,
  title VARCHAR(200) NULL,
  priority TINYINT NOT NULL,
  filial VARCHAR(50) NOT NULL
);

UPDATE videos SET priority = :priority WHERE id = :id AND filial = :filial;
INSERT INTO videos (link, title, priority, filial) VALUES ('FDFA', 'FDSA', 2, "FDASZ");

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

/* ------------------------- */
/*     SEÇÃO DE INSERTS      */
/* ------------------------- */
INSERT INTO users(name, username, password, permission, status)
VALUES('Vinicius Bariane', 'vinicius.bariane', MD5('123'), 1, 1);

/* ------------------------- */
/*     SEÇÃO DE SELECTS      */
/* ------------------------- */
SELECT * FROM videos;
SELECT * FROM users;
SELECT * FROM users WHERE username = :username AND password = MD5(:password)
SELECT * FROM videos
SELECT * FROM videos WHERE filial = :filial ORDER BY priority ASC
