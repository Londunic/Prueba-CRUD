Para poder ejecutar el programa, se debe tener instalado un servidor virtual en 
la computadora. (WampServer, Mamp,XAMPP,entre otro)

Luego se debe guardar la carpeta "prueba-CRUD" en la carpeta www en el caso de 
tener WampServer o htdocs en el caso de Mamp O XAMPP.

Luego entrar en phpMyAdmin, y ejecutar el siguiente código en Sql:

CREATE DATABASE prueba;
GRANT ALL ON prueba.* TO 'edwar'@'localhost'IDENTIFIED BY 'zap';
GRANT ALL ON prueba.* TO 'edwar'@'127.0.0.1'IDENTIFIED BY 'zap';

USE prueba;

CREATE TABLE usuario  (
cedula INTEGER NOT NULL,
edad INTEGER,
nombre VARCHAR(128),
apellido VARCHAR(128), 
genero VARCHAR(128),
PRIMARY KEY(cedula)
)ENGINE=InnoDB CHARSET=utf8;

INSERT INTO usuario (cedula,edad,nombre,apellido,genero) VALUES (1,22,"Jose","Ortiz","M");
INSERT INTO usuario (cedula,edad,nombre,apellido,genero) VALUES (2,34,"Maria","Hernandez","F");
INSERT INTO usuario (cedula,edad,nombre,apellido,genero) VALUES (3,12,"Luis","Lopez","M");

Una vez realizado lo anterior, dirijase al buscador de internet, y ya podra ejecutar el programa.