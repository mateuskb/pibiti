-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 11/02/2020 às 09:53
-- Versão do servidor: 5.7.26-0ubuntu0.18.04.1
-- Versão do PHP: 7.2.24-0ubuntu0.18.04.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `pibiti`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `equips`
--

CREATE TABLE `equips` (
  `equ_pk` int(11) NOT NULL,
  `qui_b_rele1` tinyint(1) NOT NULL DEFAULT '1',
  `qui_b_rele2` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `logins`
--

CREATE TABLE `logins` (
  `log_pk` int(11) NOT NULL,
  `log_fk_user` int(11) NOT NULL,
  `log_dt_acessado` timestamp NULL DEFAULT NULL,
  `log_dt_last_movement` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `usr_pk` int(11) NOT NULL,
  `usr_c_username` varchar(40) NOT NULL,
  `usr_c_hash` varchar(240) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Fazendo dump de dados para tabela `users`
--

INSERT INTO `users` (`usr_pk`, `usr_c_username`, `usr_c_hash`) VALUES
(1, 'teste', 'teste');

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `equips`
--
ALTER TABLE `equips`
  ADD PRIMARY KEY (`equ_pk`);

--
-- Índices de tabela `logins`
--
ALTER TABLE `logins`
  ADD PRIMARY KEY (`log_pk`),
  ADD KEY `log_fk_user` (`log_fk_user`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`usr_pk`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `equips`
--
ALTER TABLE `equips`
  MODIFY `equ_pk` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de tabela `logins`
--
ALTER TABLE `logins`
  MODIFY `log_pk` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `usr_pk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Restrições para dumps de tabelas
--

--
-- Restrições para tabelas `logins`
--
ALTER TABLE `logins`
  ADD CONSTRAINT `fk_login_user` FOREIGN KEY (`log_fk_user`) REFERENCES `users` (`usr_pk`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
