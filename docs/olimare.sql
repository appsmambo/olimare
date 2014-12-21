-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 28, 2014 at 09:52 AM
-- Server version: 5.5.23
-- PHP Version: 5.5.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `olimare`
--
CREATE DATABASE IF NOT EXISTS `olimare` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish2_ci;
USE `olimare`;

-- --------------------------------------------------------

--
-- Table structure for table `estudiante`
--

CREATE TABLE IF NOT EXISTS `estudiante` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `institucion` int(11) NOT NULL,
  `codigo` char(6) NOT NULL,
  `ci` varchar(20) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `nivel` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `institucion` (`institucion`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `estudiante`
--

INSERT INTO `estudiante` (`id`, `institucion`, `codigo`, `ci`, `apellidos`, `nombres`, `nivel`) VALUES
(1, 14, 'CC2499', '12345678', 'chico', 'carlos eduardo', 'Octavo'),
(2, 14, 'DC3399', '12345678', 'de la cruz', 'carlos eduardo', 'Octavo');

-- --------------------------------------------------------

--
-- Table structure for table `institucion`
--

CREATE TABLE IF NOT EXISTS `institucion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `codigo` varchar(20) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `pais` varchar(2) NOT NULL,
  `provincia` varchar(20) NOT NULL,
  `canton` varchar(20) DEFAULT NULL,
  `ciudad` varchar(20) DEFAULT NULL,
  `direccion` varchar(100) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `referencia_deposito` varchar(100) NOT NULL,
  `banco` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `institucion`
--

INSERT INTO `institucion` (`id`, `fecha_registro`, `codigo`, `nombre`, `pais`, `provincia`, `canton`, `ciudad`, `direccion`, `telefono`, `email`, `referencia_deposito`, `banco`) VALUES
(13, '2014-03-31 08:01:23', '00001', 'Colegio Santa Mariana', 'EC', 'Azuay', '', '', 'Calle Mamacona 105', '12345678', 'zoilahilda@hotmail.com', '12385296301247', 'BBVA'),
(14, '2014-03-31 08:13:49', '00002', 'Colegio Santa Mariana', 'EC', 'Azuay', '', '', 'Calle Mamacona 105', '12345678', 'zoilahilda@hotmail.com', '12385296301247', 'BBVA');

-- --------------------------------------------------------

--
-- Table structure for table `representante`
--

CREATE TABLE IF NOT EXISTS `representante` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `institucion` int(11) NOT NULL,
  `cargo` varchar(20) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `ci` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `institucion` (`institucion`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `representante`
--

INSERT INTO `representante` (`id`, `institucion`, `cargo`, `nombre`, `ci`, `email`, `telefono`) VALUES
(1, 13, 'Director', 'Juan Carlos', '41363363', 'vambro@gmail.com', '123465789'),
(2, 14, 'Director', 'Juan Carlos', '41363363', 'vambro@gmail.com', '123465789');

-- --------------------------------------------------------

--
-- Table structure for table `tutor`
--

CREATE TABLE IF NOT EXISTS `tutor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `institucion` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `nivel` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `institucion` (`institucion`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tutor`
--

INSERT INTO `tutor` (`id`, `institucion`, `nombre`, `nivel`) VALUES
(1, 13, 'Docente 1', 'Séptimo'),
(2, 14, 'Docente 1', 'Séptimo');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `estudiante`
--
ALTER TABLE `estudiante`
  ADD CONSTRAINT `estudiante_ibfk_1` FOREIGN KEY (`institucion`) REFERENCES `institucion` (`id`);

--
-- Constraints for table `representante`
--
ALTER TABLE `representante`
  ADD CONSTRAINT `representante_ibfk_1` FOREIGN KEY (`institucion`) REFERENCES `institucion` (`id`);

--
-- Constraints for table `tutor`
--
ALTER TABLE `tutor`
  ADD CONSTRAINT `tutor_ibfk_1` FOREIGN KEY (`institucion`) REFERENCES `institucion` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
