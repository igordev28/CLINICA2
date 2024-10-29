CREATE DATABASE clinica2;

USE clinica2;

CREATE TABLE pacientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    data_nascimento DATE NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    telefone VARCHAR(15) NOT NULL,
    endereco VARCHAR(255),
    sexo ENUM('masculino', 'feminino', 'outro') NOT NULL
);

SELECT * FROM pacientes