<?php
require_once (__DIR__.'../../persistence/Conexion.php');
require(__DIR__.'../../persistence/TelefonoDAO.php');
class Telefono
{
    private $numero;
    private $idPersona;

    public function getNumero()
    {
        return $this->numero;
    }
    public function setNumero($numero)
    {
        $this->numero = $numero;
    }

    public function __construct($numero = "", $idPersona = 0, $tabla = "")
    {
        $this->numero = $numero;
        $this->idPersona = $idPersona;
    }

    public function consultarNumerosProveedor()
    {
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $telefonoDAO = new TelefonoDAO(null, $this->idPersona);
        $conexion->ejecutarConsulta($telefonoDAO->consultarNumerosProveedor());
        if ($conexion->numeroFilas() == 0) {
            $conexion->cerrarConexion();
            return false;
        }
        $numeros = array();
        while ($resultado = $conexion->siguienteRegistro()) {
            array_push($numeros, $resultado[0]);
        }
        $conexion->cerrarConexion();
        return $numeros;
    }
    public function consultarNumerosCliente()
    {
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $telefonoDAO = new TelefonoDAO(null, $this->idPersona);
        $conexion->ejecutarConsulta($telefonoDAO->consultarNumerosCliente());
        if ($conexion->numeroFilas() == 0) {
            $conexion->cerrarConexion();
            return false;
        }
        $numeros = array();
        while ($resultado = $conexion->siguienteRegistro()) {
            array_push($numeros, $resultado[0]);
        }
        $conexion->cerrarConexion();
        return $numeros;
    }

    public function consultarNumerosVendedor()
    {
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $telefonoDAO = new TelefonoDAO(null, $this->idPersona);
        $conexion->ejecutarConsulta($telefonoDAO->consultarNumerosVendedor());
        if ($conexion->numeroFilas() == 0) {
            $conexion->cerrarConexion();
            return false;
        }
        $numeros = array();
        while ($resultado = $conexion->siguienteRegistro()) {
            array_push($numeros, $resultado[0]);
        }
        $conexion->cerrarConexion();
        return $numeros;
    }
}
