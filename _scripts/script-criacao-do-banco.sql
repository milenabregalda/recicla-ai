CREATE DATABASE IF NOT EXISTS banco_recicla_ai;

USE banco_recicla_ai;

CREATE TABLE usuario (
	id INT AUTO_INCREMENT PRIMARY KEY,
	nome VARCHAR(100) NOT NULL,
	email VARCHAR(100) NOT NULL,
	senha VARCHAR(100) NOT NULL,
	tipo_usuario ENUM('comum', 'admin') DEFAULT 'comum' NOT NULL,
	data_cadastro TIMESTAMP
);

CREATE TABLE administrador (
	id INT AUTO_INCREMENT PRIMARY KEY,
	permissoes ENUM('editar', 'excluir', 'criar', 'visualizar') NOT NULL,
	data_admissao TIMESTAMP,
	id_usuario INT,
	FOREIGN KEY (id_usuario) REFERENCES usuario(id)
);

CREATE TABLE pontos_coleta (
	id INT AUTO_INCREMENT PRIMARY KEY,
	nome VARCHAR(100) NOT NULL,
	endereco VARCHAR(255) NOT NULL,
	cidade VARCHAR(100) NOT NULL,
	estado VARCHAR(2) NOT NULL,
	capacidade_total INT NOT NULL,
	capacidade_disponivel INT NOT NULL,
	horario_funcionamento VARCHAR(100),
	contato VARCHAR(100),
	id_admin INT,
	FOREIGN KEY (id_admin) REFERENCES administrador(id)
);

CREATE TABLE noticias (
	id INT AUTO_INCREMENT PRIMARY KEY,
	titulo VARCHAR(100) NOT NULL,
	conteudo TEXT NOT NULL,
	data_publicacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO usuario (nome, email, senha, tipo_usuario, data_cadastro)
VALUES ('Administrador', 'admin@reciclaai.com', SHA2('senha123', 256), 'admin', NOW());

INSERT INTO administrador (permissoes, data_admissao, id_usuario)
VALUES ('criar', NOW(), 1);

INSERT INTO pontos_coleta (nome, endereco, cidade, estado, capacidade_total, capacidade_disponivel, horario_funcionamento, contato, id_admin)
VALUES 
('DMLU - Conceição', 'Rua Alberto Bins, próximo ao nº 650 (embaixo do Viaduto da Conceição) - Bairro Centro', 'Porto Alegre', 'RS', 100, 100, 'Seg à Sex: 8h-18h | Sáb/Feriados: 8h-12h', '', 1),
('DMLU - Ecoponto Câncio Gomes', 'Travessa Carmem, 111 - Bairro Floresta', 'Porto Alegre', 'RS', 100, 100, 'Seg à Sex: 7h-18h | Sáb/Feriados: 8h-12h', '', 1),
('DMLU - Ecoponto Glória', 'Rua Professor Carvalho de Freitas, 1.012 - Bairro Glória', 'Porto Alegre', 'RS', 100, 100, 'Seg à Sex: 7h-18h | Sáb/Feriados: 8h-12h', '', 1),
('DMLU - Ecoponto Humaitá', 'Rua José Aloísio Filho, 780 - Bairro Humaitá', 'Porto Alegre', 'RS', 100, 100, 'Seg à Sex: 8h-16h | Sáb/Feriados: 8h-12h', '', 1),
('DMLU - Ecoponto Cruzeiro', 'Av. Cruzeiro do Sul, 1.445 - Vila Cruzeiro do Sul', 'Porto Alegre', 'RS', 100, 100, 'Seg à Sex: 8h-17h | Sáb/Feriados: 8h-12h', '', 1),
('DMLU - Ecoponto Princesa Isabel', 'Av. Ipiranga, 2765 - Bairro Santana (entrada pela rua Livramento, esquina com Av. Princesa Isabel)', 'Porto Alegre', 'RS', 100, 100, 'Seg à Sex: 7h-18h | Sáb/Feriados: 8h-12h', '', 1);

INSERT INTO noticias (titulo, conteudo)
VALUES
('Lixo Eletrônico: O Desafio Global da Era Digital', 'https://avozdaserra.com.br/colunas/prosa-sustentavel/lixo-eletronico-o-desafio-global-da-era-digital'),
('Brasil é o 5º país que mais produz resíduos eletrônicos, mas descarte correto ainda é pequeno', 'https://g1.globo.com/jornal-nacional/noticia/2024/04/27/brasil-e-o-5o-pais-que-mais-produz-residuos-eletronicos-mas-descarte-correto-ainda-e-pequeno.ghtml'),
('Ribeirão Pires promove Drive-Thru de lixo eletrônico; saiba como participar', 'https://www.dgabc.com.br/Noticia/4163657/ribeirao-pires-promove-drive-thru-de-lixo-eletronico-saiba-como-participar');

SELECT * FROM usuario;
SELECT * FROM administrador;
SELECT * FROM pontos_coleta;
SELECT * FROM noticias;


