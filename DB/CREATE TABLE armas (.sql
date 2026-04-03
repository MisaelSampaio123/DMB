CREATE TABLE armas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    modelo VARCHAR(100),
    calibre VARCHAR(50),
    numero_serie VARCHAR(100),
    situacao VARCHAR(50),
    data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP
);