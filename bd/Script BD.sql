-- -----------------------------------------------------
-- Schema PRONTOMUEBLE
-- -----------------------------------------------------
CREATE DATABASE PRONTOMUEBLE DEFAULT CHARACTER SET utf8;

-- -----------------------------------------------------
-- Table Administrador
-- -----------------------------------------------------
CREATE TABLE Administrador (
  `idAdministrador` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `apellido` VARCHAR(45) NOT NULL,
  `correo` VARCHAR(100) NOT NULL,
  `identificacion` VARCHAR(10) NOT NULL,
  `clave` VARCHAR(45) NOT NULL,
  `img` VARCHAR(45) NULL,
  PRIMARY KEY (`idAdministrador`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table Tipo
-- -----------------------------------------------------
CREATE TABLE Tipo (
  `idTipo` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idTipo`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table Mueble
-- -----------------------------------------------------
CREATE TABLE Mueble (
  `idMueble` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `descripcion` VARCHAR(45) NOT NULL,
  `img` VARCHAR(45) NULL,
  `Administrador_idAdministrador` INT NOT NULL,
  `Tipo_idTipo` INT NOT NULL,
  PRIMARY KEY (`idMueble`),
  INDEX `fk_Mueble_Administrador1_idx` (`Administrador_idAdministrador`),
  INDEX `fk_Mueble_Tipo1_idx` (`Tipo_idTipo`),
  CONSTRAINT `fk_Mueble_Administrador1`
    FOREIGN KEY (`Administrador_idAdministrador`)
    REFERENCES `PRONTOMUEBLE`.`Administrador` (`idAdministrador`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Mueble_Tipo1`
    FOREIGN KEY (`Tipo_idTipo`)
    REFERENCES `Tipo` (`idTipo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table Proveedor
-- -----------------------------------------------------
CREATE TABLE Proveedor (
  `idProveedor` INT NOT NULL AUTO_INCREMENT,
  `personaContacto` VARCHAR(45) NOT NULL,
  `razonSocial` VARCHAR(100) NOT NULL,
  `direccion` VARCHAR(45) NOT NULL,
  `nit` VARCHAR(45) NOT NULL,
  `img` VARCHAR(45) NULL,
  `Administrador_idAdministrador` INT NOT NULL,
  PRIMARY KEY (`idProveedor`),
  INDEX `fk_Proveedor_Administrador1_idx` (`Administrador_idAdministrador`),
  CONSTRAINT `fk_Proveedor_Administrador1`
    FOREIGN KEY (`Administrador_idAdministrador`)
    REFERENCES `Administrador` (`idAdministrador`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table PedidoProveedor
-- -----------------------------------------------------
CREATE TABLE PedidoProveedor (
  `cantidadPost` INT NOT NULL,
  `cantidadPre` INT NOT NULL,
  `precio` DOUBLE NOT NULL,
  `ganancia` FLOAT NOT NULL,
  `precioFinal` DOUBLE NOT NULL,
  `Proveedor_idProveedor` INT NOT NULL,
  `Mueble_idMueble` INT NOT NULL,
  PRIMARY KEY (`Proveedor_idProveedor`, `Mueble_idMueble`),
  INDEX `fk_ProveedorMueble_Mueble1_idx` (`Mueble_idMueble`),
  CONSTRAINT `fk_ProveedorMueble_Proveedor`
    FOREIGN KEY (`Proveedor_idProveedor`)
    REFERENCES `PRONTOMUEBLE`.`Proveedor` (`idProveedor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ProveedorMueble_Mueble1`
    FOREIGN KEY (`Mueble_idMueble`)
    REFERENCES `Mueble` (`idMueble`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table TelefonoP
-- -----------------------------------------------------
CREATE TABLE TelefonoP (
  `idTelefonoP` BIGINT NOT NULL,
  `Proveedor_idProveedor` INT NOT NULL,
  PRIMARY KEY (`idTelefonoP`),
  INDEX `fk_TelefonoP_Proveedor1_idx` (`Proveedor_idProveedor`),
  CONSTRAINT `fk_TelefonoP_Proveedor1`
    FOREIGN KEY (`Proveedor_idProveedor`)
    REFERENCES `Proveedor` (`idProveedor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table Propiedad
-- -----------------------------------------------------
CREATE TABLE Propiedad (
  `idPropiedad` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `Tipo_idTipo` INT NOT NULL,
  PRIMARY KEY (`idPropiedad`),
  INDEX `fk_Propiedad_Tipo1_idx` (`Tipo_idTipo`),
  CONSTRAINT `fk_Propiedad_Tipo1`
    FOREIGN KEY (`Tipo_idTipo`)
    REFERENCES `Tipo` (`idTipo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table PropiedadMueble
-- -----------------------------------------------------
CREATE TABLE PropiedadMueble (
  `descripcion` VARCHAR(45) NOT NULL,
  `Propiedad_idPropiedad` INT NOT NULL,
  `Mueble_idMueble` INT NOT NULL,
  PRIMARY KEY (`Propiedad_idPropiedad`, `Mueble_idMueble`),
  INDEX `fk_PropiedadMueble_Mueble1_idx` (`Mueble_idMueble`),
  CONSTRAINT `fk_PropiedadMueble_Propiedad1`
    FOREIGN KEY (`Propiedad_idPropiedad`)
    REFERENCES `PRONTOMUEBLE`.`Propiedad` (`idPropiedad`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_PropiedadMueble_Mueble1`
    FOREIGN KEY (`Mueble_idMueble`)
    REFERENCES `Mueble` (`idMueble`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table Vendedor
-- -----------------------------------------------------
CREATE TABLE Vendedor (
  `idVendedor` INT NOT NULL,
  `nombre` VARCHAR(45) NOT NULL,
  `apellido` VARCHAR(45) NOT NULL,
  `correo` VARCHAR(100) NOT NULL,
  `identificacion` VARCHAR(10) NOT NULL,
  `clave` VARCHAR(45) NOT NULL,
  `img` VARCHAR(45) NULL,
  `Administrador_idAdministrador` INT NOT NULL,
  PRIMARY KEY (`idVendedor`),
  INDEX `fk_Vendedor_Administrador1_idx` (`Administrador_idAdministrador`),
  CONSTRAINT `fk_Vendedor_Administrador1`
    FOREIGN KEY (`Administrador_idAdministrador`)
    REFERENCES `Administrador` (`idAdministrador`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table TelefonoV
-- -----------------------------------------------------
CREATE TABLE TelefonoV (
  `idTelefonoV` BIGINT NOT NULL,
  `Vendedor_idVendedor` INT NOT NULL,
  PRIMARY KEY (`idTelefonoV`),
  INDEX `fk_TelefonoV_Vendedor1_idx` (`Vendedor_idVendedor`),
  CONSTRAINT `fk_TelefonoV_Vendedor1`
    FOREIGN KEY (`Vendedor_idVendedor`)
    REFERENCES `PRONTOMUEBLE`.`Vendedor` (`idVendedor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table Cliente
-- -----------------------------------------------------
CREATE TABLE Cliente (
  `idCliente` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `apellido` VARCHAR(45) NOT NULL,
  `correo` VARCHAR(100) NOT NULL,
  `identificacion` VARCHAR(10) NOT NULL,
  `fechaCreacion` DATE NOT NULL,
  `Vendedor_idVendedor` INT NOT NULL,
  PRIMARY KEY (`idCliente`),
  INDEX `fk_Cliente_Vendedor1_idx` (`Vendedor_idVendedor`),
  CONSTRAINT `fk_Cliente_Vendedor1`
    FOREIGN KEY (`Vendedor_idVendedor`)
    REFERENCES `PRONTOMUEBLE`.`Vendedor` (`idVendedor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table Cotizacion
-- -----------------------------------------------------
CREATE TABLE Cotizacion (
  `cantidad` INT NOT NULL,
  `Cliente_idCliente` INT NOT NULL,
  `Vendedor_idVendedor` INT NOT NULL,
  `PedidoProveedor_Proveedor_idProveedor` INT NOT NULL,
  `PedidoProveedor_Mueble_idMueble` INT NOT NULL,
  PRIMARY KEY (`Cliente_idCliente`, `Vendedor_idVendedor`, `PedidoProveedor_Proveedor_idProveedor`, `PedidoProveedor_Mueble_idMueble`),
  INDEX `fk_Cotizacion_Cliente1_idx` (`Cliente_idCliente`),
  INDEX `fk_Cotizacion_Vendedor1_idx` (`Vendedor_idVendedor`),
  INDEX `fk_Cotizacion_PedidoProveedor1_idx` (`PedidoProveedor_Proveedor_idProveedor`, `PedidoProveedor_Mueble_idMueble`),
  CONSTRAINT `fk_Cotizacion_Cliente1`
    FOREIGN KEY (`Cliente_idCliente`)
    REFERENCES `Cliente` (`idCliente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cotizacion_Vendedor1`
    FOREIGN KEY (`Vendedor_idVendedor`)
    REFERENCES `Vendedor` (`idVendedor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cotizacion_PedidoProveedor1`
    FOREIGN KEY (`PedidoProveedor_Proveedor_idProveedor` , `PedidoProveedor_Mueble_idMueble`)
    REFERENCES `PedidoProveedor` (`Proveedor_idProveedor` , `Mueble_idMueble`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table Factura
-- -----------------------------------------------------
CREATE TABLE Factura (
  `idFactura` INT NOT NULL,
  `cantidad` INT NOT NULL,
  `subTotal` DOUBLE NOT NULL,
  `fechaCreacion` DATE NOT NULL,
  `horaCreacion` TIME NOT NULL,
  `iva` INT NOT NULL,
  `total` DOUBLE NOT NULL,
  `Vendedor_idVendedor` INT NOT NULL,
  `Cliente_idCliente` INT NOT NULL,
  PRIMARY KEY (`idFactura`),
  INDEX `fk_Factura_Vendedor1_idx` (`Vendedor_idVendedor`),
  INDEX `fk_Factura_Cliente1_idx` (`Cliente_idCliente`),
  CONSTRAINT `fk_Factura_Vendedor1`
    FOREIGN KEY (`Vendedor_idVendedor`)
    REFERENCES `Vendedor` (`idVendedor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Factura_Cliente1`
    FOREIGN KEY (`Cliente_idCliente`)
    REFERENCES `Cliente` (`idCliente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table DetalleFactura
-- -----------------------------------------------------
CREATE TABLE DetalleFactura (
  `cantidad` INT NOT NULL,
  `precio` DOUBLE NOT NULL,
  `Factura_idFactura` INT NOT NULL,
  `PedidoProveedor_Proveedor_idProveedor` INT NOT NULL,
  `PedidoProveedor_Mueble_idMueble` INT NOT NULL,
  PRIMARY KEY (`Factura_idFactura`, `PedidoProveedor_Proveedor_idProveedor`, `PedidoProveedor_Mueble_idMueble`),
  INDEX `fk_DetalleFactura_Factura1_idx` (`Factura_idFactura`),
  INDEX `fk_DetalleFactura_PedidoProveedor1_idx` (`PedidoProveedor_Proveedor_idProveedor`, `PedidoProveedor_Mueble_idMueble`),
  CONSTRAINT `fk_DetalleFactura_Factura1`
    FOREIGN KEY (`Factura_idFactura`)
    REFERENCES `Factura` (`idFactura`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_DetalleFactura_PedidoProveedor1`
    FOREIGN KEY (`PedidoProveedor_Proveedor_idProveedor` , `PedidoProveedor_Mueble_idMueble`)
    REFERENCES `PedidoProveedor` (`Proveedor_idProveedor` , `Mueble_idMueble`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table TelefonoC
-- -----------------------------------------------------
CREATE TABLE TelefonoC (
  `idTelefonoC` BIGINT NOT NULL,
  `Cliente_idCliente` INT NOT NULL,
  PRIMARY KEY (`idTelefonoC`),
  INDEX `fk_TelefonoC_Cliente1_idx` (`Cliente_idCliente`),
  CONSTRAINT `fk_TelefonoC_Cliente1`
    FOREIGN KEY (`Cliente_idCliente`)
    REFERENCES `Cliente` (`idCliente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

