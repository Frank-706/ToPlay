-- phpMyAdmin SQL Dump
-- version 4.1.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mag 22, 2021 alle 00:36
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
-- Struttura della tabella `tp_sottocategorie`
--

CREATE TABLE IF NOT EXISTS `tp_sottocategorie` (
  `pk` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(20) CHARACTER SET utf8 NOT NULL,
  `is_visibile` tinyint(1) NOT NULL,
  `fk_categorie` int(11) NOT NULL,
  PRIMARY KEY (`pk`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dump dei dati per la tabella `tp_sottocategorie`
--

INSERT INTO `tp_sottocategorie` (`pk`, `nome`, `is_visibile`, `fk_categorie`) VALUES
(1, 'lavatrici', 1, 1),
(2, 'scarpe', 1, 2),
(3, 'fumetti', 1, 3),
(4, 'horror', 1, 3),
(5, 'fantasy', 1, 3),
(6, 'zitto', 0, 4),
(7, 'fiat', 0, 5);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
