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
-- Struttura della tabella `tp_admin`
--

CREATE TABLE IF NOT EXISTS `tp_admin` (
  `pk` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(20) CHARACTER SET utf8 NOT NULL,
  `cognome` varchar(20) CHARACTER SET utf8 NOT NULL,
  `is_enabled` tinyint(1) NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`pk`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dump dei dati per la tabella `tp_admin`
--

INSERT INTO `tp_admin` (`pk`, `nome`, `cognome`, `is_enabled`, `email`, `password`) VALUES
(1, 'pablito', 'di nisio', 1, 'pablito@whoopy.com', '6e6bc4e49dd477ebc98ef4046c067b5f'),
(2, 'roberto', 'agliocchi', 0, 'agliocchi@gmail.com', '16b5bb101392fac8b6264c8382cfa278'),
(3, 'Pineto', 'Lopez', 1, 'lopez@hotmail.com', '06229920d5b6da4cd4242f1d422321b3'),
(4, 'dd', 'fwsfs', 0, 'dfssdv@frfs', '5ad33864521cf3d985c03d7d2818a995');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
