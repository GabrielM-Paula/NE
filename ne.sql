-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 25/11/2025 às 18:46
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `ne`
--
CREATE DATABASE IF NOT EXISTS `ne` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `ne`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `ferramenta`
--

CREATE TABLE `ferramenta` (
  `id_ferramenta` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `ferramenta`
--

INSERT INTO `ferramenta` (`id_ferramenta`, `nome`, `descricao`) VALUES
(1, 'Business Model Canvas', 'Modelo estratégico para desenvolvimento de modelos de negócio'),
(2, 'Canva', 'Ferramenta de design para criação de materiais visuais'),
(3, 'Pitch', 'Plataforma para criação de apresentações profissionais'),
(4, 'Análise SWOT', 'Ferramenta de análise de forças, fraquezas, oportunidades e ameaças'),
(5, 'Plano de Marketing', 'Modelo para desenvolvimento de estratégias de marketing'),
(6, 'Canvas de Proposta de Valor', 'Ferramenta para definir a proposta de valor do seu produto/serviço');

-- --------------------------------------------------------

--
-- Estrutura para tabela `ideia`
--

CREATE TABLE `ideia` (
  `id_ideia` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `nome` varchar(150) NOT NULL,
  `descricao` text DEFAULT NULL,
  `tempo_hora` datetime NOT NULL DEFAULT current_timestamp(),
  `progresso` enum('em_progresso','concluida') DEFAULT 'em_progresso',
  `arquivado` tinyint(4) NOT NULL DEFAULT 0,
  `modo_desenvolvimento` enum('guiado','livre') DEFAULT 'guiado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `ideia`
--

INSERT INTO `ideia` (`id_ideia`, `id_usuario`, `nome`, `descricao`, `tempo_hora`, `progresso`, `arquivado`, `modo_desenvolvimento`) VALUES
(10, 3, 'Novo Projeto', 'Meu Primeiro Projeto', '2025-11-14 13:49:01', 'em_progresso', 1, 'guiado'),
(11, 4, 'Projeto1', 'progeto1', '2025-11-14 13:49:01', 'em_progresso', 1, 'guiado'),
(12, 4, 'Projeto2', 'projeto2', '2025-11-14 13:49:01', 'em_progresso', 1, 'guiado'),
(13, 4, 'Projeto3', 'projeto3', '2025-11-14 13:49:01', 'em_progresso', 1, 'guiado'),
(16, 5, 'b', 'b', '2025-11-14 13:49:01', 'em_progresso', 1, 'guiado'),
(17, 5, 'b', 'b', '2025-11-14 17:50:14', 'em_progresso', 1, 'guiado'),
(18, 5, 'p', 'p', '2025-11-14 17:51:40', 'em_progresso', 1, 'guiado'),
(19, 5, 'k', 'k', '2025-11-14 17:57:33', 'em_progresso', 1, 'guiado'),
(21, 5, 'i', 'i', '2025-11-14 14:06:54', 'em_progresso', 1, 'guiado'),
(23, 6, 'uu', 'u', '2025-11-25 14:11:11', 'em_progresso', 1, 'guiado'),
(24, 6, 'p', 'p', '2025-11-25 14:17:42', 'em_progresso', 0, 'guiado'),
(25, 6, 'a', 'a', '2025-11-25 14:18:17', 'em_progresso', 0, 'guiado');

-- --------------------------------------------------------

--
-- Estrutura para tabela `ideia_ferramenta`
--

CREATE TABLE `ideia_ferramenta` (
  `id_ideia` int(11) NOT NULL,
  `id_ferramenta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `ideia_ferramenta`
--

INSERT INTO `ideia_ferramenta` (`id_ideia`, `id_ferramenta`) VALUES
(10, 1),
(10, 2),
(10, 3),
(10, 4),
(10, 5),
(10, 6),
(11, 1),
(11, 2),
(11, 3),
(11, 4),
(11, 5),
(11, 6),
(12, 1),
(12, 2),
(12, 3),
(12, 4),
(12, 5),
(12, 6),
(13, 1),
(13, 2),
(13, 3),
(13, 4),
(13, 5),
(13, 6),
(16, 1),
(16, 2),
(16, 3),
(16, 4),
(16, 5),
(16, 6),
(17, 1),
(17, 2),
(17, 3),
(17, 4),
(17, 5),
(17, 6),
(18, 1),
(18, 2),
(18, 3),
(18, 4),
(18, 5),
(18, 6),
(19, 1),
(19, 2),
(19, 3),
(19, 4),
(19, 5),
(19, 6),
(21, 1),
(21, 2),
(21, 3),
(21, 4),
(21, 5),
(21, 6),
(23, 1),
(23, 2),
(23, 3),
(23, 4),
(23, 5),
(23, 6),
(24, 1),
(24, 2),
(24, 3),
(24, 4),
(24, 5),
(24, 6),
(25, 1),
(25, 2),
(25, 3),
(25, 4),
(25, 5),
(25, 6);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tarefa`
--

CREATE TABLE `tarefa` (
  `id_tarefa` int(11) NOT NULL,
  `id_ideia` int(11) DEFAULT NULL,
  `descricao` text NOT NULL,
  `concluida` tinyint(1) DEFAULT 0,
  `data_criacao` date NOT NULL,
  `data_conclusao` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `template`
--

CREATE TABLE `template` (
  `id_template` int(11) NOT NULL,
  `id_ferramenta` int(11) DEFAULT NULL,
  `nome` varchar(150) NOT NULL,
  `descricao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `template`
--

INSERT INTO `template` (`id_template`, `id_ferramenta`, `nome`, `descricao`) VALUES
(1, 1, 'Business Model Canvas Básico', 'Modelo simplificado para startups'),
(2, 1, 'Business Model Canvas Completo', 'Modelo detalhado para empresas estabelecidas'),
(3, 2, 'Apresentação para Investidores', 'Template profissional para pitch de investimento'),
(4, 2, 'Portfólio de Produtos', 'Template para showcase de produtos ou serviços'),
(5, 3, 'Pitch Deck Startup', 'Apresentação especializada');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nome`, `email`, `senha`, `data_criacao`) VALUES
(1, 'Nome', 'nome@gmail.com', '$2y$10$/jLaSjrZ6I7YcNz.mAMloeIER9i7cLmCrlD5mxuZLRSCn4n623B3q', '2025-09-18 00:11:25'),
(2, 'c', 'c@gmail.com', '$2y$10$YtLOT/w1sb1UdxXUyoYXQur.6q83rbTFD8T9euZNqQQHCloQmC6nG', '2025-09-18 00:12:56'),
(3, 'nome', 'nome1@gmail.com', '$2y$10$DbRIdRsaRg.zE8AJovwmku9CEE9a4CEHW2OapavqE1AOLxbfqLB/u', '2025-09-26 05:18:13'),
(4, 'abcdario', 'abcdario@gmail.com', '$2y$10$q6fTvBxQSfrvdvc1bT5chOBZcoR3VI472Xrnmwjb8vSZ8SxWiqDq.', '2025-10-02 23:08:10'),
(5, 'as', 'as@gmail.com', '$2y$10$LM3bVDySIWGcwT7krM4JFul5vqL1231.9aeVC3vxs7xqlATYCgavm', '2025-11-14 16:39:15'),
(6, 'b', 'b@gmail.com', '$2y$10$sRl2jLbgYcqgOqNiwf/O../xdg648rey1PzZUw1nPtLoHWl6vUqrW', '2025-11-25 16:45:15');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `ferramenta`
--
ALTER TABLE `ferramenta`
  ADD PRIMARY KEY (`id_ferramenta`);

--
-- Índices de tabela `ideia`
--
ALTER TABLE `ideia`
  ADD PRIMARY KEY (`id_ideia`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices de tabela `ideia_ferramenta`
--
ALTER TABLE `ideia_ferramenta`
  ADD PRIMARY KEY (`id_ideia`,`id_ferramenta`),
  ADD KEY `id_ferramenta` (`id_ferramenta`);

--
-- Índices de tabela `tarefa`
--
ALTER TABLE `tarefa`
  ADD PRIMARY KEY (`id_tarefa`),
  ADD KEY `id_ideia` (`id_ideia`);

--
-- Índices de tabela `template`
--
ALTER TABLE `template`
  ADD PRIMARY KEY (`id_template`),
  ADD KEY `id_ferramenta` (`id_ferramenta`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `ferramenta`
--
ALTER TABLE `ferramenta`
  MODIFY `id_ferramenta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `ideia`
--
ALTER TABLE `ideia`
  MODIFY `id_ideia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de tabela `tarefa`
--
ALTER TABLE `tarefa`
  MODIFY `id_tarefa` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `template`
--
ALTER TABLE `template`
  MODIFY `id_template` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `ideia`
--
ALTER TABLE `ideia`
  ADD CONSTRAINT `ideia_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE;

--
-- Restrições para tabelas `ideia_ferramenta`
--
ALTER TABLE `ideia_ferramenta`
  ADD CONSTRAINT `ideia_ferramenta_ibfk_1` FOREIGN KEY (`id_ideia`) REFERENCES `ideia` (`id_ideia`) ON DELETE CASCADE,
  ADD CONSTRAINT `ideia_ferramenta_ibfk_2` FOREIGN KEY (`id_ferramenta`) REFERENCES `ferramenta` (`id_ferramenta`);

--
-- Restrições para tabelas `tarefa`
--
ALTER TABLE `tarefa`
  ADD CONSTRAINT `tarefa_ibfk_1` FOREIGN KEY (`id_ideia`) REFERENCES `ideia` (`id_ideia`) ON DELETE CASCADE;

--
-- Restrições para tabelas `template`
--
ALTER TABLE `template`
  ADD CONSTRAINT `template_ibfk_1` FOREIGN KEY (`id_ferramenta`) REFERENCES `ferramenta` (`id_ferramenta`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
