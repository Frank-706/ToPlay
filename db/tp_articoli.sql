-- phpMyAdmin SQL Dump
-- version 4.1.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 27, 2021 alle 22:28
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
-- Struttura della tabella `tp_articoli`
--

CREATE TABLE IF NOT EXISTS `tp_articoli` (
  `pk` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) CHARACTER SET utf8 NOT NULL,
  `prezzo_cata` decimal(6,2) NOT NULL,
  `is_visibile` tinyint(1) NOT NULL,
  `qta` int(11) NOT NULL,
  `codice` varchar(50) CHARACTER SET utf8 NOT NULL,
  `descrizione` text CHARACTER SET utf8 NOT NULL,
  `fk_sottocategorie` int(11) NOT NULL,
  PRIMARY KEY (`pk`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dump dei dati per la tabella `tp_articoli`
--

INSERT INTO `tp_articoli` (`pk`, `nome`, `prezzo_cata`, `is_visibile`, `qta`, `codice`, `descrizione`, `fk_sottocategorie`) VALUES
(1, 'Samsung-3000', '500.89', 1, 66, 'A3456D', 'de', 1),
(2, 'AirForce1-black', '111.99', 0, 21, 'SES5643E', 'sono belle ma costrano troppo', 2),
(3, 'LG-250', '622.99', 1, 10, '12TUOPATRCE231', 'lavatrice lg molto costosa', 1),
(4, 'Timberlup', '100.00', 1, 22, 'ESTERREFATTO123', 'le scarpe di Jack Torrance', 2),
(5, 'ciao', '23.00', 0, 13, 'gbfed23xsww', 'dsdscs', 5),
(14, 'ee', '11.88', 0, 6, 'wezrxdfcghf', 'fds', 1),
(21, 'dff', '100.00', 0, 2, 'CIAOss', '000', 6),
(13, 'GY-98', '35.89', 0, 12, 'fsz', 'we', 2),
(20, 'qualcosa', '12.00', 0, 11, 'rdgdxg', 'wwe', 4);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
