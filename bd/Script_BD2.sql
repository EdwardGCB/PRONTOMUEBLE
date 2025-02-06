-- -----------------------------------------------------
-- Creación de la base de datos
-- -----------------------------------------------------
CREATE DATABASE IF NOT EXISTS `PRONTOMUEBLE` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `PRONTOMUEBLE`;

-- -----------------------------------------------------
-- Tabla Administrador
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Administrador` (
  `idAdministrador` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `apellido` VARCHAR(45) NOT NULL,
  `correo` VARCHAR(100) NOT NULL,
  `identificacion` VARCHAR(10) NOT NULL,
  `clave` VARCHAR(100) NOT NULL,
  `img` VARCHAR(45) NULL,
  PRIMARY KEY (`idAdministrador`)
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Tabla Tipo
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Tipo` (
  `idTipo` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idTipo`)
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Tabla Mueble
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Mueble` (
  `idMueble` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `descripcion` VARCHAR(45) NOT NULL,
  `img` VARCHAR(45) NULL,
  `administrador_idAdministrador` INT NOT NULL,
  `idTipo` INT NOT NULL,
  PRIMARY KEY (`idMueble`),
  FOREIGN KEY (`administrador_idAdministrador`) REFERENCES `Administrador` (`idAdministrador`),
  FOREIGN KEY (`idTipo`) REFERENCES `Tipo` (`idTipo`)
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Tabla Proveedor
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Proveedor` (
  `idProveedor` INT NOT NULL AUTO_INCREMENT,
  `personaContacto` VARCHAR(45) NOT NULL,
  `razonSocial` VARCHAR(100) NOT NULL,
  `direccion` VARCHAR(45) NOT NULL,
  `nit` VARCHAR(45) NOT NULL,
  `img` VARCHAR(45) NULL,
  `administrador_idAdministrador` INT NOT NULL,
  PRIMARY KEY (`idProveedor`),
  FOREIGN KEY (`administrador_idAdministrador`) REFERENCES `Administrador` (`idAdministrador`)
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Tabla PedidoProveedor
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PedidoProveedor` (
  `cantidad` INT NOT NULL,
  `precio` DOUBLE NOT NULL,
  `proveedor_idProveedor` INT NOT NULL,
  `mueble_idMueble` INT NOT NULL,
  PRIMARY KEY (`proveedor_idProveedor`, `mueble_idMueble`),
  FOREIGN KEY (`proveedor_idProveedor`) REFERENCES `Proveedor` (`idProveedor`),
  FOREIGN KEY (`mueble_idMueble`) REFERENCES `Mueble` (`idMueble`)
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Tabla TelefonoP
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `TelefonoP` (
  `idTelefonoP` BIGINT NOT NULL,
  `proveedor_idProveedor` INT NOT NULL,
  PRIMARY KEY (`idTelefonoP`),
  FOREIGN KEY (`proveedor_idProveedor`) REFERENCES `Proveedor` (`idProveedor`)
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Tabla Propiedad
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Propiedad` (
  `idPropiedad` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `tipo_idTipo` INT NOT NULL,
  PRIMARY KEY (`idPropiedad`),
  FOREIGN KEY (`tipo_idTipo`) REFERENCES `Tipo` (`idTipo`)
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Tabla PropiedadMueble
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PropiedadMueble` (
  `descripcion` VARCHAR(45) NOT NULL,
  `propiedad_idPropiedad` INT NOT NULL,
  `mueble_idMueble` INT NOT NULL,
  PRIMARY KEY (`propiedad_idPropiedad`, `mueble_idMueble`),
  FOREIGN KEY (`propiedad_idPropiedad`) REFERENCES `Propiedad` (`idPropiedad`),
  FOREIGN KEY (`mueble_idMueble`) REFERENCES `Mueble` (`idMueble`)
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Tabla Vendedor
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Vendedor` (
  `idVendedor` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `apellido` VARCHAR(45) NOT NULL,
  `correo` VARCHAR(100) NOT NULL,
  `identificacion` VARCHAR(10) NOT NULL,
  `clave` VARCHAR(100) NOT NULL,
  `img` VARCHAR(45) NULL,
  `administrador_idAdministrador` INT NOT NULL,
  PRIMARY KEY (`idVendedor`),
  FOREIGN KEY (`administrador_idAdministrador`) REFERENCES `Administrador` (`idAdministrador`)
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Tabla TelefonoV
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `TelefonoV` (
  `idTelefonoV` BIGINT NOT NULL,
  `vendedor_idVendedor` INT NOT NULL,
  PRIMARY KEY (`idTelefonoV`),
  FOREIGN KEY (`vendedor_idVendedor`) REFERENCES `Vendedor` (`idVendedor`)
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Tabla Cliente
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Cliente` (
  `idCliente` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `apellido` VARCHAR(45) NOT NULL,
  `correo` VARCHAR(100) NOT NULL,
  `identificacion` VARCHAR(10) NOT NULL,
  `fechaCreacion` DATE NOT NULL,
  `vendedor_idVendedor` INT NOT NULL,
  PRIMARY KEY (`idCliente`),
  FOREIGN KEY (`vendedor_idVendedor`) REFERENCES `Vendedor` (`idVendedor`)
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Tabla Cotizacion
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Cotizacion` (
  `cantidad` INT NOT NULL,
  `cliente_idCliente` INT NOT NULL,
  `vendedor_idVendedor` INT NOT NULL,
  `proveedorMueble_Proveedor_idProveedor` INT NOT NULL,
  `proveedorMueble_Mueble_idMueble` INT NOT NULL,
  PRIMARY KEY (`cliente_idCliente`, `vendedor_idVendedor`, `proveedorMueble_Proveedor_idProveedor`, `proveedorMueble_Mueble_idMueble`),
  FOREIGN KEY (`cliente_idCliente`) REFERENCES `Cliente` (`idCliente`),
  FOREIGN KEY (`vendedor_idVendedor`) REFERENCES `Vendedor` (`idVendedor`),
  FOREIGN KEY (`proveedorMueble_Proveedor_idProveedor`, `proveedorMueble_Mueble_idMueble`) REFERENCES `PedidoProveedor` (`proveedor_idProveedor`, `mueble_idMueble`)
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Tabla Factura
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Factura` (
  `idFactura` INT NOT NULL AUTO_INCREMENT,
  `cantidadTotal` INT NOT NULL,
  `subTotal` DOUBLE NOT NULL,
  `fechaCreacion` DATE NOT NULL,
  `horaCreacion` TIME NOT NULL,
  `iva` INT NOT NULL,
  `total` DOUBLE NOT NULL,
  `vendedor_idVendedor` INT NOT NULL,
  `cliente_idCliente` INT NOT NULL,
  PRIMARY KEY (`idFactura`),
  FOREIGN KEY (`vendedor_idVendedor`) REFERENCES `Vendedor` (`idVendedor`),
  FOREIGN KEY (`cliente_idCliente`) REFERENCES `Cliente` (`idCliente`)
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `PRONTOMUEBLE`.`DetalleFactura`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `DetalleFactura` (
  `cantidad` INT NOT NULL,
  `precio` DOUBLE NOT NULL,
  `factura_idFactura` INT NOT NULL,
  `proveedorMueble_Proveedor_idProveedor` INT NOT NULL,
  `proveedorMueble_Mueble_idMueble` INT NOT NULL,
  PRIMARY KEY (`factura_idFactura`, `proveedorMueble_Proveedor_idProveedor`, `proveedorMueble_Mueble_idMueble`),
    FOREIGN KEY (`factura_idFactura`)
    REFERENCES `Factura` (`idFactura`),
    FOREIGN KEY (`proveedorMueble_Proveedor_idProveedor` , `proveedorMueble_Mueble_idMueble`)
    REFERENCES `PedidoProveedor` (`proveedor_idProveedor` , `mueble_idMueble`)
)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Tabla TelefonoC
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `TelefonoC` (
  `idTelefonoC` BIGINT NOT NULL,
  `cliente_idCliente` INT NOT NULL,
  PRIMARY KEY (`idTelefonoC`),
  FOREIGN KEY (`cliente_idCliente`) REFERENCES `Cliente` (`idCliente`)
) ENGINE = InnoDB;
