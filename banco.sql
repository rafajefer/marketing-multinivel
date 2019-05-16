-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: 16-Maio-2019 às 22:46
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
(1, NULL, 1, 'Sistema', 'sistema@gmail.com', '202cb962ac59075b964b07152d234b70', '2019-05-16 15:29:47', NULL),
(3, 1, 1, 'Rafael Jeferson', 'rafa.jefer@gmail.com', '93f1ff51f13ab30bcecf3d81093e242b', '2019-05-16 16:44:47', NULL),
(4, 1, 1, 'Cicrano', 'cicrano@gmail.com', 'b7f267b6c483a81d77427378c470ca82', '2019-05-16 17:22:04', NULL),
(5, 4, 1, 'Paulo', 'paulo@gmail.com', '6ee236e4d0ab7380bb1bee87b8f0dce5', '2019-05-16 17:22:42', NULL),
(6, 4, 1, 'Pedro', 'pedro@gmail.com', 'c3b7f393410fe6185ba5d966a213a38f', '2019-05-16 17:22:49', NULL),
(7, 5, 1, 'João', 'joao@gmail.com', 'e52d270281261b738fcd413c72d8ad4c', '2019-05-16 17:23:50', '2019-05-16 18:11:40'),
(8, 7, 1, 'Pedrinho', 'pedrinho@gmail.com', 'a9d0cf0bd640913b43b0b2d3b917765f', '2019-05-16 17:24:11', NULL),
(9, 8, 1, 'Roberto', 'roberto@gmail.com', '5f177272b67a69c573dc1de61c853157', '2019-05-16 17:24:54', NULL),
(10, 3, 1, 'Angela angelica', 'angel.angelique.oliveira@gmail.com', 'd06ac1f68b4cdc6d2a1210450451955b', '2019-05-16 21:46:06', NULL),
(11, 5, 1, 'Paula', 'paula@gmail.com', 'ef8501552d33f59a48310fc0c466a0ba', '2019-05-16 22:12:01', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
