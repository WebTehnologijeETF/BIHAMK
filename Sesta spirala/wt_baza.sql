-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2015 at 10:47 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `wt_baza`
--

-- --------------------------------------------------------

--
-- Table structure for table `komentari`
--

CREATE TABLE IF NOT EXISTS `komentari` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datum` timestamp NOT NULL,
  `autor` varchar(50) COLLATE utf8_slovenian_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_slovenian_ci NOT NULL,
  `tekst` varchar(500) COLLATE utf8_slovenian_ci NOT NULL,
  `novost` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `novost` (`novost`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=12 ;

--
-- Dumping data for table `komentari`
--

INSERT INTO `komentari` (`id`, `datum`, `autor`, `email`, `tekst`, `novost`) VALUES
(1, '2015-05-18 12:53:41', 'Anonimni autor1', 'anonimus1@test.ba', 'Ovo je vrlo neugodna informacija. Nadam se da će stvari biti bolje.', 1),
(2, '2015-05-18 12:53:41', 'Anonimni autor2', '', 'Nemam komentara.', 1);

-- --------------------------------------------------------

--
-- Table structure for table `korisnici`
--

CREATE TABLE IF NOT EXISTS `korisnici` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8_slovenian_ci NOT NULL,
  `password` varchar(50) COLLATE utf8_slovenian_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_slovenian_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `korisnici`
--

INSERT INTO `korisnici` (`id`, `username`, `password`, `email`) VALUES
(1, 'edincongo', 'adminpassword', 'econgo1@etf.unsa.ba'),
(4, 'testkorisnik', 'CGHyAZgxmu', 'test@test.ba');

-- --------------------------------------------------------

--
-- Table structure for table `novosti`
--

CREATE TABLE IF NOT EXISTS `novosti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datum` timestamp NOT NULL,
  `autor` varchar(50) COLLATE utf8_slovenian_ci NOT NULL,
  `naslov` varchar(50) COLLATE utf8_slovenian_ci NOT NULL,
  `slika` varchar(100) COLLATE utf8_slovenian_ci NOT NULL,
  `osnovniTekst` varchar(250) COLLATE utf8_slovenian_ci NOT NULL,
  `detaljniTekst` varchar(2500) COLLATE utf8_slovenian_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=15 ;

--
-- Dumping data for table `novosti`
--

INSERT INTO `novosti` (`id`, `datum`, `autor`, `naslov`, `slika`, `osnovniTekst`, `detaljniTekst`) VALUES
(1, '2015-05-17 18:56:37', 'Edin Čongo', 'M4 Radovi na putu', 'http://3.imimg.com/data3/VO/XH/MY-3971701/road-construction-work-service-250x250.jpg', 'Radovi na putu m4 Zenica - Tuzla', 'Trenutno se saobraćaj odvija otežano u oba pravca. Molimo vozače na dodatni oprez i smirenost. Radovi će se odvijati u 3 smjene.'),
(2, '2015-05-18 08:04:18', 'Edin Čongo', 'M5 Radovi na putevima', 'http://3.imimg.com/data3/VO/XH/MY-3971701/road-construction-work-service-250x250.jpg', 'Radovi na putu m4 Zenica - Tuzla - Sarajevo', 'Poteškoće u saobraćaju. Trenutno se saobraćaj odvija otežano u oba pravca. Molimo vozače na dodatni oprez i smirenost. Radovi će se odvijati u 3 smjene.'),
(3, '2015-05-27 18:18:39', 'Edin Čongo3', 'M17 Udes3', 'http://3.imimg.com/data3/VO/XH/MY-3971701/road-construction-work-service-250x250.jpg', '3Usljed saobraćanje nezgode, saobraćaj se odvija usporeno.', '3Poteškoće u saobraćaju. Trenutno se saobraćaj odvija otežano u oba pravca. Molimo vozače na dodatni oprez i smirenost. MUP KS obavlja uviđaj.'),
(14, '2015-05-28 14:16:28', 'Edin Čongoć č Ć Č &scaron; &Scaron; đ Đ ž Ž', 'Saobracajna nezgoda ć č Ć Č &scaron; &Scaron; đ Đ ', 'http://3.imimg.com/data3/VO/XH/MY-3971701/road-construction-work-service-250x250.jpg', 'Desila se nezgoda ć č Ć Č &scaron; &Scaron; đ Đ ž Ž', 'Desila se nezgoda ć č Ć Č &scaron; &Scaron; đ Đ ž Ž');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `komentari`
--
ALTER TABLE `komentari`
  ADD CONSTRAINT `komentari_ibfk_1` FOREIGN KEY (`novost`) REFERENCES `novosti` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
