CREATE DATABASE IF NOT EXISTS logocontrol CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE logocontrol;

CREATE TABLE IF NOT EXISTS produtos (
 id INT AUTO_INCREMENT PRIMARY KEY,
 nome VARCHAR(120) NOT NULL,
 descricao TEXT NULL,
 peso DECIMAL(10,2) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS enderecos (
 id INT AUTO_INCREMENT PRIMARY KEY,
 identificacao VARCHAR(100) NOT NULL,
 logradouro VARCHAR(150) NULL,
 numero VARCHAR(20) NULL,
 bairro VARCHAR(100) NULL,
 cidade VARCHAR(100) NOT NULL,
 estado CHAR(2) NOT NULL,
 cep VARCHAR(10) NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS transportadores (
 id INT AUTO_INCREMENT PRIMARY KEY,
 nome VARCHAR(150) NOT NULL,
 documento VARCHAR(20) NULL,
 telefone VARCHAR(30) NULL,
 email VARCHAR(150) NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS fretes (
 id INT AUTO_INCREMENT PRIMARY KEY,
 transportador_id INT NOT NULL,
 origem_id INT NOT NULL,
 destino_id INT NOT NULL,
 data_frete DATE NOT NULL,
 criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 CONSTRAINT fk_frete_transportador FOREIGN KEY (transportador_id) REFERENCES transportadores(id),
 CONSTRAINT fk_frete_origem FOREIGN KEY (origem_id) REFERENCES enderecos(id),
 CONSTRAINT fk_frete_destino FOREIGN KEY (destino_id) REFERENCES enderecos(id)
) ENGINE=InnoDB;

-- Tabela associativa: permite vários produtos em um mesmo frete.
CREATE TABLE IF NOT EXISTS frete_produtos (
 frete_id INT NOT NULL,
 produto_id INT NOT NULL,
 PRIMARY KEY (frete_id, produto_id),
 CONSTRAINT fk_fp_frete FOREIGN KEY (frete_id) REFERENCES fretes(id) ON DELETE CASCADE,
 CONSTRAINT fk_fp_produto FOREIGN KEY (produto_id) REFERENCES produtos(id)
) ENGINE=InnoDB;
