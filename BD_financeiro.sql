-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 11/04/2026 às 01:51
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
-- Banco de dados: `bd_financeiro`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `forma_pagamento`
--

CREATE TABLE `forma_pagamento` (
  `id_forma_pagamento` int(11) NOT NULL,
  `descricao` varchar(30) DEFAULT NULL,
  `ind_excluido` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `forma_pagamento`
--

INSERT INTO `forma_pagamento` (`id_forma_pagamento`, `descricao`, `ind_excluido`) VALUES
(1, 'Cartão de crédito', 0),
(2, 'Cartão de débito', 0),
(3, 'Pix', 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `movimentacao`
--

CREATE TABLE `movimentacao` (
  `id_movimentacao` int(11) NOT NULL,
  `id_tipo_despesa` int(11) NOT NULL,
  `id_forma_pagamento` int(11) NOT NULL,
  `tipo_movimentacao` varchar(1) DEFAULT NULL,
  `valor` float DEFAULT NULL,
  `data` date DEFAULT NULL,
  `observacao` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `movimentacao`
--

INSERT INTO `movimentacao` (`id_movimentacao`, `id_tipo_despesa`, `id_forma_pagamento`, `tipo_movimentacao`, `valor`, `data`, `observacao`) VALUES
(1, 3, 3, 'e', 150, '2026-04-10', 'teste'),
(3, 3, 1, 'e', 379, '2026-04-18', 'Testee');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tipo_despesa`
--

CREATE TABLE `tipo_despesa` (
  `ID_TIPO_DESPESA` int(11) NOT NULL,
  `DESCRICAO` varchar(30) DEFAULT NULL,
  `IND_EXCLUIDO` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tipo_despesa`
--

INSERT INTO `tipo_despesa` (`ID_TIPO_DESPESA`, `DESCRICAO`, `IND_EXCLUIDO`) VALUES
(3, 'Mercado', 0);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `forma_pagamento`
--
ALTER TABLE `forma_pagamento`
  ADD PRIMARY KEY (`id_forma_pagamento`);

--
-- Índices de tabela `movimentacao`
--
ALTER TABLE `movimentacao`
  ADD PRIMARY KEY (`id_movimentacao`),
  ADD KEY `id_tipo_despesa` (`id_tipo_despesa`),
  ADD KEY `id_forma_pagamento` (`id_forma_pagamento`);

--
-- Índices de tabela `tipo_despesa`
--
ALTER TABLE `tipo_despesa`
  ADD PRIMARY KEY (`ID_TIPO_DESPESA`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `forma_pagamento`
--
ALTER TABLE `forma_pagamento`
  MODIFY `id_forma_pagamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `movimentacao`
--
ALTER TABLE `movimentacao`
  MODIFY `id_movimentacao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `tipo_despesa`
--
ALTER TABLE `tipo_despesa`
  MODIFY `ID_TIPO_DESPESA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `movimentacao`
--
ALTER TABLE `movimentacao`
  ADD CONSTRAINT `movimentacao_ibfk_1` FOREIGN KEY (`id_tipo_despesa`) REFERENCES `tipo_despesa` (`ID_TIPO_DESPESA`),
  ADD CONSTRAINT `movimentacao_ibfk_2` FOREIGN KEY (`id_forma_pagamento`) REFERENCES `forma_pagamento` (`id_forma_pagamento`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
