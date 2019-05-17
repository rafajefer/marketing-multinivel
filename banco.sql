-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: 17-Maio-2019 às 13:32
-- Versão do servidor: 5.7.24
-- versão do PHP: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projeto_mmn`
--
CREATE DATABASE IF NOT EXISTS `projeto_mmn` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `projeto_mmn`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `patentes`
--

DROP TABLE IF EXISTS `patentes`;
CREATE TABLE IF NOT EXISTS `patentes` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `min` int(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `patentes`
--

INSERT INTO `patentes` (`id`, `nome`, `min`) VALUES
(1, 'Iniciante', 0),
(2, 'Junior', 1),
(3, 'Diretor Pleno', 3),
(4, 'Diretor Sênior', 5),
(5, 'Executivo', 10);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pai` int(11) DEFAULT NULL,
  `patente` int(2) NOT NULL DEFAULT '1',
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(32) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `id_pai`, `patente`, `nome`, `email`, `senha`, `created_at`, `updated_at`) VALUES
(1, NULL, 4, 'Sistema', 'sistema@gmail.com', '202cb962ac59075b964b07152d234b70', '2019-05-16 15:29:47', '2019-05-17 13:21:21'),
(3, 1, 2, 'Rafael Jeferson', 'rafa.jefer@gmail.com', '202cb962ac59075b964b07152d234b70', '2019-05-16 16:44:47', '2019-05-17 13:25:01'),
(4, 1, 4, 'Cicrano', 'cicrano@gmail.com', '202cb962ac59075b964b07152d234b70', '2019-05-16 17:22:04', '2019-05-17 13:25:01'),
(5, 4, 3, 'Paulo', 'paulo@gmail.com', '202cb962ac59075b964b07152d234b70', '2019-05-16 17:22:42', '2019-05-17 13:25:01'),
(6, 4, 1, 'Pedro', 'pedro@gmail.com', '202cb962ac59075b964b07152d234b70', '2019-05-16 17:22:49', '2019-05-17 13:25:01'),
(7, 5, 2, 'João', 'joao@gmail.com', '202cb962ac59075b964b07152d234b70', '2019-05-16 17:23:50', '2019-05-17 13:25:01'),
(8, 7, 2, 'Pedrinho', 'pedrinho@gmail.com', '202cb962ac59075b964b07152d234b70', '2019-05-16 17:24:11', '2019-05-17 13:25:01'),
(9, 8, 1, 'Roberto', 'roberto@gmail.com', '202cb962ac59075b964b07152d234b70', '2019-05-16 17:24:54', '2019-05-17 13:25:01'),
(10, 3, 1, 'Angela angelica', 'angel.angelique.oliveira@gmail.com', '202cb962ac59075b964b07152d234b70', '2019-05-16 21:46:06', '2019-05-17 13:25:01'),
(11, 5, 1, 'Paula', 'paula@gmail.com', '202cb962ac59075b964b07152d234b70', '2019-05-16 22:12:01', '2019-05-17 13:25:01');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
