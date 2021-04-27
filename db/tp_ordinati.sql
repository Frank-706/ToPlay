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
-- Struttura della tabella `tp_ordinati`
--

CREATE TABLE IF NOT EXISTS `tp_ordinati` (
  `pk` int(11) NOT NULL AUTO_INCREMENT,
  `qta` int(11) NOT NULL,
  `fk_ordini` int(11) NOT NULL,
  `fk_articoli` int(11) NOT NULL,
  `prezzo_vend` decimal(6,2) NOT NULL,
  PRIMARY KEY (`pk`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dump dei dati per la tabella `tp_ordinati`
--

INSERT INTO `tp_ordinati` (`pk`, `qta`, `fk_ordini`, `fk_articoli`, `prezzo_vend`) VALUES
(1, 4, 1, 1, '2003.56'),
(2, 2, 4, 1, '200.00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
