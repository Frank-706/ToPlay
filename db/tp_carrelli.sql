-- phpMyAdmin SQL Dump
-- version 4.1.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mag 22, 2021 alle 00:33
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
-- Struttura della tabella `tp_carrelli`
--

CREATE TABLE IF NOT EXISTS `tp_carrelli` (
  `pk` int(11) NOT NULL AUTO_INCREMENT,
  `fk_utenti` int(11) DEFAULT NULL,
  `fk_articoli` int(11) DEFAULT NULL,
  `qta` int(11) DEFAULT '1',
  `dt` bigint(20) DEFAULT NULL,
  `prezzo_vend` decimal(10,2) NOT NULL,
  PRIMARY KEY (`pk`),
  UNIQUE KEY `fk_utenti` (`fk_utenti`,`fk_articoli`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=51 ;

--
-- Dump dei dati per la tabella `tp_carrelli`
--

INSERT INTO `tp_carrelli` (`pk`, `fk_utenti`, `fk_articoli`, `qta`, `dt`, `prezzo_vend`) VALUES
(50, 1, 4, 1, 1621636411, '100.00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
