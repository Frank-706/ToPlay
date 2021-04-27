-- phpMyAdmin SQL Dump
-- version 4.1.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 27, 2021 alle 22:27
-- Versione del server: 5.6.33-log
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `my_frankmoses`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `tp_categorie`
--

CREATE TABLE IF NOT EXISTS `tp_categorie` (
  `pk` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(20) CHARACTER SET utf8 NOT NULL,
  `is_visibile` tinyint(1) NOT NULL,
  PRIMARY KEY (`pk`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dump dei dati per la tabella `tp_categorie`
--

INSERT INTO `tp_categorie` (`pk`, `nome`, `is_visibile`) VALUES
(1, 'elettrodomestici', 1),
(2, 'abbigliamento', 1),
(3, 'libri', 0),
(4, 'pesca', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
