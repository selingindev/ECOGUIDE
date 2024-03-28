-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 19/07/2023 às 00:44
-- Versão do servidor: 10.4.28-MariaDB
-- Versão do PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `ecoguide`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `agendamento`
--

CREATE TABLE `agendamento` (
  `id_agend` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `cep` varchar(50) DEFAULT NULL,
  `quant_resid` int(11) DEFAULT NULL,
  `data_coleta` date DEFAULT NULL,
  `cat_azul` int(11) NOT NULL DEFAULT 0,
  `cat_vermelho` int(11) NOT NULL DEFAULT 0,
  `cat_amarelo` int(11) NOT NULL DEFAULT 0,
  `cat_branco` int(11) NOT NULL DEFAULT 0,
  `flag_confirma` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `agendamento`
--

INSERT INTO `agendamento` (`id_agend`, `id_usuario`, `cep`, `quant_resid`, `data_coleta`, `cat_azul`, `cat_vermelho`, `cat_amarelo`, `cat_branco`, `flag_confirma`) VALUES
(1, 0, '06365310', 5, '2023-07-13', 0, 0, 0, 0, 1),
(2, 0, '1234578', 2, '2023-07-17', 0, 0, 0, 0, 0),
(3, 0, '98765-432', 2, '2023-07-09', 0, 0, 0, 0, 0),
(4, 0, '68901-140', 2, '2023-07-09', 0, 0, 0, 0, 0),
(5, 0, '76870-111', 2, '2023-07-09', 0, 0, 0, 0, 1),
(6, 0, '58078-240', 2, '2023-07-09', 0, 0, 0, 0, 0),
(7, 0, '76963-384', 2, '2023-07-09', 0, 0, 0, 0, 0),
(8, 0, '68911-143', 2, '2023-07-09', 0, 0, 0, 0, 1),
(9, 0, '88702-554', 2, '2023-07-09', 0, 0, 0, 0, 1),
(10, 0, '98765-4328', 2, '2023-07-09', 0, 0, 0, 0, 0),
(11, 0, '12345-678', 10, '2023-01-05', 0, 0, 0, 0, 0),
(12, 0, '98765-432', 5, '2023-02-10', 0, 0, 0, 0, 1),
(13, 0, '54321-876', 8, '2023-03-15', 0, 0, 0, 0, 1),
(14, 0, '23456-789', 15, '2023-04-20', 0, 0, 0, 0, 0),
(15, 0, '87654-321', 12, '2023-05-25', 0, 0, 0, 0, 1),
(16, 0, '67890-123', 7, '2023-06-30', 0, 0, 0, 0, 1),
(17, 0, '43210-987', 3, '2023-07-05', 0, 0, 0, 0, 0),
(18, 0, '98712-345', 9, '2023-08-10', 0, 0, 0, 0, 1),
(19, 0, '76543-210', 6, '2023-09-15', 0, 0, 0, 0, 0),
(20, 0, '32109-876', 11, '2023-10-20', 0, 0, 0, 0, 1),
(21, 0, '67890-123', 4, '2023-11-25', 0, 0, 0, 0, 0),
(22, 0, '34567-890', 13, '2023-12-30', 0, 0, 0, 0, 1),
(23, 0, '89012-345', 8, '2024-01-04', 0, 0, 0, 0, 1),
(24, 0, '10987-654', 6, '2024-02-09', 0, 0, 0, 0, 0),
(25, 0, '21098-765', 9, '2024-03-15', 0, 0, 0, 0, 1),
(26, 0, '56789-012', 14, '2024-04-20', 0, 0, 0, 0, 0),
(27, 0, '87654-321', 7, '2024-05-25', 0, 0, 0, 0, 1),
(28, 0, '12334', 122445, '2023-07-21', 1, 1, 1, 0, NULL),
(29, 0, '987654321', 10, '2023-07-31', 1, 0, 0, 0, NULL),
(30, 0, '206', 17, '2023-07-10', 0, 1, 1, 0, NULL),
(31, 0, '1972', 51, '2023-07-02', 0, 0, 0, 1, NULL),
(32, 0, '1998', 25, '2023-07-26', 1, 0, 0, 0, NULL),
(33, 0, '1971', 52, '2023-07-28', 1, 1, 1, 1, NULL),
(34, 0, '1997', 25, '2023-07-01', 0, 1, 0, 0, NULL),
(35, 0, '1234567', 7, '2023-07-25', 0, 0, 1, 0, NULL),
(36, 0, '1234567', 12, '2023-07-25', 0, 0, 0, 1, NULL),
(37, 0, '7777', 7, '2023-07-07', 1, 0, 0, 0, NULL),
(38, 0, '2222', 2, '2023-07-02', 0, 0, 0, 0, NULL),
(39, 0, '1234567', 7, '2023-07-17', 0, 0, 1, 0, NULL),
(40, 0, '123', 123, '2023-07-12', 0, 1, 0, 0, NULL),
(41, 0, '1213', 12, '2023-07-10', 1, 1, 1, 1, NULL),
(42, 0, '2006', 2006, '2023-07-26', 1, 1, 0, 0, NULL),
(43, 0, '1234567', 1234567, '2023-07-07', 0, 0, 0, 1, NULL),
(44, 0, '1', 1, '2023-07-01', 0, 1, 0, 0, NULL),
(45, 0, '2007', 7, '2023-07-07', 1, 0, 0, 0, NULL),
(46, 0, '1234', 1234, '2023-07-12', 0, 1, 0, 0, NULL),
(47, 0, '2006', 2006, '2023-07-26', 0, 0, 0, 1, NULL),
(48, 0, '322', 243, '2023-07-12', 0, 1, 0, 0, NULL),
(49, 6, '121', 132, '2023-07-12', 0, 1, 0, 0, NULL),
(50, 6, '12323', 2324, '2023-07-12', 0, 0, 0, 1, NULL),
(51, 1, '123', 2132, '2023-07-26', 0, 0, 1, 0, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(220) NOT NULL,
  `sobrenome` varchar(220) NOT NULL,
  `email` varchar(220) NOT NULL,
  `senha_usuario` varchar(220) NOT NULL,
  `chave_recuperar_senha` varchar(220) DEFAULT NULL,
  `codigo_autenticacao` int(11) DEFAULT NULL,
  `data_codigo_autenticacao` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `sobrenome`, `email`, `senha_usuario`, `chave_recuperar_senha`, `codigo_autenticacao`, `data_codigo_autenticacao`) VALUES
(1, 'Bianca', 'Almeida', 'biancalmds2006@gmail.com', '$2y$10$RzKQHVcbRoYGCXK7ULvzeuLP8Phr12PlLuUXad5hmHwahQM/u14x.', 'NULL', NULL, NULL),
(3, 'SIRLENE', 'SANTOS', 'SILENEALMEIDA37@GMAIL.COM', '$2y$10$6Rp5tUxOiMlmMMlw2vTr9O2LWzUiMDiCFOab.TSu74HgpDuOnPCba', 'NULL', NULL, NULL),
(5, 'Richard', 'Almeida da Silva', 'richard@gmail.com', '$2y$10$opHidJe.fKd6KVcAjJX5fu8cpPWVrVfNX1wzMkLV3xnU1.f1LNHxq', 'NULL', NULL, NULL),
(6, 'bibis', 'almeida', 'bianca2006@gmail.com', '$2y$10$mxJccH5T1/uiN0m08qmht.5TZ7RfqvNn/I370p3xubE74Lh1x/gre', NULL, NULL, NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `agendamento`
--
ALTER TABLE `agendamento`
  ADD PRIMARY KEY (`id_agend`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `agendamento`
--
ALTER TABLE `agendamento`
  MODIFY `id_agend` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
