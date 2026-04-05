-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 03-04-2026 a las 14:15:29
-- Versión del servidor: 9.1.0
-- Versión de PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `combustible`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargas`
--
DROP TABLE IF EXISTS `cargas`;
CREATE TABLE IF NOT EXISTS `cargas` (
  `id_carga` int NOT NULL AUTO_INCREMENT,
  `fecha` date DEFAULT NULL,
  `kilometraje` double DEFAULT NULL,
  `litros` double DEFAULT NULL,
  `precio_total` double DEFAULT NULL,
  `id_vehiculo` int DEFAULT NULL,
  `id_surtidor` int DEFAULT NULL,
  PRIMARY KEY (`id_carga`),
  KEY `id_vehiculo` (`id_vehiculo`),
  KEY `id_surtidor` (`id_surtidor`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
--
-- Volcado de datos para la tabla `cargas`
--

INSERT INTO `cargas` (`id_carga`, `fecha`, `kilometraje`, `litros`, `precio_total`, `id_vehiculo`, `id_surtidor`) VALUES
(1, '2026-04-03', 20, 10, 70, 1, 1),
(2, '2026-04-06', 35, 10, 70, 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `surtidores`
--

DROP TABLE IF EXISTS `surtidores`;
CREATE TABLE IF NOT EXISTS `surtidores` (
  `id_surtidor` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `ubicacion` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_surtidor`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `surtidores`
--

INSERT INTO `surtidores` (`id_surtidor`, `nombre`, `ubicacion`) VALUES
(1, 'Beigin', 'Cochabamba'),
(2, 'Cristo Concordia', 'Cochabamba');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos`
--

DROP TABLE IF EXISTS `vehiculos`;
CREATE TABLE IF NOT EXISTS `vehiculos` (
  `id_vehiculo` int NOT NULL AUTO_INCREMENT,
  `placa` varchar(20) DEFAULT NULL,
  `modelo` varchar(50) DEFAULT NULL,
  `tipo_combustible` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_vehiculo`),
  UNIQUE KEY `placa` (`placa`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `vehiculos`
--

INSERT INTO `vehiculos` (`id_vehiculo`, `placa`, `modelo`, `tipo_combustible`) VALUES
(1, 'HDK2034', 'Nissan', 'Gasolina 95');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
