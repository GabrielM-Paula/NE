-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 26-Set-2025 às 08:09
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.2.12

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
-- Estrutura da tabela `ferramenta`
--

CREATE TABLE `ferramenta` (
  `id_ferramenta` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `ferramenta`
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
-- Estrutura da tabela `ideia`
--

CREATE TABLE `ideia` (
  `id_ideia` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `nome` varchar(150) NOT NULL,
  `descricao` text DEFAULT NULL,
  `data_criacao` date NOT NULL,
  `progresso` enum('em_progresso','concluida') DEFAULT 'em_progresso',
  `modo_desenvolvimento` enum('guiado','livre') DEFAULT 'guiado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ideia_ferramenta`
--

CREATE TABLE `ideia_ferramenta` (
  `id_ideia` int(11) NOT NULL,
  `id_ferramenta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tarefa`
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
-- Estrutura da tabela `template`
--

CREATE TABLE `template` (
  `id_template` int(11) NOT NULL,
  `id_ferramenta` int(11) DEFAULT NULL,
  `nome` varchar(150) NOT NULL,
  `descricao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `template`
--

INSERT INTO `template` (`id_template`, `id_ferramenta`, `nome`, `descricao`) VALUES
(1, 1, 'Business Model Canvas Básico', 'Modelo simplificado para startups'),
(2, 1, 'Business Model Canvas Completo', 'Modelo detalhado para empresas estabelecidas'),
(3, 2, 'Apresentação para Investidores', 'Template profissional para pitch de investimento'),
(4, 2, 'Portfólio de Produtos', 'Template para showcase de produtos ou serviços'),
(5, 3, 'Pitch Deck Startup', 'Apresentação especializada');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nome`, `email`, `senha`, `data_criacao`) VALUES
(1, 'Nome', 'nome@gmail.com', '$2y$10$/jLaSjrZ6I7YcNz.mAMloeIER9i7cLmCrlD5mxuZLRSCn4n623B3q', '2025-09-18 00:11:25'),
(2, 'c', 'c@gmail.com', '$2y$10$YtLOT/w1sb1UdxXUyoYXQur.6q83rbTFD8T9euZNqQQHCloQmC6nG', '2025-09-18 00:12:56'),
(3, 'nome', 'nome1@gmail.com', '$2y$10$DbRIdRsaRg.zE8AJovwmku9CEE9a4CEHW2OapavqE1AOLxbfqLB/u', '2025-09-26 05:18:13');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `ferramenta`
--
ALTER TABLE `ferramenta`
  ADD PRIMARY KEY (`id_ferramenta`);

--
-- Índices para tabela `ideia`
--
ALTER TABLE `ideia`
  ADD PRIMARY KEY (`id_ideia`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices para tabela `ideia_ferramenta`
--
ALTER TABLE `ideia_ferramenta`
  ADD PRIMARY KEY (`id_ideia`,`id_ferramenta`),
  ADD KEY `id_ferramenta` (`id_ferramenta`);

--
-- Índices para tabela `tarefa`
--
ALTER TABLE `tarefa`
  ADD PRIMARY KEY (`id_tarefa`),
  ADD KEY `id_ideia` (`id_ideia`);

--
-- Índices para tabela `template`
--
ALTER TABLE `template`
  ADD PRIMARY KEY (`id_template`),
  ADD KEY `id_ferramenta` (`id_ferramenta`);

--
-- Índices para tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de tabelas despejadas
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
  MODIFY `id_ideia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `ideia`
--
ALTER TABLE `ideia`
  ADD CONSTRAINT `ideia_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `ideia_ferramenta`
--
ALTER TABLE `ideia_ferramenta`
  ADD CONSTRAINT `ideia_ferramenta_ibfk_1` FOREIGN KEY (`id_ideia`) REFERENCES `ideia` (`id_ideia`) ON DELETE CASCADE,
  ADD CONSTRAINT `ideia_ferramenta_ibfk_2` FOREIGN KEY (`id_ferramenta`) REFERENCES `ferramenta` (`id_ferramenta`);

--
-- Limitadores para a tabela `tarefa`
--
ALTER TABLE `tarefa`
  ADD CONSTRAINT `tarefa_ibfk_1` FOREIGN KEY (`id_ideia`) REFERENCES `ideia` (`id_ideia`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `template`
--
ALTER TABLE `template`
  ADD CONSTRAINT `template_ibfk_1` FOREIGN KEY (`id_ferramenta`) REFERENCES `ferramenta` (`id_ferramenta`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
