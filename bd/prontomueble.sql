-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-02-2025 a las 17:25:20
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

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `MoverCotizacionADetalle` ()   BEGIN
    -- Insertar en DetalleFactura la información eliminada de Cotizacion
    INSERT INTO DetalleFactura (cantidad, precio, Factura_idFactura, PedidoProveedor_Proveedor_idProveedor, PedidoProveedor_Mueble_idMueble)
    VALUES (
        OLD.cantidad,
        (SELECT precioFinal 
         FROM PedidoProveedor 
         WHERE PedidoProveedor.Proveedor_idProveedor = OLD.PedidoProveedor_Proveedor_idProveedor
         AND PedidoProveedor.Mueble_idMueble = OLD.PedidoProveedor_Mueble_idMueble
         LIMIT 1),
        (SELECT idFactura 
         FROM Factura 
         WHERE Cliente_idCliente = (SELECT Cliente_idCliente FROM Cotizacion WHERE cantidad = OLD.cantidad LIMIT 1)
         ORDER BY fechaCreacion DESC LIMIT 1),
        OLD.PedidoProveedor_Proveedor_idProveedor,
        OLD.PedidoProveedor_Mueble_idMueble
    );

    -- Actualizar cantidadPost en PedidoProveedor
    UPDATE PedidoProveedor
    SET cantidadPost = cantidadPost - OLD.cantidad
    WHERE Proveedor_idProveedor = OLD.PedidoProveedor_Proveedor_idProveedor
    AND Mueble_idMueble = OLD.PedidoProveedor_Mueble_idMueble;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `administrador` (
  `idAdministrador` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `apellido` varchar(45) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `identificacion` varchar(10) NOT NULL,
  `clave` varchar(45) NOT NULL,
  `img` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `administrador`
--

INSERT INTO `administrador` (`idAdministrador`, `nombre`, `apellido`, `correo`, `identificacion`, `clave`, `img`) VALUES
(1, 'Robinson', 'Alza', 'R.alza@PRONTOMUEBLE.com', '1234567890', '202cb962ac59075b964b07152d234b70', NULL),
(2, 'Edward', 'Castillo', 'E.castillo@PRONTOMUEBLE.com', '9876543210', '202cb962ac59075b964b07152d234b70', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
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
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`idCliente`, `nombre`, `apellido`, `correo`, `identificacion`, `fechaCreacion`, `Vendedor_idVendedor`) VALUES
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cotizacion`
--

CREATE TABLE `cotizacion` (
  `cantidad` int(11) NOT NULL,
  `Cliente_idCliente` int(11) NOT NULL,
  `Vendedor_idVendedor` int(11) NOT NULL,
  `PedidoProveedor_Proveedor_idProveedor` int(11) NOT NULL,
  `PedidoProveedor_Mueble_idMueble` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Disparadores `cotizacion`
--
DELIMITER $$
CREATE TRIGGER `trigger_mover_cotizacion` AFTER DELETE ON `cotizacion` FOR EACH ROW BEGIN
    -- Llamar al procedimiento almacenado para mover los datos
    CALL MoverCotizacionADetalle();
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallefactura`
--

CREATE TABLE `detallefactura` (
  `cantidad` int(11) NOT NULL,
  `precio` double NOT NULL,
  `Factura_idFactura` int(11) NOT NULL,
  `PedidoProveedor_Proveedor_idProveedor` int(11) NOT NULL,
  `PedidoProveedor_Mueble_idMueble` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `idFactura` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `subTotal` double NOT NULL,
  `fechaCreacion` date NOT NULL,
  `horaCreacion` time NOT NULL,
  `iva` int(11) NOT NULL,
  `total` double NOT NULL,
  `Vendedor_idVendedor` int(11) NOT NULL,
  `Cliente_idCliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mueble`
--

CREATE TABLE `mueble` (
  `idMueble` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  `img` varchar(45) DEFAULT NULL,
  `Administrador_idAdministrador` int(11) NOT NULL,
  `Tipo_idTipo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mueble`
--

INSERT INTO `mueble` (`idMueble`, `nombre`, `descripcion`, `img`, `Administrador_idAdministrador`, `Tipo_idTipo`) VALUES
(1, 'asdasdsa', 'sadasdasd', 'defaul.png', 2, 2),
(2, 'asdasdsa', 'sadasdasd', 'defaul.png', 2, 2),
(3, 'sadsadsad', 'sadasdasd', 'defaul.png', 2, 21),
(4, 'Estante para cocina', 'Estante con finos acabados en madera y acero ', 'defaul.png', 2, 3),
(5, 'Estante para cocina', 'Estante con finos acabados en madera y acero ', 'defaul.png', 2, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidoproveedor`
--

CREATE TABLE `pedidoproveedor` (
  `cantidadPost` int(11) NOT NULL,
  `cantidadPre` int(11) NOT NULL,
  `precio` double NOT NULL,
  `ganancia` float NOT NULL,
  `precioFinal` double NOT NULL,
  `Proveedor_idProveedor` int(11) NOT NULL,
  `Mueble_idMueble` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidoproveedor`
--

INSERT INTO `pedidoproveedor` (`cantidadPost`, `cantidadPre`, `precio`, `ganancia`, `precioFinal`, `Proveedor_idProveedor`, `Mueble_idMueble`) VALUES
(10, 0, 300000, 0.23, 300690, 3, 5),
(4, 2, 250000, 0.23, 250575, 5, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `propiedad`
--

CREATE TABLE `propiedad` (
  `idPropiedad` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `Tipo_idTipo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `propiedad`
--

INSERT INTO `propiedad` (`idPropiedad`, `nombre`, `Tipo_idTipo`) VALUES
(1, 'Material', 1),
(2, 'Color', 1),
(3, 'Tamaño', 1),
(4, 'Peso', 1),
(5, 'Material', 2),
(6, 'Color', 2),
(7, 'Tamaño', 2),
(8, 'Peso', 2),
(9, 'Material', 3),
(10, 'Color', 3),
(11, 'Tamaño', 3),
(12, 'Peso', 3),
(13, 'Material', 4),
(14, 'Color', 4),
(15, 'Tamaño', 4),
(16, 'Peso', 4),
(17, 'Material', 5),
(18, 'Color', 5),
(19, 'Tamaño', 5),
(20, 'Peso', 5),
(21, 'Material', 6),
(22, 'Color', 6),
(23, 'Tamaño', 6),
(24, 'Peso', 6),
(25, 'Material', 7),
(26, 'Color', 7),
(27, 'Tamaño', 7),
(28, 'Peso', 7),
(29, 'Material', 8),
(30, 'Color', 8),
(31, 'Tamaño', 8),
(32, 'Peso', 8),
(33, 'Material', 9),
(34, 'Color', 9),
(35, 'Tamaño', 9),
(36, 'Peso', 9),
(37, 'Material', 10),
(38, 'Color', 10),
(39, 'Tamaño', 10),
(40, 'Peso', 10),
(41, 'Material', 11),
(42, 'Color', 11),
(43, 'Tamaño', 11),
(44, 'Peso', 11),
(45, 'Material', 12),
(46, 'Color', 12),
(47, 'Tamaño', 12),
(48, 'Peso', 12),
(49, 'Material', 13),
(50, 'Color', 13),
(51, 'Tamaño', 13),
(52, 'Peso', 13),
(53, 'Material', 14),
(54, 'Color', 14),
(55, 'Tamaño', 14),
(56, 'Peso', 14),
(57, 'Material', 15),
(58, 'Color', 15),
(59, 'Tamaño', 15),
(60, 'Peso', 15),
(61, 'Material', 16),
(62, 'Color', 16),
(63, 'Tamaño', 16),
(64, 'Peso', 16),
(65, 'Material', 17),
(66, 'Color', 17),
(67, 'Tamaño', 17),
(68, 'Peso', 17),
(69, 'Material', 18),
(70, 'Color', 18),
(71, 'Tamaño', 18),
(72, 'Peso', 18),
(73, 'Material', 19),
(74, 'Color', 19),
(75, 'Tamaño', 19),
(76, 'Peso', 19),
(77, 'Material', 20),
(78, 'Color', 20),
(79, 'Tamaño', 20),
(80, 'Peso', 20),
(84, 'Color', 21),
(85, 'Peso', 21);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `propiedadmueble`
--

CREATE TABLE `propiedadmueble` (
  `descripcion` varchar(45) NOT NULL,
  `Propiedad_idPropiedad` int(11) NOT NULL,
  `Mueble_idMueble` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `propiedadmueble`
--

INSERT INTO `propiedadmueble` (`descripcion`, `Propiedad_idPropiedad`, `Mueble_idMueble`) VALUES
('asdasdsad', 6, 1),
('asdasdsad', 6, 2),
('Madera', 9, 4),
('Madera', 9, 5),
('sadasd', 85, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `idProveedor` int(11) NOT NULL,
  `personaContacto` varchar(45) NOT NULL,
  `razonSocial` varchar(100) NOT NULL,
  `direccion` varchar(45) NOT NULL,
  `nit` varchar(45) NOT NULL,
  `img` varchar(45) DEFAULT NULL,
  `Administrador_idAdministrador` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`idProveedor`, `personaContacto`, `razonSocial`, `direccion`, `nit`, `img`, `Administrador_idAdministrador`) VALUES
(3, 'david duque', 'Magico Mundo', 'cra 6 c este nro 90d 21 sur', '2133312', 'default.png', 2),
(5, 'alisson', 'Morenos', 'cra 6 c este nro 90d 21 sur', '231323', 'default.png', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `telefonoc`
--

CREATE TABLE `telefonoc` (
  `idTelefonoC` bigint(20) NOT NULL,
  `Cliente_idCliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `telefonoc`
--

INSERT INTO `telefonoc` (`idTelefonoC`, `Cliente_idCliente`) VALUES
(123213213, 11);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `telefonop`
--

CREATE TABLE `telefonop` (
  `idTelefonoP` bigint(20) NOT NULL,
  `Proveedor_idProveedor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `telefonop`
--

INSERT INTO `telefonop` (`idTelefonoP`, `Proveedor_idProveedor`) VALUES
(3000000000, 3),
(3000000001, 3),
(3000000002, 3),
(30012343253, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `telefonov`
--

CREATE TABLE `telefonov` (
  `idTelefonoV` bigint(20) NOT NULL,
  `Vendedor_idVendedor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `telefonov`
--

INSERT INTO `telefonov` (`idTelefonoV`, `Vendedor_idVendedor`) VALUES
(3028021967, 11);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo`
--

CREATE TABLE `tipo` (
  `idTipo` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo`
--

INSERT INTO `tipo` (`idTipo`, `nombre`) VALUES
(1, 'Sofá'),
(2, 'Silla'),
(3, 'Mesa de comedor'),
(4, 'Escritorio'),
(5, 'Cama'),
(6, 'Cómoda'),
(7, 'Armario'),
(8, 'Estantería'),
(9, 'Banco'),
(10, 'Mesa de centro'),
(11, 'Silla de oficina'),
(12, 'Mueble para TV'),
(13, 'Vitrina'),
(14, 'Perchero'),
(15, 'Zapatero'),
(16, 'Tocador'),
(17, 'Mesita de noche'),
(18, 'Taburete'),
(19, 'Cuna'),
(20, 'Sillón reclinable'),
(21, 'Baños');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vendedor`
--

CREATE TABLE `vendedor` (
  `idVendedor` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `apellido` varchar(45) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `identificacion` varchar(10) NOT NULL,
  `clave` varchar(45) NOT NULL,
  `img` varchar(45) DEFAULT NULL,
  `Administrador_idAdministrador` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vendedor`
--

INSERT INTO `vendedor` (`idVendedor`, `nombre`, `apellido`, `correo`, `identificacion`, `clave`, `img`, `Administrador_idAdministrador`) VALUES
(1, 'Carlos', 'Mendoza', 'carlos.mendoza@example.com', '1234567890', 'eb52fc9a4b3a81a2000a9e774d5aa515', 'default_perfil.jpg', 1),
(2, 'Andrea', 'García', 'andrea.garcia@example.com', '0987654321', '380759fb2b96a5904f2a3d4ec571b6ae', 'default_perfil.jpg', 1),
(3, 'Fernando', 'López', 'fernando.lopez@example.com', '1122334455', '5c7d813ce20d3e16962efd589b7e0549', 'default_perfil.jpg', 2),
(4, 'Beatriz', 'Martínez', 'beatriz.martinez@example.com', '2233445566', 'b984fe77863037ddeb9be2ad7dfb246e', 'default_perfil.jpg', 2),
(5, 'Diego', 'Sánchez', 'diego.sanchez@example.com', '3344556677', '6df960c10cdaf092c153a6dd4da0424c', 'default_perfil.jpg', 2),
(6, 'Mónica', 'Rodríguez', 'monica.rodriguez@example.com', '4455667788', '3114b2a7c2fc9e282d56c3ab6528661e', 'default_perfil.jpg', 1),
(7, 'Hugo', 'Fernández', 'hugo.fernandez@example.com', '5566778899', '8cac6cee8223173e9c31d814bdf304b7', 'default_perfil.jpg', 1),
(8, 'Patricia', 'Torres', 'patricia.torres@example.com', '6677889900', '690162610dae5242ca8aebf97720567a', 'default_perfil.jpg', 2),
(9, 'Ricardo', 'Díaz', 'ricardo.diaz@example.com', '7788990011', '3d33d9a0066f4601054bbbfa0e6ff760', 'default_perfil.jpg', 2),
(10, 'Valeria', 'Castro', 'valeria.castro@example.com', '8899001122', 'f0e88ab9fb980ece24ebe78179f51246', 'default_perfil.jpg', 1),
(11, 'Edward', 'Castillo', 'edwcastillo230@gmail.com', '1010961040', '6b5e311f642752e9c687eeb4ee9e05d8', 'default.png', 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`idAdministrador`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`idCliente`),
  ADD KEY `fk_Cliente_Vendedor1_idx` (`Vendedor_idVendedor`);

--
-- Indices de la tabla `cotizacion`
--
ALTER TABLE `cotizacion`
  ADD PRIMARY KEY (`Cliente_idCliente`,`Vendedor_idVendedor`,`PedidoProveedor_Proveedor_idProveedor`,`PedidoProveedor_Mueble_idMueble`),
  ADD KEY `fk_Cotizacion_Cliente1_idx` (`Cliente_idCliente`),
  ADD KEY `fk_Cotizacion_Vendedor1_idx` (`Vendedor_idVendedor`),
  ADD KEY `fk_Cotizacion_PedidoProveedor1_idx` (`PedidoProveedor_Proveedor_idProveedor`,`PedidoProveedor_Mueble_idMueble`);

--
-- Indices de la tabla `detallefactura`
--
ALTER TABLE `detallefactura`
  ADD PRIMARY KEY (`Factura_idFactura`,`PedidoProveedor_Proveedor_idProveedor`,`PedidoProveedor_Mueble_idMueble`),
  ADD KEY `fk_DetalleFactura_Factura1_idx` (`Factura_idFactura`),
  ADD KEY `fk_DetalleFactura_PedidoProveedor1_idx` (`PedidoProveedor_Proveedor_idProveedor`,`PedidoProveedor_Mueble_idMueble`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`idFactura`),
  ADD KEY `fk_Factura_Vendedor1_idx` (`Vendedor_idVendedor`),
  ADD KEY `fk_Factura_Cliente1_idx` (`Cliente_idCliente`);

--
-- Indices de la tabla `mueble`
--
ALTER TABLE `mueble`
  ADD PRIMARY KEY (`idMueble`),
  ADD KEY `fk_Mueble_Administrador1_idx` (`Administrador_idAdministrador`),
  ADD KEY `fk_Mueble_Tipo1_idx` (`Tipo_idTipo`);

--
-- Indices de la tabla `pedidoproveedor`
--
ALTER TABLE `pedidoproveedor`
  ADD PRIMARY KEY (`Proveedor_idProveedor`,`Mueble_idMueble`),
  ADD KEY `fk_ProveedorMueble_Mueble1_idx` (`Mueble_idMueble`);

--
-- Indices de la tabla `propiedad`
--
ALTER TABLE `propiedad`
  ADD PRIMARY KEY (`idPropiedad`),
  ADD KEY `fk_Propiedad_Tipo1_idx` (`Tipo_idTipo`);

--
-- Indices de la tabla `propiedadmueble`
--
ALTER TABLE `propiedadmueble`
  ADD PRIMARY KEY (`Propiedad_idPropiedad`,`Mueble_idMueble`),
  ADD KEY `fk_PropiedadMueble_Mueble1_idx` (`Mueble_idMueble`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`idProveedor`),
  ADD KEY `fk_Proveedor_Administrador1_idx` (`Administrador_idAdministrador`);

--
-- Indices de la tabla `telefonoc`
--
ALTER TABLE `telefonoc`
  ADD PRIMARY KEY (`idTelefonoC`),
  ADD KEY `fk_TelefonoC_Cliente1_idx` (`Cliente_idCliente`);

--
-- Indices de la tabla `telefonop`
--
ALTER TABLE `telefonop`
  ADD PRIMARY KEY (`idTelefonoP`),
  ADD KEY `fk_TelefonoP_Proveedor1_idx` (`Proveedor_idProveedor`);

--
-- Indices de la tabla `telefonov`
--
ALTER TABLE `telefonov`
  ADD PRIMARY KEY (`idTelefonoV`),
  ADD KEY `fk_TelefonoV_Vendedor1_idx` (`Vendedor_idVendedor`);

--
-- Indices de la tabla `tipo`
--
ALTER TABLE `tipo`
  ADD PRIMARY KEY (`idTipo`);

--
-- Indices de la tabla `vendedor`
--
ALTER TABLE `vendedor`
  ADD PRIMARY KEY (`idVendedor`),
  ADD KEY `fk_Vendedor_Administrador1_idx` (`Administrador_idAdministrador`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administrador`
--
ALTER TABLE `administrador`
  MODIFY `idAdministrador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `idCliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `mueble`
--
ALTER TABLE `mueble`
  MODIFY `idMueble` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `propiedad`
--
ALTER TABLE `propiedad`
  MODIFY `idPropiedad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `idProveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tipo`
--
ALTER TABLE `tipo`
  MODIFY `idTipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `vendedor`
--
ALTER TABLE `vendedor`
  MODIFY `idVendedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `fk_Cliente_Vendedor1` FOREIGN KEY (`Vendedor_idVendedor`) REFERENCES `vendedor` (`idVendedor`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `cotizacion`
--
ALTER TABLE `cotizacion`
  ADD CONSTRAINT `fk_Cotizacion_Cliente1` FOREIGN KEY (`Cliente_idCliente`) REFERENCES `cliente` (`idCliente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Cotizacion_PedidoProveedor1` FOREIGN KEY (`PedidoProveedor_Proveedor_idProveedor`,`PedidoProveedor_Mueble_idMueble`) REFERENCES `pedidoproveedor` (`Proveedor_idProveedor`, `Mueble_idMueble`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Cotizacion_Vendedor1` FOREIGN KEY (`Vendedor_idVendedor`) REFERENCES `vendedor` (`idVendedor`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detallefactura`
--
ALTER TABLE `detallefactura`
  ADD CONSTRAINT `fk_DetalleFactura_Factura1` FOREIGN KEY (`Factura_idFactura`) REFERENCES `factura` (`idFactura`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_DetalleFactura_PedidoProveedor1` FOREIGN KEY (`PedidoProveedor_Proveedor_idProveedor`,`PedidoProveedor_Mueble_idMueble`) REFERENCES `pedidoproveedor` (`Proveedor_idProveedor`, `Mueble_idMueble`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `fk_Factura_Cliente1` FOREIGN KEY (`Cliente_idCliente`) REFERENCES `cliente` (`idCliente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Factura_Vendedor1` FOREIGN KEY (`Vendedor_idVendedor`) REFERENCES `vendedor` (`idVendedor`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `mueble`
--
ALTER TABLE `mueble`
  ADD CONSTRAINT `fk_Mueble_Administrador1` FOREIGN KEY (`Administrador_idAdministrador`) REFERENCES `administrador` (`idAdministrador`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Mueble_Tipo1` FOREIGN KEY (`Tipo_idTipo`) REFERENCES `tipo` (`idTipo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `pedidoproveedor`
--
ALTER TABLE `pedidoproveedor`
  ADD CONSTRAINT `fk_ProveedorMueble_Mueble1` FOREIGN KEY (`Mueble_idMueble`) REFERENCES `mueble` (`idMueble`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ProveedorMueble_Proveedor` FOREIGN KEY (`Proveedor_idProveedor`) REFERENCES `proveedor` (`idProveedor`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `propiedad`
--
ALTER TABLE `propiedad`
  ADD CONSTRAINT `fk_Propiedad_Tipo1` FOREIGN KEY (`Tipo_idTipo`) REFERENCES `tipo` (`idTipo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `propiedadmueble`
--
ALTER TABLE `propiedadmueble`
  ADD CONSTRAINT `fk_PropiedadMueble_Mueble1` FOREIGN KEY (`Mueble_idMueble`) REFERENCES `mueble` (`idMueble`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_PropiedadMueble_Propiedad1` FOREIGN KEY (`Propiedad_idPropiedad`) REFERENCES `propiedad` (`idPropiedad`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD CONSTRAINT `fk_Proveedor_Administrador1` FOREIGN KEY (`Administrador_idAdministrador`) REFERENCES `administrador` (`idAdministrador`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `telefonoc`
--
ALTER TABLE `telefonoc`
  ADD CONSTRAINT `fk_TelefonoC_Cliente1` FOREIGN KEY (`Cliente_idCliente`) REFERENCES `cliente` (`idCliente`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `telefonop`
--
ALTER TABLE `telefonop`
  ADD CONSTRAINT `fk_TelefonoP_Proveedor1` FOREIGN KEY (`Proveedor_idProveedor`) REFERENCES `proveedor` (`idProveedor`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `telefonov`
--
ALTER TABLE `telefonov`
  ADD CONSTRAINT `fk_TelefonoV_Vendedor1` FOREIGN KEY (`Vendedor_idVendedor`) REFERENCES `vendedor` (`idVendedor`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `vendedor`
--
ALTER TABLE `vendedor`
  ADD CONSTRAINT `fk_Vendedor_Administrador1` FOREIGN KEY (`Administrador_idAdministrador`) REFERENCES `administrador` (`idAdministrador`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
