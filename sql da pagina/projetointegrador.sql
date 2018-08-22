-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: 19-Nov-2017 às 01:37
-- Versão do servidor: 5.7.19
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projetointegrador`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `administrador`
--

DROP TABLE IF EXISTS `administrador`;
CREATE TABLE IF NOT EXISTS `administrador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(120) DEFAULT NULL,
  `senha` varchar(120) DEFAULT NULL,
  `ativo` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `administrador`
--

INSERT INTO `administrador` (`id`, `email`, `senha`, `ativo`) VALUES
(1, 'pauljalmeida@gmail.com', '180904', '1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria`
--

DROP TABLE IF EXISTS `categoria`;
CREATE TABLE IF NOT EXISTS `categoria` (
  `id_categoria` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(120) DEFAULT NULL,
  PRIMARY KEY (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `categoria`
--

INSERT INTO `categoria` (`id_categoria`, `nome`) VALUES
(1, 'ttttt alterado caraio'),
(2, 'Iluminação'),
(4, 'pisos'),
(6, 'aberturas'),
(7, 'Tintas'),
(8, 'Material bruto'),
(9, 'teste');

-- --------------------------------------------------------

--
-- Estrutura da tabela `clientes`
--

DROP TABLE IF EXISTS `clientes`;
CREATE TABLE IF NOT EXISTS `clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(120) NOT NULL,
  `email` varchar(120) NOT NULL,
  `descricao` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `clientes`
--

INSERT INTO `clientes` (`id`, `nome`, `email`, `descricao`) VALUES
(2, 'giovanna', 'gigi@gigi', '<p>filha linda&nbsp;<img alt=\"cheeky\" src=\"http://cdn.ckeditor.com/4.7.1/full/plugins/smiley/images/tongue_smile.png\" style=\"height:23px; width:23px\" title=\"cheeky\" /><img alt=\"\" src=\"C:\\Users\\Paul\\Desktop\" /></p>\r\n'),
(3, 'Micheli', 'micheli@micheli.com.br', '<p><span style=\"color:#c0392b\"><img alt=\"heart\" src=\"http://cdn.ckeditor.com/4.7.1/full/plugins/smiley/images/heart.png\" style=\"height:23px; width:23px\" title=\"heart\" />minha esposa</span></p>\r\n'),
(4, 'Heitor', 'heitor@heitor.com.br', '<p>bebez&atilde;o<img alt=\"smiley\" src=\"http://cdn.ckeditor.com/4.7.1/full/plugins/smiley/images/regular_smile.png\" style=\"height:23px; width:23px\" title=\"smiley\" /></p>\r\n'),
(5, 'Micheli Giovanna Heitor', 'casa@casa.com.br', '<p>dg;jnzkxl;ksz<img alt=\"heart\" src=\"http://cdn.ckeditor.com/4.7.1/full/plugins/smiley/images/heart.png\" style=\"height:23px; width:23px\" title=\"heart\" /></p>\r\n');

-- --------------------------------------------------------

--
-- Estrutura da tabela `conteudos_site`
--

DROP TABLE IF EXISTS `conteudos_site`;
CREATE TABLE IF NOT EXISTS `conteudos_site` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(120) DEFAULT NULL,
  `html` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `duvida`
--

DROP TABLE IF EXISTS `duvida`;
CREATE TABLE IF NOT EXISTS `duvida` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(120) DEFAULT NULL,
  `telefone` varchar(40) DEFAULT NULL,
  `email` varchar(120) DEFAULT NULL,
  `duvida` text,
  `id_produto` int(11) DEFAULT NULL,
  `id_tipoduvida` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_produto` (`id_produto`),
  KEY `id_tipoduvida` (`id_tipoduvida`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `duvida`
--

INSERT INTO `duvida` (`id`, `nome`, `telefone`, `email`, `duvida`, `id_produto`, `id_tipoduvida`) VALUES
(1, 'Paul Jackson', '47 - 999312598', 'pauljalmeida@gmail.com', 'teste', 1, 1),
(2, 'Daniel', '969696969', 'dsads@dsfdf.co', 'ei lindeza', NULL, 4),
(3, 'Daniel', '6969696969', 'dsads@dsfdf.co', 'ei lindeza', NULL, 4),
(4, 'skhdsfskhk', 'sdkfhsdfkjh', 'ksdfhsdkfh', 'sdfsdkfh', NULL, 2),
(5, 'adfjsdhkfhs', 'kdfhsdkfh', 'ksfhsdfkhk', 'sdfsdfkh', NULL, 2),
(6, 'joao', '47999999999', 'joao@bobo', 'eu to com duvida', NULL, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

DROP TABLE IF EXISTS `produtos`;
CREATE TABLE IF NOT EXISTS `produtos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` text,
  `nome_produto` varchar(120) DEFAULT NULL,
  `imagem` varchar(120) DEFAULT NULL,
  `id_categoria` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_categoria` (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`id`, `descricao`, `nome_produto`, `imagem`, `id_categoria`) VALUES
(1, 'Com o passar dos dias verifiquei a necessidade de abrir um glossário de itens mais usados na área da construção civil e para reforma, onde as pessoas leigas (não profissionais) adquirem um produto e não sabe a finalidade correta do mesmo, e também uma forma mais clara de mostrar para o profissional da área as atualizações desses mesmos.  Contudo gerando satisfação e gerando menos trocas e devoluções por não saber a maneira correta de usar e também não acreditar no seu profissional quando indica um produto por ele ter o melhor desempenho. Nesse glossário vou mostrar para que serve cada item, como usar e em que área é a melhor maneira de utilizar', 'teste', 'imagem', 1),
(2, 'teste 2 com banco', 'tinta suvinil', 'asadsdas', 2),
(3, 'teste outro', 'maquina', 'wqwqwqw', 1),
(5, 'nszczxc', 'wu', 'WIN_20160311_19_28_28_Pro.jpg', 1),
(6, 'nszczxc', 'wu', 'WIN_20160311_19_28_28_Pro.jpg', 1),
(7, 'zxczxczxc', 'zczxczxcz', 'WIN_20160311_19_28_28_Pro.jpg', 1),
(8, '<p>dskdjas</p>\r\n', 'tatatata', NULL, 1),
(9, '<p>testando</p>\r\n', 'balaroti', NULL, 6),
(10, '<p>serve para descansar</p>\r\n', 'rede', NULL, 2),
(11, '<p>fsdfvxv nfythbibniukm tyuerytd</p>\r\n', 'asasasas', NULL, 4);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipo_duvida`
--

DROP TABLE IF EXISTS `tipo_duvida`;
CREATE TABLE IF NOT EXISTS `tipo_duvida` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(120) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tipo_duvida`
--

INSERT INTO `tipo_duvida` (`id`, `nome`) VALUES
(1, 'duvida'),
(2, 'critica'),
(3, 'sugestão'),
(4, 'elogio');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) DEFAULT NULL,
  `senha` varchar(32) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`user_id`, `nome`, `senha`) VALUES
(1, 'aaaa', 'aaaa'),
(2, 'paul', '1234'),
(3, '', ''),
(4, '', ''),
(5, '', ''),
(6, '', ''),
(7, '', ''),
(8, 'jack', '1234'),
(9, 'rogerio', '1234');

-- --------------------------------------------------------

--
-- Estrutura da tabela `visitas`
--

DROP TABLE IF EXISTS `visitas`;
CREATE TABLE IF NOT EXISTS `visitas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_produto` int(11) DEFAULT NULL,
  `contador_de_visitas` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_produto` (`id_produto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `duvida`
--
ALTER TABLE `duvida`
  ADD CONSTRAINT `duvida_ibfk_1` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id`),
  ADD CONSTRAINT `duvida_ibfk_2` FOREIGN KEY (`id_tipoduvida`) REFERENCES `tipo_duvida` (`id`);

--
-- Limitadores para a tabela `produtos`
--
ALTER TABLE `produtos`
  ADD CONSTRAINT `produtos_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_categoria`);

--
-- Limitadores para a tabela `visitas`
--
ALTER TABLE `visitas`
  ADD CONSTRAINT `visitas_ibfk_1` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
