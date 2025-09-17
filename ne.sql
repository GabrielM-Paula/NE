CREATE DATABASE IF NOT EXISTS NE;
USE NE;

CREATE TABLE Usuario (
    id_usuario INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE Ideia (
    id_ideia INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT,
    nome VARCHAR(150) NOT NULL,
    descricao TEXT,
    data_criacao DATE NOT NULL,
    progresso ENUM('em_progresso', 'concluida') DEFAULT 'em_progresso',
    modo_desenvolvimento ENUM('guiado', 'livre') DEFAULT 'guiado',
    FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario) ON DELETE CASCADE
);

CREATE TABLE Tarefa (
    id_tarefa INT PRIMARY KEY AUTO_INCREMENT,
    id_ideia INT,
    descricao TEXT NOT NULL,
    concluida BOOLEAN DEFAULT FALSE,
    data_criacao DATE NOT NULL,
    data_conclusao DATE NULL,
    FOREIGN KEY (id_ideia) REFERENCES Ideia(id_ideia) ON DELETE CASCADE
);

CREATE TABLE Ferramenta (
    id_ferramenta INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT
);

CREATE TABLE Template (
    id_template INT PRIMARY KEY AUTO_INCREMENT,
    id_ferramenta INT,
    nome VARCHAR(150) NOT NULL,
    descricao TEXT,
    FOREIGN KEY (id_ferramenta) REFERENCES Ferramenta(id_ferramenta)
);

CREATE TABLE Ideia_Ferramenta (
    id_ideia INT,
    id_ferramenta INT,
    PRIMARY KEY (id_ideia, id_ferramenta),
    FOREIGN KEY (id_ideia) REFERENCES Ideia(id_ideia) ON DELETE CASCADE,
    FOREIGN KEY (id_ferramenta) REFERENCES Ferramenta(id_ferramenta)
);

-- Inserir ferramentas padrão
INSERT INTO Ferramenta (nome, descricao) VALUES
('Business Model Canvas', 'Modelo estratégico para desenvolvimento de modelos de negócio'),
('Canva', 'Ferramenta de design para criação de materiais visuais'),
('Pitch', 'Plataforma para criação de apresentações profissionais'),
('Análise SWOT', 'Ferramenta de análise de forças, fraquezas, oportunidades e ameaças'),
('Plano de Marketing', 'Modelo para desenvolvimento de estratégias de marketing'),
('Canvas de Proposta de Valor', 'Ferramenta para definir a proposta de valor do seu produto/serviço');

-- Inserir templates para as ferramentas
INSERT INTO Template (id_ferramenta, nome, descricao) VALUES
(1, 'Business Model Canvas Básico', 'Modelo simplificado para startups'),
(1, 'Business Model Canvas Completo', 'Modelo detalhado para empresas estabelecidas'),
(2, 'Apresentação para Investidores', 'Template profissional para pitch de investimento'),
(2, 'Portfólio de Produtos', 'Template para showcase de produtos ou serviços'),
(3, 'Pitch Deck Startup', 'Apresentação especializada');