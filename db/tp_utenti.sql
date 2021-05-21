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
-- Struttura della tabella `tp_utenti`
--

CREATE TABLE IF NOT EXISTS `tp_utenti` (
  `pk` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(20) CHARACTER SET utf8 NOT NULL,
  `cognome` varchar(20) CHARACTER SET utf8 NOT NULL,
  `email` varchar(40) CHARACTER SET utf8 NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 NOT NULL,
  `cf` varchar(16) CHARACTER SET utf8 NOT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `registrazione` varchar(32) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`pk`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Dump dei dati per la tabella `tp_utenti`
--

INSERT INTO `tp_utenti` (`pk`, `nome`, `cognome`, `email`, `password`, `cf`, `is_enabled`, `registrazione`) VALUES
(1, 'francesco', 'di nisio', 'ciccio.caputo@gmail.com', '6e6bc4e49dd477ebc98ef4046c067b5f', 'A5HDHDHE', 1, '$nome'),
(2, 'luca', 'dad', 'luca@gmail.com', '5d41402abc4b2a76b9719d911017c592', 'YASDFESABKF', 1, NULL),
(3, 'pablito', 'is', 'pablo@hotmail.it', '202447d5d44ce12531f7207cb33b6bf7', 'DLSDBSD33', 0, 'zitto'),
(4, 'GIGIO', 'dead', 'piero@opera.com', 'a836357d6d40a1fccaa32798fc997d60', 'GYUUGDS', 1, NULL),
(5, 'roberto', 'agliocchi', 'agliocchi@gmail.com', '6e6bc4e49dd477ebc98ef4046c067b5f', 'lollo', 0, NULL),
(6, 'germano', 'mosconi', 'nazionale@gmail.com', '6e6bc4e49dd477ebc98ef4046c067b5f', 'YDHZSDS', 0, NULL),
(7, 'CIAO', 'IIO', 'LOLDSBHa@gmail.com', '6e6bc4e49dd477ebc98ef4046c067b5f', 'ford', 0, NULL),
(8, 'William', 'Occhiocupo', 'william@gg.com', '6e6bc4e49dd477ebc98ef4046c067b5f', 'EEP', 1, 'dc'),
(9, 'john', 'smith', 'john@smit.com', 'e034fb6b66aacc1d48f445ddfb08da98', '1111', 0, NULL),
(10, 'luigi', 'di maio', 'm@gg.com', '6e6bc4e49dd477ebc98ef4046c067b5f', 'GUHBINJ', 0, NULL),
(11, '5', 'fff', 'ye5424279@gmail.com', '6e6bc4e49dd477ebc98ef4046c067b5f', 'TFYGUYHIJO', 0, NULL),
(27, 'franko', 'rossi', 'francescofulvio.dn@libero.it', '6e6bc4e49dd477ebc98ef4046c067b5f', 'EEE', 0, '1');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
