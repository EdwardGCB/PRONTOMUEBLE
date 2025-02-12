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

    public function __construct($numero = "", $idPersona = 0)
    {
        $this->numero = $numero;
        $this->idPersona = $idPersona;
    }

    public function consultarNumerosProveedor()
    {
        $numeros = array();
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $telefonoDAO = new TelefonoDAO(null, $this->idPersona);
        $conexion->ejecutarConsulta($telefonoDAO->consultarNumerosProveedor());
        if ($conexion->numeroFilas() == 0) {
            $conexion->cerrarConexion();
            return $numeros;
        }
        
        while ($resultado = $conexion->siguienteRegistro()) {
            array_push($numeros, $resultado[0]);
        }
        $conexion->cerrarConexion();
        return $numeros;
    }
    public function consultarNumerosCliente()
    {
        $numeros = array();
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $telefonoDAO = new TelefonoDAO(null, $this->idPersona);
        $conexion->ejecutarConsulta($telefonoDAO->consultarNumerosCliente());
        if ($conexion->numeroFilas() == 0) {
            $conexion->cerrarConexion();
            return $numeros;
        }
        
        while ($resultado = $conexion->siguienteRegistro()) {
            array_push($numeros, $resultado[0]);
        }
        $conexion->cerrarConexion();
        return $numeros;
    }

    public function consultarNumerosVendedor()
    {
        $numeros = array();
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $telefonoDAO = new TelefonoDAO(null, $this->idPersona);
        $conexion->ejecutarConsulta($telefonoDAO->consultarNumerosVendedor());
        if ($conexion->numeroFilas() == 0) {
            $conexion->cerrarConexion();
            return $numeros;
        }
        while ($resultado = $conexion->siguienteRegistro()) {
            array_push($numeros, $resultado[0]);
        }
        $conexion->cerrarConexion();
        return $numeros;
    }

    public function guardarProveedor(){
        $conexion = new Conexion();
        $telefonoDAO = new TelefonoDAO($this->numero, $this->idPersona);
        $conexion->abrirConexion();
        $conexion->ejecutarConsulta($telefonoDAO->guardarProveedor());
        $conexion->cerrarConexion();
    }

    public function guardarVendedor(){
        $conexion = new Conexion();
        $telefonoDAO = new TelefonoDAO($this->numero, $this->idPersona);
        $conexion->abrirConexion();
        $conexion->ejecutarConsulta($telefonoDAO->guardarVendedor());
        $conexion->cerrarConexion();
    }

    public function guardarCliente(){
        $conexion = new Conexion();
        $telefonoDAO = new TelefonoDAO($this->numero, $this->idPersona);
        $conexion->abrirConexion();
        $conexion->ejecutarConsulta($telefonoDAO->guardarCliente());
        $conexion->cerrarConexion();
    }
}
