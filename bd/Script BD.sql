-- MySQL Script generated by MySQL Workbench
-- Wed Oct 30 12:09:14 2024
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema PRONTOMUEBLE
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema PRONTOMUEBLE
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `PRONTOMUEBLE` DEFAULT CHARACTER SET utf8 ;
USE `PRONTOMUEBLE` ;

-- -----------------------------------------------------
-- Table `PRONTOMUEBLE`.`Administrador`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PRONTOMUEBLE`.`Administrador` (
  `idAdministrador` INT NOT NULL,
  `nombre` VARCHAR(45) NOT NULL,
  `apellido` VARCHAR(45) NOT NULL,
  `correo` VARCHAR(100) NOT NULL,
  `identificacion` VARCHAR(10) NOT NULL,
  `contraseña` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`idAdministrador`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `PRONTOMUEBLE`.`Tipo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PRONTOMUEBLE`.`Tipo` (
  `idTipo` INT NOT NULL,
  `nombre` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idTipo`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `PRONTOMUEBLE`.`Mueble`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PRONTOMUEBLE`.`Mueble` (
  `idMueble` INT NOT NULL,
  `nombre` VARCHAR(45) NOT NULL,
  `descripcion` VARCHAR(45) NOT NULL,
  `Administrador_idAdministrador` INT NOT NULL,
  `Tipo_idTipo` INT NOT NULL,
  PRIMARY KEY (`idMueble`),
  INDEX `fk_Mueble_Administrador1_idx` (`Administrador_idAdministrador` ASC),
  INDEX `fk_Mueble_Tipo1_idx` (`Tipo_idTipo` ASC) VISIBLE,
  CONSTRAINT `fk_Mueble_Administrador1`
    FOREIGN KEY (`Administrador_idAdministrador`)
    REFERENCES `PRONTOMUEBLE`.`Administrador` (`idAdministrador`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Mueble_Tipo1`
    FOREIGN KEY (`Tipo_idTipo`)
    REFERENCES `PRONTOMUEBLE`.`Tipo` (`idTipo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `PRONTOMUEBLE`.`TelefonoP`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PRONTOMUEBLE`.`TelefonoP` (
  `idTelefonoP` BIGINT NOT NULL,
  PRIMARY KEY (`idTelefonoP`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `PRONTOMUEBLE`.`Soporte`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PRONTOMUEBLE`.`Soporte` (
  `idSoporte` INT NOT NULL,
  `nombre` VARCHAR(45) NOT NULL,
  `apellido` VARCHAR(45) NOT NULL,
  `correo` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idSoporte`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `PRONTOMUEBLE`.`Proveedor`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PRONTOMUEBLE`.`Proveedor` (
  `idProveedor` INT NOT NULL,
  `razonSocial` VARCHAR(45) NOT NULL,
  `direccion` VARCHAR(45) NOT NULL,
  `nit` VARCHAR(45) NOT NULL,
  `TelefonoP_idTelefonoP` BIGINT NOT NULL,
  `Soporte_idSoporte` INT NOT NULL,
  `Administrador_idAdministrador` INT NOT NULL,
  PRIMARY KEY (`idProveedor`),
  INDEX `fk_Proveedor_TelefonoP1_idx` (`TelefonoP_idTelefonoP` ASC),
  INDEX `fk_Proveedor_Soporte1_idx` (`Soporte_idSoporte` ASC),
  INDEX `fk_Proveedor_Administrador1_idx` (`Administrador_idAdministrador` ASC),
  CONSTRAINT `fk_Proveedor_TelefonoP1`
    FOREIGN KEY (`TelefonoP_idTelefonoP`)
    REFERENCES `PRONTOMUEBLE`.`TelefonoP` (`idTelefonoP`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Proveedor_Soporte1`
    FOREIGN KEY (`Soporte_idSoporte`)
    REFERENCES `PRONTOMUEBLE`.`Soporte` (`idSoporte`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Proveedor_Administrador1`
    FOREIGN KEY (`Administrador_idAdministrador`)
    REFERENCES `PRONTOMUEBLE`.`Administrador` (`idAdministrador`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `PRONTOMUEBLE`.`ProveedorMueble`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PRONTOMUEBLE`.`ProveedorMueble` (
  `cantidad` INT NOT NULL,
  `precio` DOUBLE NOT NULL,
  `Proveedor_idProveedor` INT NOT NULL,
  `Mueble_idMueble` INT NOT NULL,
  PRIMARY KEY (`Proveedor_idProveedor`, `Mueble_idMueble`),
  INDEX `fk_ProveedorMueble_Mueble1_idx` (`Mueble_idMueble` ASC),
  CONSTRAINT `fk_ProveedorMueble_Proveedor`
    FOREIGN KEY (`Proveedor_idProveedor`)
    REFERENCES `PRONTOMUEBLE`.`Proveedor` (`idProveedor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ProveedorMueble_Mueble1`
    FOREIGN KEY (`Mueble_idMueble`)
    REFERENCES `PRONTOMUEBLE`.`Mueble` (`idMueble`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `PRONTOMUEBLE`.`Propiedad`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PRONTOMUEBLE`.`Propiedad` (
  `idPropiedad` INT NOT NULL,
  `nombre` VARCHAR(45) NOT NULL,
  `Tipo_idTipo` INT NOT NULL,
  PRIMARY KEY (`idPropiedad`),
  INDEX `fk_Propiedad_Tipo1_idx` (`Tipo_idTipo` ASC),
  CONSTRAINT `fk_Propiedad_Tipo1`
    FOREIGN KEY (`Tipo_idTipo`)
    REFERENCES `PRONTOMUEBLE`.`Tipo` (`idTipo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `PRONTOMUEBLE`.`PropiedadMueble`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PRONTOMUEBLE`.`PropiedadMueble` (
  `descripcion` VARCHAR(45) NOT NULL,
  `Propiedad_idPropiedad` INT NOT NULL,
  `Mueble_idMueble` INT NOT NULL,
  PRIMARY KEY (`Propiedad_idPropiedad`, `Mueble_idMueble`),
  INDEX `fk_PropiedadMueble_Mueble1_idx` (`Mueble_idMueble` ASC),
  CONSTRAINT `fk_PropiedadMueble_Propiedad1`
    FOREIGN KEY (`Propiedad_idPropiedad`)
    REFERENCES `PRONTOMUEBLE`.`Propiedad` (`idPropiedad`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_PropiedadMueble_Mueble1`
    FOREIGN KEY (`Mueble_idMueble`)
    REFERENCES `PRONTOMUEBLE`.`Mueble` (`idMueble`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `PRONTOMUEBLE`.`TelefonoV`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PRONTOMUEBLE`.`TelefonoV` (
  `idTelefonoV` BIGINT NOT NULL,
  PRIMARY KEY (`idTelefonoV`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `PRONTOMUEBLE`.`Vendedor`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PRONTOMUEBLE`.`Vendedor` (
  `idVendedor` INT NOT NULL,
  `nombre` VARCHAR(45) NOT NULL,
  `apellido` VARCHAR(45) NOT NULL,
  `correo` VARCHAR(100) NOT NULL,
  `identificacion` VARCHAR(10) NOT NULL,
  `contraseña` VARCHAR(100) NOT NULL,
  `Administrador_idAdministrador` INT NOT NULL,
  `TelefonoV_idTelefonoV` BIGINT NOT NULL,
  PRIMARY KEY (`idVendedor`),
  INDEX `fk_Vendedor_Administrador1_idx` (`Administrador_idAdministrador` ASC),
  INDEX `fk_Vendedor_TelefonoV1_idx` (`TelefonoV_idTelefonoV` ASC),
  CONSTRAINT `fk_Vendedor_Administrador1`
    FOREIGN KEY (`Administrador_idAdministrador`)
    REFERENCES `PRONTOMUEBLE`.`Administrador` (`idAdministrador`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Vendedor_TelefonoV1`
    FOREIGN KEY (`TelefonoV_idTelefonoV`)
    REFERENCES `PRONTOMUEBLE`.`TelefonoV` (`idTelefonoV`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `PRONTOMUEBLE`.`TelefonoC`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PRONTOMUEBLE`.`TelefonoC` (
  `idTelefonoC` BIGINT NOT NULL,
  PRIMARY KEY (`idTelefonoC`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `PRONTOMUEBLE`.`Cliente`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PRONTOMUEBLE`.`Cliente` (
  `idCliente` INT NOT NULL,
  `nombre` VARCHAR(45) NOT NULL,
  `apellido` VARCHAR(45) NOT NULL,
  `correo` VARCHAR(100) NOT NULL,
  `identificacion` VARCHAR(10) NOT NULL,
  `contraseña` VARCHAR(100) NOT NULL,
  `fecha` DATE NOT NULL,
  `TelefonoC_idTelefonoC` BIGINT NOT NULL,
  `Vendedor_idVendedor` INT NOT NULL,
  PRIMARY KEY (`idCliente`),
  INDEX `fk_Cliente_TelefonoC1_idx` (`TelefonoC_idTelefonoC` ASC),
  INDEX `fk_Cliente_Vendedor1_idx` (`Vendedor_idVendedor` ASC),
  CONSTRAINT `fk_Cliente_TelefonoC1`
    FOREIGN KEY (`TelefonoC_idTelefonoC`)
    REFERENCES `PRONTOMUEBLE`.`TelefonoC` (`idTelefonoC`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cliente_Vendedor1`
    FOREIGN KEY (`Vendedor_idVendedor`)
    REFERENCES `PRONTOMUEBLE`.`Vendedor` (`idVendedor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `PRONTOMUEBLE`.`Cotizacion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PRONTOMUEBLE`.`Cotizacion` (
  `cantidad` INT NOT NULL,
  `Mueble_idMueble` INT NOT NULL,
  `Cliente_idCliente` INT NOT NULL,
  `Vendedor_idVendedor` INT NOT NULL,
  PRIMARY KEY (`Mueble_idMueble`, `Cliente_idCliente`, `Vendedor_idVendedor`),
  INDEX `fk_Cotizacion_Cliente1_idx` (`Cliente_idCliente` ASC),
  INDEX `fk_Cotizacion_Vendedor1_idx` (`Vendedor_idVendedor` ASC),
  CONSTRAINT `fk_Cotizacion_Mueble1`
    FOREIGN KEY (`Mueble_idMueble`)
    REFERENCES `PRONTOMUEBLE`.`Mueble` (`idMueble`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cotizacion_Cliente1`
    FOREIGN KEY (`Cliente_idCliente`)
    REFERENCES `PRONTOMUEBLE`.`Cliente` (`idCliente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cotizacion_Vendedor1`
    FOREIGN KEY (`Vendedor_idVendedor`)
    REFERENCES `PRONTOMUEBLE`.`Vendedor` (`idVendedor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `PRONTOMUEBLE`.`Factura`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PRONTOMUEBLE`.`Factura` (
  `idFactura` INT NOT NULL,
  `cantidadTotal` INT NOT NULL,
  `subTotal` DOUBLE NOT NULL,
  `fecha` DATE NOT NULL,
  `hora` TIME NOT NULL,
  `iva` INT NOT NULL,
  `total` DOUBLE NOT NULL,
  `Vendedor_idVendedor` INT NOT NULL,
  `Cliente_idCliente` INT NOT NULL,
  PRIMARY KEY (`idFactura`),
  INDEX `fk_Factura_Vendedor1_idx` (`Vendedor_idVendedor` ASC),
  INDEX `fk_Factura_Cliente1_idx` (`Cliente_idCliente` ASC),
  CONSTRAINT `fk_Factura_Vendedor1`
    FOREIGN KEY (`Vendedor_idVendedor`)
    REFERENCES `PRONTOMUEBLE`.`Vendedor` (`idVendedor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Factura_Cliente1`
    FOREIGN KEY (`Cliente_idCliente`)
    REFERENCES `PRONTOMUEBLE`.`Cliente` (`idCliente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `PRONTOMUEBLE`.`DetalleFactura`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PRONTOMUEBLE`.`DetalleFactura` (
  `cantidad` INT NOT NULL,
  `precio` DOUBLE NOT NULL,
  `Mueble_idMueble` INT NOT NULL,
  `Factura_idFactura` INT NOT NULL,
  PRIMARY KEY (`Mueble_idMueble`, `Factura_idFactura`),
  INDEX `fk_DetalleFactura_Factura1_idx` (`Factura_idFactura` ASC),
  CONSTRAINT `fk_DetalleFactura_Mueble1`
    FOREIGN KEY (`Mueble_idMueble`)
    REFERENCES `PRONTOMUEBLE`.`Mueble` (`idMueble`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_DetalleFactura_Factura1`
    FOREIGN KEY (`Factura_idFactura`)
    REFERENCES `PRONTOMUEBLE`.`Factura` (`idFactura`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;