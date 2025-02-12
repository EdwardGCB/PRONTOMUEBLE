-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-02-2025 a las 17:05:56
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `prontomueble`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Cliente`
--

CREATE TABLE `cliente` (
  `idCliente` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `apellido` varchar(45) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `identificacion` varchar(10) NOT NULL,
  `fechaCreacion` date NOT NULL,
  `Vendedor_idVendedor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Cliente`
--

INSERT INTO `Cliente` (`idCliente`, `nombre`, `apellido`, `correo`, `identificacion`, `fechaCreacion`, `Vendedor_idVendedor`) VALUES
(1, 'Juan', 'Pérez', 'juan.perez@example.com', '1234567890', '2024-02-09', 1),
(2, 'María', 'Gómez', 'maria.gomez@example.com', '0987654321', '2024-02-09', 2),
(3, 'Carlos', 'López', 'carlos.lopez@example.com', '1122334455', '2024-02-09', 1),
(4, 'Ana', 'Martínez', 'ana.martinez@example.com', '2233445566', '2024-02-09', 3),
(5, 'Pedro', 'Rodríguez', 'pedro.rodriguez@example.com', '3344556677', '2024-02-09', 2),
(6, 'Laura', 'Fernández', 'laura.fernandez@example.com', '4455667788', '2024-02-09', 3),
(7, 'Luis', 'Torres', 'luis.torres@example.com', '5566778899', '2024-02-09', 1),
(8, 'Sofía', 'Díaz', 'sofia.diaz@example.com', '6677889900', '2024-02-09', 2),
(9, 'Miguel', 'Hernández', 'miguel.hernandez@example.com', '7788990011', '2024-02-09', 3),
(10, 'Elena', 'Castro', 'elena.castro@example.com', '8899001122', '2024-02-09', 1),
(11, 'Robin', 'Alza', 'dasdsadsadasdsad@gmail.com', '213213213', '2025-02-12', 11);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Cliente`
--
ALTER TABLE `Cliente`
  ADD PRIMARY KEY (`idCliente`),
  ADD KEY `fk_Cliente_Vendedor1_idx` (`Vendedor_idVendedor`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `Cliente`
--
ALTER TABLE `Cliente`
  MODIFY `idCliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `Cliente`
--
ALTER TABLE `Cliente`
  ADD CONSTRAINT `fk_Cliente_Vendedor1` FOREIGN KEY (`Vendedor_idVendedor`) REFERENCES `vendedor` (`idVendedor`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
