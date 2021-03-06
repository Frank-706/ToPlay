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
-- Struttura della tabella `tp_ordini`
--

CREATE TABLE IF NOT EXISTS `tp_ordini` (
  `pk` int(11) NOT NULL AUTO_INCREMENT,
  `dt` bigint(20) DEFAULT NULL,
  `nro` int(11) NOT NULL,
  `is_annullato` tinyint(1) NOT NULL DEFAULT '0',
  `fk_utenti` int(11) NOT NULL,
  PRIMARY KEY (`pk`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=45 ;

--
-- Dump dei dati per la tabella `tp_ordini`
--

INSERT INTO `tp_ordini` (`pk`, `dt`, `nro`, `is_annullato`, `fk_utenti`) VALUES
(1, 1615330800, 1, 0, 1),
(2, 1615935600, 2, 1, 2),
(3, 1616454000, 3, 0, 5),
(4, 1621634400, 4, 0, 2),
(41, 1621635186, 8, 0, 1),
(31, 1621634057, 6, 0, 1),
(40, 1621635174, 7, 0, 1),
(44, 1621636411, 11, 0, 1),
(29, 1621633808, 5, 0, 1),
(42, 1621635240, 9, 0, 1),
(43, 1621635370, 10, 0, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
