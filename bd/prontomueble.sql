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
-- Volcado de datos para la tabla `cotizacion`
--

INSERT INTO `cotizacion` (`cantidad`, `Cliente_idCliente`, `Vendedor_idVendedor`, `PedidoProveedor_Proveedor_idProveedor`, `PedidoProveedor_Mueble_idMueble`) VALUES
(1, 1, 2, 3, 4),
(2, 2, 3, 4, 5),
(1, 3, 4, 5, 6),
(3, 4, 5, 6, 7),
(2, 5, 6, 7, 8),
(1, 6, 7, 8, 9),
(4, 7, 8, 9, 10),
(3, 8, 9, 10, 11),
(2, 9, 10, 11, 12),
(1, 10, 11, 12, 13),
(4, 11, 12, 13, 14),
(3, 12, 13, 14, 15),
(2, 13, 14, 15, 16),
(1, 14, 15, 16, 17),
(4, 15, 16, 17, 18),
(3, 16, 17, 18, 19),
(2, 17, 18, 19, 20),
(1, 18, 19, 20, 21),
(4, 19, 20, 21, 22),
(3, 20, 21, 22, 23);

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
(6, 'Escritorio', 'Escritorio moderno de oficina', 'escritorio_moderno.jpg', 3, 1),
(7, 'Cama doble', 'Cama matrimonial con colchón incluido', 'cama_doble.jpg', 4, 5),
(8, 'Silla de jardín', 'Silla plegable para exterior', 'silla_jardin.jpg', 5, 6),
(9, 'Mesa auxiliar', 'Mesa pequeña para salón', 'mesa_auxiliar.jpg', 6, 3),
(10, 'Lámpara de pie', 'Lámpara de pie de estilo moderno', 'lampara_pie.jpg', 7, 4),
(11, 'Banco de almacenamiento', 'Banco de almacenamiento para sala', 'banco_almacenaje.jpg', 8, 2),
(12, 'Silla de comedor', 'Silla para comedor de madera', 'silla_comedor.jpg', 9, 2),
(13, 'Cama individual', 'Cama de una plaza para dormitorio', 'cama_individual.jpg', 10, 5),
(14, 'Mesa de trabajo', 'Mesa de trabajo de oficina en forma de L', 'mesa_trabajo.jpg', 1, 1),
(15, 'Armario', 'Armario de madera con puertas corredizas', 'armario.jpg', 2, 7),
(16, 'Espejo', 'Espejo de cuerpo entero con marco dorado', 'espejo.jpg', 3, 8),
(17, 'Librero', 'Librero de madera con varias estanterías', 'librero.jpg', 4, 2),
(18, 'Sillón reclinable', 'Sillón reclinable para sala de estar', 'sillon_reclinable.jpg', 5, 3),
(19, 'Mesa de noche', 'Mesa pequeña para colocar al lado de la cama', 'mesa_noche.jpg', 6, 5),
(20, 'Taburete', 'Taburete de madera para cocina', 'taburete.jpg', 7, 6),
(21, 'Cuna', 'Cuna para bebé con estructura de madera', 'cuna_bebe.jpg', 8, 5),
(22, 'Mueble TV', 'Mueble para colocar el televisor', 'mueble_tv.jpg', 9, 8),
(23, 'Cajonera', 'Cajonera de oficina con cuatro cajones', 'cajonera.jpg', 10, 1),
(24, 'Mesa de centro', 'Mesa de centro para sala de estar', 'mesa_centro.jpg', 1, 2),
(25, 'Perchero', 'Perchero de pie para entrada', 'perchero.jpg', 2, 7),
(26, 'Silla gamer', 'Silla ergonómica para gamers', 'silla_gamer.jpg', 3, 1),
(27, 'Mueble modular', 'Mueble modular para almacenamiento', 'mueble_modular.jpg', 4, 3),
(28, 'Silla plegable', 'Silla plegable para camping', 'silla_plegable.jpg', 5, 6),
(29, 'Colchón', 'Colchón ortopédico de alta calidad', 'colchon.jpg', 6, 5),
(30, 'Mesa de cocina', 'Mesa de cocina con sillas incluidas', 'mesa_cocina.jpg', 7, 2),
(31, 'Banco de jardín', 'Banco de jardín de hierro forjado', 'banco_jardin.jpg', 8, 6),
(32, 'Cafetera', 'Cafetera de filtro para oficina', 'cafetera.jpg', 9, 1),
(33, 'Alfombra', 'Alfombra de lana para salón', 'alfombra.jpg', 10, 4),
(34, 'Mueble de baño', 'Mueble para lavabo de baño', 'mueble_bano.jpg', 1, 5),
(35, 'Espejo de baño', 'Espejo pequeño para baño', 'espejo_bano.jpg', 2, 8),
(36, 'Silla de masaje', 'Silla de masaje para relajación', 'silla_masaje.jpg', 3, 3),
(37, 'Mueble de cocina', 'Mueble de cocina con horno integrado', 'mueble_cocina.jpg', 4, 2),
(38, 'Armario zapatero', 'Armario zapatero para almacenamiento', 'armario_zapatero.jpg', 5, 7),
(39, 'Silla de lectura', 'Silla cómoda para leer en sala', 'silla_lectura.jpg', 6, 3),
(40, 'Mesa de trabajo ajustable', 'Mesa ajustable de altura para oficina', 'mesa_trabajo_ajustable.jpg', 7, 1),
(41, 'Silla de diseño', 'Silla de diseño moderno para oficina', 'silla_diseno.jpg', 8, 1),
(42, 'Lámpara de escritorio', 'Lámpara para escritorio con base regulable', 'lampara_escritorio.jpg', 9, 4),
(43, 'Sofá cama', 'Sofá cama para huéspedes', 'sofa_cama.jpg', 10, 3),
(44, 'Consola de entrada', 'Consola pequeña para entrada de casa', 'consola_entrada.jpg', 1, 8),
(45, 'Cuna de viaje', 'Cuna portátil para bebés', 'cuna_viaje.jpg', 2, 5),
(46, 'Mesita de noche', 'Mesita de noche con cajón', 'mesita_noche.jpg', 3, 5),
(47, 'Ropero', 'Ropero de madera con varios compartimientos', 'ropero.jpg', 4, 7),
(48, 'Silla de escritorio', 'Silla de escritorio ajustable con ruedas', 'silla_escritorio.jpg', 5, 1),
(49, 'Mesa de trabajo con estante', 'Mesa con estante para almacenar cosas', 'mesa_trabajo_estante.jpg', 6, 1),
(50, 'Perchero de pared', 'Perchero que se instala en la pared', 'perchero_pared.jpg', 7, 7);
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
(10, 5, 150.00, 0.20, 1800.00, 1, 1),
(15, 7, 200.00, 0.15, 3300.00, 2, 2),
(12, 6, 180.00, 0.18, 2136.00, 3, 3),
(8, 4, 250.00, 0.10, 2200.00, 4, 4),
(18, 9, 120.00, 0.25, 2160.00, 5, 5),
(25, 12, 220.00, 0.18, 5500.00, 6, 6),
(10, 5, 170.00, 0.22, 1700.00, 7, 7),
(5, 2, 300.00, 0.30, 1500.00, 8, 8),
(30, 15, 130.00, 0.20, 3900.00, 9, 9),
(12, 6, 160.00, 0.25, 1920.00, 10, 10),
(10, 5, 250.00, 0.18, 2500.00, 1, 11),
(8, 4, 190.00, 0.23, 1520.00, 2, 12),
(14, 7, 210.00, 0.22, 2940.00, 3, 13),
(20, 10, 280.00, 0.20, 5600.00, 4, 14),
(9, 4, 150.00, 0.18, 1350.00, 5, 15),
(18, 9, 220.00, 0.15, 3960.00, 6, 16),
(15, 8, 200.00, 0.17, 3000.00, 7, 17),
(7, 3, 270.00, 0.18, 1890.00, 8, 18),
(13, 6, 180.00, 0.20, 2340.00, 9, 19),
(16, 8, 200.00, 0.18, 3200.00, 10, 20),
(10, 5, 160.00, 0.22, 1600.00, 1, 21),
(22, 11, 240.00, 0.15, 5280.00, 2, 22),
(11, 5, 210.00, 0.25, 2310.00, 3, 23),
(14, 7, 250.00, 0.12, 3500.00, 4, 24),
(19, 9, 150.00, 0.30, 2850.00, 5, 25),
(10, 5, 230.00, 0.22, 2300.00, 6, 26),
(16, 8, 180.00, 0.25, 2880.00, 7, 27),
(12, 6, 270.00, 0.20, 3240.00, 8, 28),
(20, 10, 130.00, 0.18, 2600.00, 9, 29),
(13, 6, 250.00, 0.15, 3250.00, 10, 30),
(22, 11, 200.00, 0.20, 4400.00, 1, 31),
(8, 4, 180.00, 0.18, 1440.00, 2, 32),
(18, 9, 220.00, 0.20, 3960.00, 3, 33),
(15, 7, 230.00, 0.18, 3450.00, 4, 34),
(7, 3, 250.00, 0.25, 1750.00, 5, 35),
(10, 5, 200.00, 0.20, 2000.00, 6, 36),
(14, 7, 180.00, 0.22, 2520.00, 7, 37),
(9, 4, 220.00, 0.18, 1980.00, 8, 38),
(13, 6, 160.00, 0.20, 2080.00, 9, 39),
(12, 6, 210.00, 0.15, 2520.00, 10, 40),
(8, 4, 230.00, 0.18, 1840.00, 1, 41),
(15, 7, 220.00, 0.17, 3300.00, 2, 42),
(11, 5, 200.00, 0.20, 2200.00, 3, 43),
(16, 8, 180.00, 0.22, 2880.00, 4, 44),
(10, 5, 240.00, 0.18, 2400.00, 5, 45),
(20, 10, 210.00, 0.25, 4200.00, 6, 46),
(12, 6, 230.00, 0.20, 2760.00, 7, 47),
(14, 7, 170.00, 0.23, 2380.00, 8, 48),
(18, 9, 250.00, 0.30, 4500.00, 9, 49),
(13, 6, 190.00, 0.22, 2470.00, 10, 50);


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
('Mueble de oficina', 1, 1),
('Silla ergonómica', 2, 2),
('Escritorio con cajones', 3, 3),
('Mesa de reuniones', 4, 4),
('Lámpara de escritorio', 5, 5),
('Estantería de madera', 6, 6),
('Silla de comedor', 7, 7),
('Sofá de dos plazas', 8, 8),
('Mesa de comedor', 9, 9),
('Silla de oficina ajustable', 10, 10),
('Mueble de cocina', 11, 11),
('Lámpara de pie', 12, 12),
('Escritorio con vidrio', 13, 13),
('Sillón reclinable', 14, 14),
('Mesa auxiliar', 15, 15),
('Estantería metálica', 16, 16),
('Taburete alto', 17, 17),
('Silla tapizada', 18, 18),
('Escritorio minimalista', 19, 19),
('Mueble modular', 20, 20);

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
(6, 'Marta Ramírez', 'Suministros Ramírez', 'Calle la Paz 101', '6789012345', 'proveedor6.jpg', 6),
(7, 'José Díaz', 'Comercial Díaz', 'Calle 32, Local 3', '7890123456', 'proveedor7.jpg', 7),
(8, 'Lucía Gómez', 'Gómez Electronics', 'Av. Libertad 220', '8901234567', 'proveedor8.jpg', 8),
(9, 'Raúl Hernández', 'Hernández S.A.', 'Calle 88, Frente al parque', '9012345678', 'proveedor9.jpg', 9),
(10, 'Elena Álvarez', 'Alvarez Distribuidores', 'Av. 9 de Julio 11', '0123456789', 'proveedor10.jpg', 10),
(11, 'Mario Jiménez', 'Jiménez Tecnología', 'Calle de los Reyes 5', '1122334455', 'proveedor11.jpg', 1),
(12, 'Isabel Morales', 'Industrias Morales', 'Callejón 44, Edificio B', '2233445566', 'proveedor12.jpg', 2),
(13, 'Andrés Fernández', 'Fábrica Fernández', 'Calle 9, Zona Industrial', '3344556677', 'proveedor13.jpg', 3),
(14, 'Sofía Cruz', 'Cruz Suministros', 'Calle del Río 55', '4455667788', 'proveedor14.jpg', 4),
(15, 'Javier Torres', 'Torres & Co.', 'Av. del Sur 60', '5566778899', 'proveedor15.jpg', 5),
(16, 'Carmen Jiménez', 'Soluciones Jiménez', 'Calle 7, Centro Comercial', '6677889900', 'proveedor16.jpg', 6),
(17, 'Antonio Vázquez', 'Vázquez Logística', 'Calle 21, Edificio C', '7788990011', 'proveedor17.jpg', 7),
(18, 'Patricia Ruiz', 'Ruiz Distribuciones', 'Calle del Sol 88', '8899001122', 'proveedor18.jpg', 8),
(19, 'Ricardo Paredes', 'Paredes Materiales', 'Calle 25, Plaza Mayor', '9900112233', 'proveedor19.jpg', 9),
(20, 'Sara Alonso', 'Alonso Suministros', 'Av. 4 de Octubre 33', '1011122334', 'proveedor20.jpg', 10),
(21, 'Álvaro Mendoza', 'Mendoza S.A.', 'Calle 7, Edificio D', '1122334455', 'proveedor21.jpg', 1),
(22, 'María Vega', 'Vega & Asociados', 'Callejón 16, Piso 2', '2233445566', 'proveedor22.jpg', 2),
(23, 'David Gil', 'Gil Distribuidores', 'Calle 10, Local 7', '3344556677', 'proveedor23.jpg', 3),
(24, 'Silvia Luna', 'Luna Electrodomésticos', 'Av. 6 de Agosto 90', '4455667788', 'proveedor24.jpg', 4),
(25, 'Eduardo Ruiz', 'Ruiz Muebles', 'Calle 50, Edificio F', '5566778899', 'proveedor25.jpg', 5),
(26, 'Teresa Serrano', 'Serrano & Co.', 'Calle Independencia 35', '6677889900', 'proveedor26.jpg', 6),
(27, 'Fernando Castro', 'Castro Mobiliario', 'Calle 13, Zona 5', '7788990011', 'proveedor27.jpg', 7),
(28, 'Julia Guerra', 'Guerra Servicios', 'Calle del Norte 22', '8899001122', 'proveedor28.jpg', 8),
(29, 'Carlos Guzmán', 'Guzmán Electrodomésticos', 'Calle 15, Piso 3', '9900112233', 'proveedor29.jpg', 9),
(30, 'Martín López', 'López Muebles', 'Av. San Juan 58', '1011122334', 'proveedor30.jpg', 10),
(31, 'Beatriz Romero', 'Romero Distribuciones', 'Calle 31, Local 9', '1122334455', 'proveedor31.jpg', 1),
(32, 'Felipe Pinto', 'Pinto & Co.', 'Av. Las Flores 65', '2233445566', 'proveedor32.jpg', 2),
(33, 'Raquel Navarro', 'Navarro Servicios', 'Calle 19, Piso 4', '3344556677', 'proveedor33.jpg', 3),
(34, 'Óscar Martín', 'Martín Logística', 'Calle Madero 45', '4455667788', 'proveedor34.jpg', 4),
(35, 'Iván Muñoz', 'Muñoz Suministros', 'Callejón 12, Local 8', '5566778899', 'proveedor35.jpg', 5),
(36, 'Norma Cabrera', 'Cabrera & Cía.', 'Calle 60, Edificio H', '6677889900', 'proveedor36.jpg', 6),
(37, 'Victor Vargas', 'Vargas Mobiliario', 'Calle 22, Frente a Plaza', '7788990011', 'proveedor37.jpg', 7),
(38, 'Esther Silva', 'Silva Muebles', 'Calle 11, Zona 6', '8899001122', 'proveedor38.jpg', 8),
(39, 'Jaime Hernández', 'Hernández Electrodomésticos', 'Av. 3 de Febrero 33', '9900112233', 'proveedor39.jpg', 9),
(40, 'Mónica Campos', 'Campos Servicios', 'Calle 7, Edificio I', '1011122334', 'proveedor40.jpg', 10),
(41, 'Ricardo Villar', 'Villar Proveedores', 'Calle Real 80', '1122334455', 'proveedor41.jpg', 1),
(42, 'Lidia Blanco', 'Blanco Suministros', 'Calle 21, Edificio J', '2233445566', 'proveedor42.jpg', 2),
(43, 'Luis Ferrer', 'Ferrer & Asociados', 'Calle 37, Local 6', '3344556677', 'proveedor43.jpg', 3),
(44, 'Antonio González', 'González Suministros', 'Calle 43, Piso 7', '4455667788', 'proveedor44.jpg', 4),
(45, 'Estela Ríos', 'Ríos Distribuciones', 'Calle Central 15', '5566778899', 'proveedor45.jpg', 5),
(46, 'Oscar Gutiérrez', 'Gutiérrez Proveedores', 'Calle 29, Zona 8', '6677889900', 'proveedor46.jpg', 6),
(47, 'Teresa Herrera', 'Herrera Servicios', 'Callejón 18, Local 9', '7788990011', 'proveedor47.jpg', 7),
(48, 'Victor Bravo', 'Bravo Electrodomésticos', 'Calle 10, Edificio K', '8899001122', 'proveedor48.jpg', 8),
(49, 'José Moreno', 'Moreno & Co.', 'Calle 12, Piso 4', '9900112233', 'proveedor49.jpg', 9),
(50, 'María Sánchez', 'Sánchez Proveedores', 'Av. Mirador 25', '1011122334', 'proveedor50.jpg', 10);


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
(12345678901, 1),
(12345678902, 1),
(12345678903, 2),
(12345678904, 2),
(12345678905, 3),
(12345678906, 3),
(12345678907, 4),
(12345678908, 4),
(12345678909, 5),
(12345678910, 5),
(12345678911, 6),
(12345678912, 6),
(12345678913, 7),
(12345678914, 7),
(12345678915, 8),
(12345678916, 8),
(12345678917, 9),
(12345678918, 9),
(12345678919, 10),
(12345678920, 10),
(12345678921, 11),
(12345678922, 11),
(12345678923, 12),
(12345678924, 12),
(12345678925, 13),
(12345678926, 13),
(12345678927, 14),
(12345678928, 14),
(12345678929, 15),
(12345678930, 15),
(12345678931, 16),
(12345678932, 16),
(12345678933, 17),
(12345678934, 17),
(12345678935, 18),
(12345678936, 18),
(12345678937, 19),
(12345678938, 19),
(12345678939, 20),
(12345678940, 20),
(12345678941, 21),
(12345678942, 21),
(12345678943, 22),
(12345678944, 22),
(12345678945, 23),
(12345678946, 23),
(12345678947, 24),
(12345678948, 24),
(12345678949, 25),
(12345678950, 25);
x

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
(98765432101, 1),
(98765432102, 1),
(98765432103, 2),
(98765432104, 2),
(98765432105, 3),
(98765432106, 3),
(98765432107, 4),
(98765432108, 4),
(98765432109, 5),
(98765432110, 5),
(98765432111, 6),
(98765432112, 6),
(98765432113, 7),
(98765432114, 7),
(98765432115, 8),
(98765432116, 8),
(98765432117, 9),
(98765432118, 9),
(98765432119, 10),
(98765432120, 10),
(98765432121, 11),
(98765432122, 11),
(98765432123, 12),
(98765432124, 12),
(98765432125, 13),
(98765432126, 13),
(98765432127, 14),
(98765432128, 14),
(98765432129, 15),
(98765432130, 15),
(98765432131, 16),
(98765432132, 16),
(98765432133, 17),
(98765432134, 17),
(98765432135, 18),
(98765432136, 18),
(98765432137, 19),
(98765432138, 19),
(98765432139, 20),
(98765432140, 20),
(98765432141, 21),
(98765432142, 21),
(98765432143, 22),
(98765432144, 22),
(98765432145, 23),
(98765432146, 23),
(98765432147, 24),
(98765432148, 24),
(98765432149, 25),
(98765432150, 25);


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
(55512345601, 1),
(55512345602, 1),
(55512345603, 2),
(55512345604, 2),
(55512345605, 3),
(55512345606, 3),
(55512345607, 4),
(55512345608, 4),
(55512345609, 5),
(55512345610, 5),
(55512345611, 6),
(55512345612, 6),
(55512345613, 7),
(55512345614, 7),
(55512345615, 8),
(55512345616, 8),
(55512345617, 9),
(55512345618, 9),
(55512345619, 10),
(55512345620, 10),
(55512345621, 11),
(55512345622, 11),
(55512345623, 12),
(55512345624, 12),
(55512345625, 13),
(55512345626, 13),
(55512345627, 14),
(55512345628, 14),
(55512345629, 15),
(55512345630, 15),
(55512345631, 16),
(55512345632, 16),
(55512345633, 17),
(55512345634, 17),
(55512345635, 18),
(55512345636, 18),
(55512345637, 19),
(55512345638, 19),
(55512345639, 20),
(55512345640, 20),
(55512345641, 21),
(55512345642, 21),
(55512345643, 22),
(55512345644, 22),
(55512345645, 23),
(55512345646, 23),
(55512345647, 24),
(55512345648, 24),
(55512345649, 25),
(55512345650, 25);

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
